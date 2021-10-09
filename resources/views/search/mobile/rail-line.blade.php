@extends('layouts.mobile.search')
@section('title', '路線｜EPARKスイーツガイド')
@section('content')
<div class="sp-container sp-container-bdRed clearfix">
	<h3 class="h3-noTextR"><a id="go-back">戻る</a><span>駅から探す</span></h3>
	<ul class="list-area">
		@foreach($railLines as $railLine)
			<li class="li-sub"><a href="{{ route('search.stations', [$prefectureId, $railLine->rail_line_id]) }}" class="bg-img-r">{{ $railLine->rail_line_name }}</a></li>
		@endforeach
	</ul>
</div>
@stop
