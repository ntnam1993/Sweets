<div class="kessai_f">
    <div class="icon_box">
        <div class="cashpo_icon {{ $epark_payment_use_flag == 0 ? 'grayout' : '' }}">キャシュポ</div>
        <div class="point_icon {{ $epark_payment_use_flag == 0 ? 'grayout' : '' }}">ポイント</div>
        <div class="card_icon {{ $epark_payment_use_flag == 0 ? 'grayout' : '' }}">カード決済</div>
        <div class="shop_icon {{ $epark_payment_use_flag == 2 ? 'grayout' : '' }}">店頭支払</div>
        <div class="question_icon modal_detail"><img src="/assets/pc/images/question.png"></div>
    </div>
</div>
<script>
    $(function() {
        $('.modal_detail').on('click', function () {
            $(this).closest('.icon_box').append('<div class="modal_box"><div class="modal__bg"></div><div class="modalBox"><div class="modal_text"><div class="cashpo_icon">キャシュポ</div><p>予約時にキャシュポでお支払いいただけます。</p></div><div class="modal_text"><div class="point_icon">ポイント</div><p>予約時にポイントをクーポンに交換して割引にご利用いただけます。</p></div><div class="modal_text"><div class="card_icon">カード決済</div><p>予約時にクレジットカードでお支払いいただけます。</br>店頭では商品の受け取りのみとなります。</p></div><div class="modal_text"><div class="shop_icon">店頭支払</div><p>店頭で商品を受け取る際に代金のお支払いとなります。</p></div><p class="redcolor">※アイコンがグレーになっているサービスは、ご利用いただけません。</p></div></div>');
            $('.modal__bg').on('click', function () {
                $('.modal_box').remove();
            });
        });
    });
</script>