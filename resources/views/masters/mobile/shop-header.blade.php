<div class="header-sp">
    @include ('partials.headers.mobile.group-site')
    @include ('partials.headers.mobile.common-header')
</div>
@if(in_array($current_route_name, ['shop.index', 'shop.coupon', 'shop.menu', 'shop.comments', 'shop.map', 'noShopSearch']) || !empty($keyShowBanner))
    <div class="banner-after-header">
        @include('partials.components.mobile.campaign-banner')
    </div>
@endif
<script type="text/javascript">
    $('.link-top').on('click', function(){
        localStorage.setItem("flg_key_word", "0");
        window.location = "{{ route('index') }}";
    });
</script>
<script type="text/javascript">
    $(document).on('click','.showMenu', function(){
        $('#mn-not-login').fadeIn(400);
        $('.b-cl-mn').fadeIn(400);
        $('.over').fadeIn(400);
    });
    $(document).on('click', '.b-cl-mn', function(){
        $('#mn-not-login').fadeOut(400);
        $('.b-cl-mn').fadeOut(400);
        $('.over').fadeOut(400);
    });
    $(document).on('click', '.over', function(){
        $('#mn-not-login').fadeOut(400);
        $('.b-cl-mn').fadeOut(400);
        $('.over').fadeOut(400);
    });
</script>
