@extends('layouts.emails.index')
@section('content')
<p>EPARKスイーツガイド様</p>
<p>ホームページより、下記の内容にてお問い合わせを承りました。<br>
内容をご確認の上、ご回答いただきますようお願いいたします。
</p>
=============================================<br>
<p>お問い合わせ内容</p>
<p>タイトル: <br>{{ $data['title'] }}</p>

<p>法人名/店舗名: <br>{{$data['store_name']}}</p>

<p>名前： <br>
{{ $data['last_name'] }} {{ $data['first_name'] }}<br>
{{ $data['last_name_katakana'] }} {{ $data['first_name_katakana'] }}</p>

<p>メールアドレス： <br>
{{ $data['email'] }}</p>

<p>ご連絡先電話番号： <br>
{{ $data['phone'] }}</p>

<p>郵便番号： <br>
{{ $data['first_postcode'] }}{{ $data['last_postcode'] }}</p>

<p>資料送付先｜住所： <br>
{{$data['prefectures'].' '.$data['city_country'].' '.$data['street'].' '.$data['building_name']}}
</p>
<p>お問い合わせ内容： <br>
{{ $data['content'] }}</p>

=============================================
@stop