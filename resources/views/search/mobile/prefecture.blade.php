@extends('layouts.mobile.search')
@section('title', '都道府県｜EPARKスイーツガイド')
@section('content')
<div class="sp-container sp-container-bdRed clearfix">
	<h3 class="h3-noTextR"><a id="go-back">戻る</a><span>駅から探す</span></h3>
	<ul class="list-area">
		@foreach($prefectures as $prefecture)
			<li class="li-sub"><a href="{{ route('search.rail_lines', $prefecture->prov_code) }}" class="bg-img-r">{{ $prefecture->prov_name }}</a></li>
		@endforeach
	</ul>
</div>
@stop
