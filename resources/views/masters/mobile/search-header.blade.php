<div id="modal-free-search" class="modal-free-s">
    <form action="{{ request()->url() }}" method="GET">
        <div class="modal-dialog">
            <div class="modal-content data-res-area">
                <h3 class="" style="padding-left:10px;"><a data-dismiss="modal" class="cl-btn">CLOSE</a><span>検索条件入力</span></h3>
                <div class="div-wp-fr-s clearfix">
                    <input type="text" class="inp-free-s" placeholder="フリーワード" id="inp-free-s" name="keyword" value="{{ request()->keyword }}">
                    <button type="submit">検索</button>
                    @if(request()->keyword != "")
                    <span class="span-x-2-1">×</span>
                    @else
                    <span class="span-x-2-1 hide">×</span>
                    @endif
                    <div id="freeword-history"></div>
                </div>
            </div>
        </div>
        {{ Form::hidden('sort', request()->sort) }}
        @php
            $paramsexceptKeyword = request()->all();
            unset($paramsexceptKeyword['keyword']);
            unset($paramsexceptKeyword['reserve']);
            unset($paramsexceptKeyword['map']);
            unset($paramsexceptKeyword['page']);
        @endphp
        @foreach($paramsexceptKeyword as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</div>
<div class="header-sp">
    @include ('partials.headers.mobile.group-site')
    @include ('partials.headers.mobile.common-header')
</div>

@if(in_array($current_route_name, ['product.index.all', 'product.index.station', 'product.index', 'shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
  @if(!isset(request()->map))
    <div class="banner-after-header">
        @include('partials.components.mobile.family-banner')
    </div>
  @endif
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
