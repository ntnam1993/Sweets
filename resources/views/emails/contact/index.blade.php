@extends('layouts.emails.index')
@section('content')
<p>この度はEPARKスイーツガイドへお問い合わせいただき、誠にありがとうございます。<br>
弊社担当より確認させていただき、ご連絡させていただきます。</p>
<p>■お問い合わせ内容に関して</p>
<p>タイトル: {{ $data['title'] }}</p>
<p>法人名/店舗名: {{ $data['store_name'] }}</p>
<p>名前: {{ $data['last_name'] }} {{ $data['first_name'] }}</p>
<p>{{ $data['last_name_katakana'] }} {{ $data['first_name_katakana'] }}</p>
<p>メールアドレス: {{ $data['email'] }}</p>
<p>ご連絡先電話番号: {{ $data['phone'] }}</p>
<p>郵便番号: {{ $data['first_postcode'] }}{{ $data['last_postcode'] }}</p>
<p>資料送付先｜住所: {{$data['prefectures'].' '.$data['city_country'].' '.$data['street'].' '.$data['building_name']}}</p>
<p>お問い合わせ内容: {{ $data['content'] }}</p>
<p>※お問い合わせ内容によりましては、ご返信までお時間をいただく場合がございますので、予めご了承ください。</p>

＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br>
株式会社EPARKスイーツ<br>
EPARKスイーツガイド：https://sweetsguide.jp<br>
Mail : sweets-info@eparksweets.co.jp
@stop