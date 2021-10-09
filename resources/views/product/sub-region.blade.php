<p class="title-top-u title-top-u-2">
    <span class="span-txt-pc-genre"></span>
    <a href="javascript:void(0)" class="show-root-genre-pc">〈 すべてに戻る</a>
</p>
<div class="div-top-ajax">
    <ul class="clearfix ul-list-railline ul-list-genre-pc">
        <li><a href="{{ route('product.index', ['genre_id' => $genreId]) }}" class="all not-redirect cursor-ponter {{ ($categoryId ==  $genreId) ? 'be-active' : ''}}" data-search="genre" data-genre-id="{{$genreId}}" data-text="{{ $categoryName }}">全て</a></li>
        @foreach($categories as $key => $categorie)
            <li><a href="{{ route('product.index', ['genre_id' => $categorie->product_category_id]) }}" class="not-redirect cursor-ponter {{ ($categoryId ==  $categorie->product_category_id) ? 'be-active' : ''}}" data-search="genre" data-genre-id="{{$categorie->product_category_id}}">{{ $categorie->category_name }}</a></li>
        @endforeach
    </ul>
</div>
