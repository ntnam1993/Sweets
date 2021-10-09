<div class="header-sp">
    @include ('partials.headers.mobile.group-site')
    @include ('partials.headers.mobile.common-header')
</div>
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
