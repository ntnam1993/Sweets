@extends('coupon.errors.coupon')
@section('coupon.content')
<div class="coupon_detail expired">
    <p class="error_note">{{ $error_message }}</p>
</div>
<div class="coupon_btn error_btn">
    <a href="javascript:history.back()">戻る</a>
</div>
@endsection
