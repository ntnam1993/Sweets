@extends('layouts.family')
@section('title', 'EPARKスイーツガイド|家族割引')
@section('description', '')
@section('body.classes','errors-pc')
@section('content')
<div class="kv_area kv_couponP"></div>
<div class="coupon_area">
    <div class="coupon_box">
        @yield('coupon.content')
    </div>
</div>
@endsection
