<div id="carousel-example-generic" class="carousel slide silider-cus" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    @if(!empty($result))
      @foreach($result as $k => $val)
        <?php $class = (0 == $k) ? 'item active img-sl-b-div' : 'item img-sl-b-div';?>
        <div class="{{$class}}">
          <img src="{{ httpsUrl($val->main_image_s) }}" alt="" class="img-sl-b">
          <p>{{$val->facility_name}}</p>
          <p>{{$val->product_name}}</p>
          @if (!empty($val->product_price))
          <p>価格：{{ numberFormat($val->product_price)}}円(税込)</p>
          @endif
          <div class="start start-ch">
            <div class="rate-group rate-top19">
                <div class="rateit"
                    data-rateit-readonly="true"
                    data-rateit-resetable="false"
                    data-rateit-starwidth="19"
                    data-rateit-starheight="15"
                    data-rateit-min="0"
                    data-rateit-max="5"
                    data-rateit-value="{{ $val->product_comment_evaluate_total }}"
                    data-rateit-step="0.1">
                </div>
                <span class="rate-np">{{ numberFormat($val->product_comment_evaluate_total, 1) }}</span>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

  <!-- Controls -->
  <a class="left carousel-control prev-ch" href="#carousel-example-generic" role="button" data-slide="prev">
    <img src="/assets/mobile/images/nex.png" alt="">
  </a>
  <a class="right carousel-control nex-ch" href="#carousel-example-generic" role="button" data-slide="next">
    <img src="/assets/mobile/images/nex.png" alt="">
  </a>
</div>