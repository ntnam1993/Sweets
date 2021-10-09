@extends('layouts.mobile.search')
@section('title', '駅｜EPARKスイーツガイド')
@section('content')
<div class="sp-container sp-container-bdRed clearfix">
	<h3 class="h3-noTextR"><a id="go-back">戻る</a><span>駅から探す</span></h3>
	<ul class="list-area">
		@foreach($stations as $station)
			<li class="li-sub"><a href="{{ route('product.index', ['station' => $station->station_id]) }}" class="bg-none">{{ $station->station_name }}</a></li>
		@endforeach
	</ul>
</div>
@stop
