@include('partials.headers.mobile.group-site')
<div class="header-sp">
    @include('partials.headers.mobile.common-header')
</div>
@include('partials.components.mobile.slider')
<script type="text/javascript">
$(function() {
    $('.banner_slider').slick({
        dots: true, // スライダー下部に表示される、ドット状のページネーション
        infinite: true, // 無限ループ
        speed: 300, // 切り替わりのスピード
        autoplay: true, // オートプレイ
        autoplaySpeed: 4000, //オートプレイスピード4秒
        pauseOnFocus: false,
        /*fade: true*/
    });
});
</script>
