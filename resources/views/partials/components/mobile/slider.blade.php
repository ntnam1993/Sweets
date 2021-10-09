<script type="text/javascript">
    $(function(){
    'use scrict';

    //json繝輔ぃ繧､繝ｫ縺ｮ繝代せ
    var $jsonPath = 'https://sweetsguide.jp/docs/campaign/slider/slider.json';

    //繧｢繝九Γ繝ｼ繧ｷ繝ｧ繝ｳ繧ｹ繝斐�繝�
    var $speed = 500;
    
    //閾ｪ蜍募�逕溘∪縺ｧ縺ｮ譎る俣
    var $interval = 3000;
        
    //繧ｫ繧ｦ繝ｳ繝亥�譛溷､
    var $currentNum = 1;
    
    $.ajax({
        type: 'GET',
        url: $jsonPath,
        dataType: 'jsonp',
        jsonpCallback: 'carouselJSON',
    }).then (

        /*隱ｭ縺ｿ霎ｼ縺ｿ謌仙粥譎�*/
        function carouselJSON(json) {
            var $jsonLength = json.length;
            var $target;
            for(var i=0; i < $jsonLength; i++){
                //蛻･遯灘ｯｾ蠢�
                if(json[i].target === true){
                    $target = ' target="_blank"';
                }
                else{
                    $target = '';
                }
                $(".carousel-contents").append('<div class="item"><a href="'+json[i].link+'"'+$target+'><img src="'+json[i].img+'" alt=""></a></div>');
            }
        },
        
        /*隱ｭ縺ｿ霎ｼ縺ｿ螟ｱ謨玲凾*/
        function () {
            alert("隱ｭ縺ｿ霎ｼ縺ｿ螟ｱ謨励＠縺ｾ縺励◆");
            
    }).done(function(){
        
        //繧ｻ繝ｬ繧ｯ繧ｿ繧貞､画焚縺ｫ譬ｼ邏�
        var $view = $('.carousel-view'),
            $viewContents = $view.find('.carousel-contents'),
            $viewContentsItem = $viewContents.find('.item'),
            $viewContentsItemImg = $viewContentsItem.find('img'),
            $indicator = $('#carousel ul.list-indicator'),
            $btnPrev = $('p.prev a'),
            $btnNext = $('p.next a');
        
        //隕∫ｴ�縺ｮ謨ｰ繧貞､画焚縺ｫ譬ｼ邏�
        var $viewContentsItemLength = $viewContentsItem.length;
        
        //繧ｫ繝ｫ繝ｼ繧ｻ繝ｫ縺ｮwidth繧貞､画焚縺ｫ譬ｼ邏�
        
        var $view_width = $view.width();
        //var $viewContentsItemWidth = $viewContentsItem.width();
        
        //逕ｻ蜒上�width繧貞､画焚縺ｫ譬ｼ邏�
        var $viewContentsItemImgWidth = $viewContentsItemImg.width();

        
        
        //蜃ｦ逅�ｮ溯｡�
        $viewContents.each(function() {
            
            var autoTimer;
            
            //閾ｪ蜍輔せ繝ｩ繧､繝蛾未謨ｰ
            var autoLoad = function(){
                autoTimer = setInterval(function(){
                    rollNext();
                }, $interval);
            };
                                    
            //1蛟倶ｻ･荳翫�蝣ｴ蜷医�縺ｿ
            if($viewContentsItemLength > 0){
                
                //繧｢繧､繝�Β縺ｮdiv縺ｫwidth繧定ｨｭ螳�
                //$viewContentsItem.css('width', $viewContentsItemImgWidth);
                //$viewContentsItem.css('width', '375');
                $viewContentsItem.css('width', $view_width);
                //繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ逕滓�
                for(var i = 1;i <= $viewContentsItemLength;i++){
                    $indicator.append('<li><a href="#">'+ i +'譫夂岼</a></li>');
                }
                $indicator.find('li').first().addClass("current");
                
                //繝ｫ繝ｼ繝礼畑縺ｮ繧ｯ繝ｭ繝ｼ繝ｳ繧貞燕蠕後↓隍�｣ｽ
                $viewContentsItem.first().clone().addClass("clone-f").appendTo($viewContents);
                $viewContentsItem.last().clone().addClass("clone-l").prependTo($viewContents);
                
                //蛻晄悄繧ｫ繝ｬ繝ｳ繝�class繧剃ｻ倅ｸ�
                $viewContents.find('.clone-l').next().addClass("current");
                
                //繧｢繧､繝�Β縺ｮ謨ｰ縺ｧ蜈ｨ菴薙�width繧定ｨｭ螳夲ｼ医け繝ｭ繝ｼ繝ｳ蛻�ｒ蜷ｫ繧��
                //$viewContents.css('width', $viewContentsItemWidth * ($viewContentsItemLength + 2));
                //$viewContents.css('width', '375' * ($viewContentsItemLength + 2));
                $viewContents.css('width', $view_width * ($viewContentsItemLength + 2));
                //left繧偵け繝ｭ繝ｼ繝ｳ蛻�★繧峨＠縺ｦ1蛟狗岼縺ｮ菴咲ｽｮ縺ｫ
                //$viewContents.css('left', - $viewContentsItemWidth);
                //$viewContents.css('left', - '375');
                $viewContents.css('left', - $view_width);
                
                //閾ｪ蜍募�逕�
                autoLoad();
            }

            
            //1蛟九�蝣ｴ蜷茨ｼ医う繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ蜑企勁縲√け繝ｭ繝ｼ繝ｳ蜑企勁縲…ss繝ｪ繧ｻ繝�ヨ��
            if($viewContentsItemLength === 1){
                $btnPrev.parent().remove();
                $btnNext.parent().remove();
                $indicator.remove();
            }
            
            //蜿ｳ蝗櫁ｻ｢
            var rollNext = function(){
                clearInterval(autoTimer);
                if(!$viewContents.is(":animated")){
                    $currentNum++;
                    $viewContents.find('.current').removeClass('current').next().addClass('current');
                    $indicator.find('.current').removeClass('current');
                    $indicator.find('li').eq($currentNum - 1).addClass('current');
                    if($currentNum > $viewContentsItemLength){
                        $indicator.find('li').eq(0).addClass('current');    
                    }
                    //$viewContents.animate({ 'left': - $viewContentsItemWidth * $currentNum,
                    //$viewContents.animate({ 'left': - '375' * $currentNum,
                    $viewContents.animate({ 'left': - $view_width * $currentNum,
                    }, $speed, function() {
                        if($currentNum > $viewContentsItemLength){
                            $viewContents.find('.current').removeClass('current');
                            $viewContents.find('.clone-l').next().addClass("current");
                            //$viewContents.css('left', - $viewContentsItemWidth);
                            //$viewContents.css('left', - '375');
                            $viewContents.css('left', - $view_width);
                            $currentNum = 1;
                        }
                    });
                }
                autoLoad();
            };
                
            //蟾ｦ蝗櫁ｻ｢
            var rollPrev = function(){
                clearInterval(autoTimer);
                if(!$viewContents.is(":animated")){
                    $currentNum--;
                    $viewContents.find('.current').removeClass('current').prev().addClass('current');
                    $indicator.find('.current').removeClass('current');
                    $indicator.find('li').eq($currentNum - 1).addClass('current');
                    if($currentNum > $viewContentsItemLength){
                        $indicator.find('li').eq(0).addClass('current');    
                    }
                    //$viewContents.animate({ 'left': - $viewContentsItemWidth * $currentNum,
                    //$viewContents.animate({ 'left': - '375' * $currentNum,
                    $viewContents.animate({ 'left': - $view_width * $currentNum,
                    }, $speed, function() {
                        if($currentNum < 1){
                            $viewContents.find('.current').removeClass('current');
                            $viewContents.find('.clone-f').prev().addClass("current");
                            //$viewContents.css('left', - $viewContentsItemWidth * $viewContentsItemLength);
                            //$viewContents.css('left', - '375' * $viewContentsItemLength);
                            $viewContents.css('left', - $view_width * $viewContentsItemLength);
                            $currentNum = $viewContentsItemLength;
                        }
                    });
                }
            };
            
            //蜿ｳ繧ｯ繝ｪ繝�け
            $btnNext.click(function(){
                rollNext();
                clearInterval(autoTimer);
                return false;
            });
            
            //蟾ｦ繧ｯ繝ｪ繝�け
            $btnPrev.click(function(){
                rollPrev();
                return false;
            });
            
            //繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ繧ｯ繝ｪ繝�け
            $indicator.find('li a').click(function(){
                
                //閾ｪ蜍募�逕溘ち繧､繝槭�繧偵け繝ｪ繧｢
                clearInterval(autoTimer);
                
                if(!$viewContents.is(":animated")){
                    
                    //繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ繧､繝ｳ繝�ャ繧ｯ繧ｹ逡ｪ蜿ｷ繧貞叙蠕�
                    var $indicatorIndex = $(this).parent().index() + 1;
                    
                    //繧ｫ繧ｦ繝ｳ繝医ｒ譖ｴ譁ｰ
                    $currentNum = $indicatorIndex;
                    
                    //繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ繧ｫ繝ｬ繝ｳ繝医�class繧剃ｻ倥￠譖ｿ縺�
                    $indicator.find('.current').removeClass('current');
                    $(this).parent().addClass('current');
                    
                    //繧｢繧､繝�Β縺ｮ繧ｫ繝ｬ繝ｳ繝医�class繧剃ｻ倥￠譖ｿ縺�
                    $viewContents.find('.current').removeClass('current');
                    $viewContentsItem.eq($currentNum - 1).addClass('current');
                    
                    //繧｢繝九Γ繝ｼ繧ｷ繝ｧ繝ｳ
                    //$viewContents.animate({ 'left': - $viewContentsItemWidth * $currentNum,
                    //$viewContents.animate({ 'left': - '375' * $currentNum,
                    $viewContents.animate({ 'left': - $view_width * $currentNum,
                    }, $speed, function() {
                        
                        /*螳御ｺ�凾縺ｮ蜃ｦ逅��荳崎ｦ�*/
                        
                    });
                }
                
                return false;
                e.preventDefault();
            });
            
            //繝ｪ繧ｵ繧､繧ｺ蟇ｾ蠢�
            var $resizeTimer = false;
            $(window).resize(function() {
                if ($resizeTimer !== false) {
                    clearTimeout($resizeTimer);
                }
                $resizeTimer = setTimeout(function() {
                    
                    //width繧偵Μ繧ｻ繝�ヨ
                    $viewContents.find('div.item').css('width','auto');
                    $viewContents.css('width','auto').css('left','auto');
                    
                    //繧ｫ繝ｫ繝ｼ繧ｻ繝ｫ縺ｮwidth繧貞､画焚縺ｫ譬ｼ邏阪＠逶ｴ縺�
                    $viewContentsItemWidth = $viewContentsItem.width();
                    
                    //逕ｻ蜒上�width繧貞､画焚縺ｫ譬ｼ邏阪＠逶ｴ縺�
                    $viewContentsItemImgWidth = $viewContentsItemImg.width();
                    
                    //繧｢繧､繝�Β縺ｮdiv縺ｫwidth繧定ｨｭ螳�
                    $viewContents.find('div.item').css('width', $viewContentsItemImgWidth);
                    
                    //繧｢繧､繝�Β縺ｮ謨ｰ縺ｧ蜈ｨ菴薙�width繧定ｨｭ螳夲ｼ医け繝ｭ繝ｼ繝ｳ蛻�ｒ蜷ｫ繧��
                    //$viewContents.css('width', $viewContentsItemWidth * ($viewContentsItemLength + 2));
                    //$viewContents.css('width', '375' * ($viewContentsItemLength + 2));
                    $viewContents.css('width', $view_width * ($viewContentsItemLength + 2));
                    
                }, 200);
            });
            
            //繝槭え繧ｹ繧ｪ繝ｼ繝舌�譎ゅ�閾ｪ蜍募�逕溘ち繧､繝槭�蛛懈ｭ｢
            $view.hover(function(){
                clearInterval(autoTimer);
            }, function(){
                autoLoad();
            });
            $indicator.find('li a').hover(function(){
                clearInterval(autoTimer);
            }, function(){
                    autoLoad();
            });
            
            //繝輔Μ繝�け蟇ｾ蠢�
            $viewContents.on({
                
                //繧ｿ繝�メ髢句ｧ�
                'touchstart': function(e) {
                    this.startX = e.originalEvent.changedTouches[0].pageX;
                    this.startY = e.originalEvent.changedTouches[0].pageY;
                    this.touchX = e.originalEvent.changedTouches[0].pageX;
                    this.slideX = $(this).position().left;
                    
                    //閾ｪ蜍募�逕溘ち繧､繝槭�繧偵け繝ｪ繧｢
                    clearInterval(autoTimer);
                },
                
                //繧ｿ繝�メ遘ｻ蜍�
                'touchmove': function(e) {
                    var $moveX = this.startX - e.originalEvent.changedTouches[0].pageX,
                        $moveY = this.startY - e.originalEvent.changedTouches[0].pageY;
                    
                    //邵ｦ繧ｹ繧ｯ繝ｭ繝ｼ繝ｫ蟇ｾ蠢�
                    var $moveRate = $moveX / $moveY;
                    if($moveRate > Math.tan(15 * Math.PI/180)) {
                        e.originalEvent.preventDefault();
                    }
    
                    this.slideX = this.slideX - (this.touchX - e.originalEvent.changedTouches[0].pageX);
                    $(this).css({left:this.slideX});
                    this.touchX = e.originalEvent.changedTouches[0].pageX;
                },
                
                //繧ｿ繝�メ邨ゆｺ�
                'touchend': function(e) {
                    var $diff = this.startX - this.touchX;
                    if ($diff < -50) {
                        rollPrev();
                    }else if(50 < $diff){
                        rollNext();
                    }else{
                        $(this).animate({left:this.slideX + $diff});
                    }
                }    
            });
            
        });
    });
});
</script>