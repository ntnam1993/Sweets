(function() {

    if (window != window.parent) {
        //disable load in iframe
        return;
    }

    if (typeof window.EparkLoginCheck != 'undefined' ){
        return;
    }

    function parseUrl(url) {
        var a = document.createElement("a");
        a.href = url;
        var result = {
            "host" : a.host,
            "path" : a.pathname,
            "query" : a.search
        };
        delete a;
        return result;
    }

    /*
     * Create an iframe
     * @param {string} src src of iframe
     * @param {function} callbackOnload
     * function(iframe) {}
     * iframeのonloadイベントで呼ばれる関数を指定する
     * @param {object} callbackOnloadのスコープ(this)となる
     * @return IFRAME HTMLElement object
     */
    function createIframe(src, callbackOnload, scope) {
        var $iframe =  $("<iframe/>",
                 {
                     "src" : src,
                     "style" : "display:none",
                     "frameborder" : 0,
                     "load" : function() {
                         if (typeof callbackOnload === "function" ) {
                             callbackOnload.apply(scope, [$iframe[0]]);
                         };
                     }
                 });

        $iframe.appendTo("body");

        return $iframe[0];
    }

    /**
     * Parse query string into key/value object
     * @param {string} qstr
     * @return {object} {key : value}
     */
    function parse_str(qstr) {
        var params = {};
        if (typeof(qstr) !== 'string' || qstr.length == 0) {
            return params;
        }

        var qpos = qstr.indexOf("?");
        if (qpos > -1) {
            qstr = qstr.substr(qpos + 1);
        }

        var queries = qstr.split("&");
        var temp;
        for (var i = 0; i < queries.length; i++) {
            temp = queries[i].split("=");
            if (temp[0].length == 0) {
                continue;
            }
            params[temp[0]] = temp.length > 1 ? decodeURIComponent(temp[1]) : '';
        }
        return params;
    }

    /*
     * Add query parameters into url
     * @param {string} url
     * @param {JSONObject} params
     */
    function buildUrl (baseUrl, params) {
        var path;
        var qpos = baseUrl.indexOf('?');

        if (qpos > 0) {
            path = baseUrl.substring(0, qpos);
            var oldParams = parse_str(baseUrl.substring(qpos + 1));
            params = $.extend(oldParams, params);
        } else {
            path = baseUrl;
        }
        var qstr = $.param(params);
        if (qstr.length > 0) {
            return path + "?" + qstr;
        }
        return baseUrl;
    }


    var urlComponents = parseUrl(window.location);
    // don't load on control page(wysiwyg)
    if (urlComponents.host == "control.xaas.jp" ||
        urlComponents.host == "control.haisha-yoyaku.jp" ||
        urlComponents.host == "d-control.xaas.jp" ||
        urlComponents.host == "d-control.haisha-yoyaku.jp" ||
        urlComponents.host == "t-control.xaas.jp" ||
        urlComponents.host == "t-control.haisha-yoyaku.jp") {
        return;
    }

    var _EparkLoginCheck = function() {
            this.origin = '';
    }

    _EparkLoginCheck.prototype.fire = function() {
        var mypageFlg = "0";
        var urlComponents = parseUrl(window.location);
        var deferr = new $.Deferred;
        this.$$deferr = deferr;

        var urlParams = parse_str(urlComponents.query);

        if (urlParams["ssoLogin"] == "1") {
            return deferr.reject();
        }

        var loginHostComponents = parseUrl(getLoginHost());

        if (urlComponents.host == loginHostComponents.host) {
            var path = urlComponents.path.toLowerCase();
            if (path.indexOf("/login/customertemporarilyedit") >= 0 ) {
                return deferr.reject();
            }
            if (path.indexOf("/login/login/index") >= 0 || path.indexOf("/sp/login/login/index") >= 0) {
                mypageFlg = "1";
            }
            if (path.indexOf("/login/login/eparklogin") >= 0 ) {
                // An error occurred in eparklogin
                return deferr.reject();
            }
        }

        var that = this;

        // 次のOpen ID SSOを発火させる場合は、deferr.resolve();
        // 発火させたくない場合は、deferr.reject();
        $.getJSON(getHost() + '/ajax/eparklogincheck/index?mypageFlg='+ mypageFlg).done(function(response) {

            if (response.intLoginChkFlag !== '1') {
                return deferr.reject();
            }

            if (!response.eparkLoginChkUrl || !response.clientId || !response.redirectUri) {
                // 必須となる情報がとれない場合、何もしない
                return deferr.resolve(true);
            }

            that.redirectUri = decodeURIComponent(response.redirectUri);

            var redirectUriComponents = parseUrl(that.redirectUri);

            if (redirectUriComponents.path.indexOf("/preview/") != -1) {
                // プレビューの場合、何もしない
                return deferr.reject();
            }

            that.state = response.state;
            var targetOrigin = response.eparkLoginChkUrl + '?client_id=' + response.clientId + '&redirect_uri=' + response.redirectUri + '&state=' + response.state;

            that.eparkAccountDomain = parseUrl(targetOrigin).host;

            if (response.afterLoginUrlEncoded) {
                that.afterLoginUrl = decodeURIComponent(response.afterLoginUrl);
            } else {
                that.afterLoginUrl = response.afterLoginUrl;
            }
            // start EPARK SSO
            createIframe(targetOrigin, that.didLoadEparkSSOIframe, that);
        }).fail(function() {
            return deferr.resolve(true);
        })
        return deferr.promise();
    }

    /*
     * Called on EPARK SSO Iframe onload event
     */
    _EparkLoginCheck.prototype.didLoadEparkSSOIframe = function(objFrame) {
        var that = this;
        var messageHandler = function(event) {
            if ( that.didReceiveMessage(event) ) {
                window.removeEventListener("message", messageHandler);
            }
        }
        window.addEventListener("message", messageHandler);

        // this = iframe object
        objFrame.contentWindow.postMessage('eparkLogon', objFrame.getAttribute('src'));
    }

    /*
     * EPARKのシングルサイオンンiframeからのメッセジーを受信
     */
    _EparkLoginCheck.prototype.didReceiveMessage = function(event) {
        var sourceHost = parseUrl(event.origin).host;
        if (sourceHost != this.eparkAccountDomain) {
            return false;
        }

        if (typeof event.data === 'undefined' || event.data == '') {
            return this.$$deferr.resolve(true);
        }
        this.logon(event.data, this.state);
        return true;
    }

    /*
     * サービス側のログイン処理
     * @param {String} code 認可コード
     * @param {String} state CSRFトークン
     */
    _EparkLoginCheck.prototype.logon = function(code, state) {
        var that = this;
        var url = buildUrl(this.redirectUri, {"code" :code,  "state" : state, "afterLoginUrl" : this.afterLoginUrl, "autoSSOLogon" : 1});

        var messageHandler = function(event) {
            if (that.didReceiveServiceLoginMessage(event)) {
                window.removeEventListener("message", messageHandler);
            }
        }
        this.serviceLogonDomain = parseUrl(this.redirectUri).host;
        window.addEventListener("message", messageHandler);

        // cross domain
        createIframe(url, that.didLoadServiceLoginIframe, that);
    }

    /*
     * サービス側のログイン処理iframeがロードされたら実行される。
     */
    _EparkLoginCheck.prototype.didLoadServiceLoginIframe = function(objFrame) {
        // this = iframe object
        objFrame.contentWindow.postMessage("Login", objFrame.getAttribute('src'));
    }

    /*
     * サービス側のログイン処理後の処理
     */
    _EparkLoginCheck.prototype.didReceiveServiceLoginMessage = function (event) {
        var sourceHost = parseUrl(event.origin).host;

        if (sourceHost != this.serviceLogonDomain) {
            return false;
        }
        if (typeof event.data !== 'object') {
            return this.$$deferr.resolve(true);
        }

        var data = event.data;

        if (typeof data.status == 'undefined' || typeof data.redirect_url != 'string') {
            return this.$$deferr.resolve(true);
        }
        if (data.status != 200) {
            return this.$$deferr.resolve(true);
        }
        window.location = data.redirect_url;
        return true;
    }

    window.EparkLoginCheck = new _EparkLoginCheck;

    if (document.readyState == "interactive" || document.readyState == "complete" ) {
        window.EparkLoginCheck.fire();
    } else {
        if (typeof window.WebSSOBroker != 'undefined') {
            // YConnectなど複数のssoを利用する
            WebSSOBroker.registerPlugin(EparkLoginCheck);
        } else {
            // 単独で動作する
            $(function() {
                window.EparkLoginCheck.fire();
            });
        }
    }
})();
