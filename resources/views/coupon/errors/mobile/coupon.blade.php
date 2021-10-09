@extends('layouts.mobile.family')
@section('title', 'EPARKスイーツガイド|家族割引')
@section('description', '')
@section('body.classes','errors-sp')
@section('content')
<div class="kv_area"></div>
<div class="coupon_area after-header">
    <div class="coupon_box">
        @yield('coupon.content')
    </div>
</div>
@endsection
