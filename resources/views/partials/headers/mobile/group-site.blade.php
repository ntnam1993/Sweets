{{--<div id="epark_common_groupheader">--}}
    {{--<p>ひとつのIDでさまざまな施設の順番待ち・予約が可能</p>--}}
    {{--<p>EPARKグループ</p>--}}
{{--</div>--}}
<script>setMytopinfoLoader();</script>
<!--モーダル-->
{{--<div id="epark_common_groupmodal">--}}
    {{--<iframe src="https://parts.epark.jp/epark-common/group_list/index.html" scrolling="no" frameborder="0"></iframe>--}}
    {{--<button type="button" class="epark_common_groupheader_close">閉じる</button>--}}
{{--</div>--}}

{{--<script type="text/javascript">--}}
    {{--$(function() {--}}
        {{--'use strict';--}}
        {{--$('#epark_common_groupheader').click(function() {--}}
            {{--//modal蜑企勁--}}
            {{--if ($(this).hasClass('active')) {--}}
                {{--$('#epark_common_groupmodal').stop(true, false).slideUp('fast',--}}
                    {{--function() {--}}
                        {{--$('#epark_common_groupheader').removeClass('active');--}}
                    {{--}--}}
                {{--);--}}
            {{--} else {--}}
                {{--//modal陦ｨ遉ｺ--}}
                {{--$('#epark_common_groupmodal').stop(true, false).slideDown('fast');--}}
                {{--$('#epark_common_groupheader').addClass('active');--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}


    {{--$(function() {--}}
        {{--'use strict';--}}
        {{--$('.epark_common_groupheader_close').click(function() {--}}
            {{--if ($('#epark_common_groupheader').hasClass('active')) {--}}
                {{--$('#epark_common_groupmodal').stop(true, false).fadeOut('fast',--}}
                    {{--function() {--}}
                        {{--$('#epark_common_groupheader').removeClass('active');--}}
                    {{--}--}}
                {{--);--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}


    {{--window.addEventListener('message', function(e) {--}}
        {{--'use strict';--}}
        {{--if (e.origin === "http://www.epark.jp/event/special/thanks_members/") {--}}
            {{--document.getElementById('content-frame').height = e.data;--}}
        {{--}--}}
    {{--}, false);--}}

    {{--(function () {--}}
        {{--var target = document.getElementById('epark_common_groupmodal');--}}
        {{--var observer = new MutationObserver(function (mutations) {--}}
            {{--mutations.forEach(function (mutationRecord) {--}}
                {{--if ($('#epark_common_groupmodal').css('display') == 'block') {--}}
                    {{--$('body').css('position', 'fixed');--}}
                {{--} else {--}}
                    {{--$('body').css('position', 'static');--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
        {{--observer.observe(target, { attributes : true, attributeFilter : ['style'] });--}}
    {{--})();--}}
{{--</script>--}}
