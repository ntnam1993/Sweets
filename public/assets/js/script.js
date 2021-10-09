$(document).ready(function() {
  // scroll to top page
  var topBtn = $('.toppage');
  topBtn.click(function() {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });

  $('.change-no-history').click(function(e) {
    e.preventDefault();
    window.location.replace($(this).attr('href'));
  });

  //button show detail content info shop
  var listShopDetails = $('.shop-comment .info-shop-detail');
  $.each(listShopDetails, function(index) {
    if (listShopDetails[index].offsetHeight < 66) {
      $(this).next('.btn-more').addClass('hide')
    } else {
      $(this).addClass('short');
    }
  });
  $('.shop-comment .btn-more').on('click', function(){
      $(this).prev('.info-shop-detail').removeClass('short');
      $(this).hide();
  });

  // check if localStorage/sessionStorage is supported
  isLocalStorageNameSupported = function() {
    return false;
    var testKey = 'test',
      storage = window.sessionStorage;
    try {
      storage.setItem(testKey, '1');
      storage.removeItem(testKey);
      return true;
    } catch (error) {
      return false;
    }
  }

  // Fix for back page
  if (isLocalStorageNameSupported()) {
    // Code for localStorage/sessionStorage.
    var urlArr = window.location.href.split('/');
    var urlArrLength = urlArr.length;
    if (urlArrLength >= 4) {
      if (urlArr[urlArrLength - 3] === 'shop') {
        // This is url of tabs on shop detail page
        var backLink = window.sessionStorage.getItem('will-be-back-link');
        if (backLink) {
          window.sessionStorage.setItem('back-link', backLink);
        }
      } else {
        window.sessionStorage.removeItem('back-link');
      }
    }
  } else {
    // Sorry! No Web Storage support..
  }

  $('#go-back').click(function(e) {
    e.preventDefault();
    if (isLocalStorageNameSupported()) {
      // Code for localStorage/sessionStorage.
      window.sessionStorage.removeItem('will-be-back-link');
      var backLink = window.sessionStorage.getItem('back-link');
      if (backLink && backLink !== null) {
        window.location.replace(backLink);
      } else {
        window.history.back();
      }
    } else {
      // Sorry! No Web Storage support..
      window.history.back();
    }
  });

  $(document).on('click', 'button.close', function() {
    var index = window.location.href.indexOf('#product-');
    if (index != -1) {
      var paths = window.location.href.substring(0, index).split('/');
      path = paths[paths.length - 1];
      window.history.replaceState(null, '', path);
    }
  });

  $('.check-ch').click(function() {
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).find('input').removeAttr('checked');
    } else {
      var spans = $(this).parents('form').find('.check-ch');
      spans.each(function() {
        var input = $(this).find('input');
        input.removeAttr('checked');
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      $(this).find('input').attr('checked', 'checked');
      $('.title-hidden').val($(this).find('input').val());
    }
  });

  $('.ul-list-checkbox .label-check').on('click', function() {
    $(this).siblings('.check-ch').trigger("click");
  });

  $('.full-more-ch').click(function() {
    $(this).prev().addClass('kb5-mor-show');
    $(this).prev().find('span.opacity-span').remove();
  });

  $('.full-des').click(function() {
    $(this).parent().prev('.kb5-mor').addClass('kb5-mor-show').find('span.opacity-span').hide();
    $(this).hide();
  });

  $('.jsShowAllItem').click(function() {
    $(this).hide();
    $(this).prev().find('li').removeClass('hide');
  });

  $('#areaModal-area').on('show.bs.modal', function(e) {
    $('#areaModal-area-station').modal('show');
  });
  _region_ = $('.region-text').html();
  if (_region_ == 'エリア・駅を選択する') {
    $('.jsDelregion').remove();
  } else {
    if ($('.area-gps-add-x .span-x-2').length == 0) {
      $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
    }
  }
  _genre_id_ = $('input[name="genre_id"]').val();
  if (_genre_id_ == '') {
    $('.jsDelGenre').remove();
  } else {
    if ($('.area-name.area-gps-add-y .span-x-2').length == 0) {
      $('.area-name.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
    }
  }
  $('#areaModal-area').on('hide.bs.modal', function(e) {
    $('#areaModal-area-station').modal('show');
  });
  $('#areaModal-category').on('hide.bs.modal', function(e) {
    _region_ = $('.region-text').html();
    if (_region_ == 'エリア・駅を選択する') {
      $('.jsDelregion').remove();
    } else {
      if ($('.area-gps-add-x .span-x-2').length == 0) {
        $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
      }
    }
    _genre_id_ = $('input[name="genre_id"]').val();
    if (_genre_id_ == '') {
      $('.jsDelGenre').remove();
    } else {
      if ($('.area-name.area-gps-add-y .span-x-2').length == 0) {
        $('.area-name.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
      }
    }
  });
  $('#areaModal').on('shown.bs.modal', function(e) {
    $('#areaModal-area-station').hide();
    _region_ = $('.region-text').html();
    if (_region_ == 'エリア・駅を選択する') {
      $('.jsDelregion').remove();
    } else {
      if ($('.area-gps-add-x .span-x-2').length == 0) {
        $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
      }
    }
    _genre_id_ = $('input[name="genre_id"]').val();
    if (_genre_id_ == '') {
      $('.jsDelGenre').remove();
    } else {
      if ($('.area-name.area-gps-add-y .span-x-2').length == 0) {
        $('.area-name.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
      }
    }
    $('.showModal-sp').show();
  });

  $('select[name="sort"]').change(function() {
    // location.href = addUrlParam('sort', $(this).val());
    /*
     * queryParameters -> handles the query string parameters
     * queryString -> the query string without the fist '?' character
     * re -> the regular expression
     * m -> holds the string matching the regular expression
     */
    var queryParameters = {},
      queryString = location.search.substring(1),
      re = /([^&=]+)=([^&]*)/g,
      m;

    // Creates a map with the query string parameters
    while (m = re.exec(queryString)) {
      queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }

    // Add new parameters or update existing ones
    queryParameters['sort'] = $(this).val();

    /*
     * Replace the query portion of the URL.
     * jQuery.param() -> create a serialized representation of an array or
     *     object, suitable for use in a URL query string or Ajax request.
     */
    location.search = $.param(queryParameters); // Causes page to reload
  });

  $('.ul-tab-mn li a').click(function() {
    /*
     * queryParameters -> handles the query string parameters
     * queryString -> the query string without the fist '?' character
     * re -> the regular expression
     * m -> holds the string matching the regular expression
     */
    var queryParameters = {},
      queryString = location.search.substring(1),
      re = /([^&=]+)=([^&]*)/g,
      m;

    // Creates a map with the query string parameters
    while (m = re.exec(queryString)) {
      queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }

    // Add new parameters or update existing ones
    queryParameters['tab'] = $(this).val();

    /*
     * Replace the query portion of the URL.
     * jQuery.param() -> create a serialized representation of an array or
     *     object, suitable for use in a URL query string or Ajax request.
     */
    location.search = $.param(queryParameters); // Causes page to reload
  });

  function showHideLoadMore(el) {
    $.each(el, function(index, val) {
      if ($(val).height() > 50) {
        $(val).parent().next('.more-detail').show();
        $(val).next('.opacity-span').show();
      } else {
        $(val).parent().next('.more-detail').hide();
        $(val).next('.opacity-span').hide();
      }
    });
  }
  showHideLoadMore($('.des-pro'));
  var h_w = ($(window).height() / 2) - 50;
  $('#loading').css('top', h_w);

  var i_w = $('.list-cake-gps li img').width();
  $('.list-cake-gps li img').height(i_w);
  $(window).resize(function() {
    var i_w = $('.list-cake-gps li img').width();
    $('.list-cake-gps li img').height(i_w);
  });

  var owl = $('.owl-carousel-ch');
  if (owl.children().length > 1) {
    owl.owlCarousel({
      loop: true,
      margin: 10,
      nav: false,
      dots: true,
      autoplay: true,
      items: 1
    })
  } else {
    $('.owl-carousel').addClass('show');
  }

  $(document).on('click', '.span-x', function(event) {
    $(this).parent().find('input.get-date-picker').val('');
  });

  $('.radio-check').on({
    'click': function() {
      if ($(this).children('.icon-nocheck').hasClass('active-check')) {
        $(this).children('.icon-nocheck').find("input").removeAttr('checked');
        $(this).children('.icon-nocheck').removeClass('active-check');
      } else {
        $(this).children('.icon-nocheck').find("input").attr('checked', true);
        $(this).children('.icon-nocheck').addClass("active-check");
      }
    }
  });

  $('.icon-nocheck').on({
    'click': function() {
      if ($(this).hasClass('active-check')) {
        $(this).find("input").removeAttr('checked');
        $(this).removeClass('active-check');
      } else {
        $(this).find("input").attr('checked', true);
        $(this).addClass("active-check");
      }
    }
  });

  // $('.ul-ul-ul').hide();
  $('.ul-tab-mn li').click(function() {
    var data_type = $(this).attr('data-type');
    $('.ul-tab-mn li').removeClass('active');
    $(this).addClass('active');
    var numFound = $('input[name="num_found"]').val();
    if (data_type == "1") {
      $('.ul-lists-list').hide();
      $('.display-map').hide();
      $('.slide-bottom').hide();
      $('.list-cake-gps').removeClass('hide').fadeIn();
      $('.show-price-gps').show();
      if (!$('.jsLoadmorePro').length) {
        $('.list-cake-gps').append('<li class="jsLoadmoreProd" style="height:0;"></li>');
      }
      $('.jsLoadmoreProdList').remove();
      $('.remove-form select').prop("disabled", false);
      $('.remove-form select').css('opacity', '1');
      $('#displayInf').removeClass('location');
      $('.main-foot').addClass('padd-60');
      if(parseInt($('.list-cake-gps li').length - 1) < numFound){
        $('footer').addClass('hide-footer');
        $('.list-cake-gps').addClass('div-height-fff');
      }else{
        $('footer').removeClass('hide-footer');
      }
    } else if (data_type == "2") {
      $('.list-cake-gps').hide();
      $('.display-map').hide();
      $('.slide-bottom').hide();
      $('.ul-lists-list').removeClass('hide').fadeIn();
      $('.show-price-gps').show();
      if (!$('.jsLoadmoreProdList').length) {
        $('.ul-lists-list').append('<li class="jsLoadmoreProdList" style="height:0;"></li>');
      }
      $('.jsLoadmoreProd').remove();
      $('.remove-form select').prop("disabled", false);
      $('.remove-form select').css('opacity', '1');
      $('#displayInf').removeClass('location');
      $('.main-foot').addClass('padd-60');
      if(parseInt($('.ul-lists-list li').length - 1) < numFound){
        $('footer').addClass('hide-footer');
        $('.ul-lists-list').addClass('div-height-fff');
      }else{
        $('footer').removeClass('hide-footer');
      }
      // $('.remove-form').show();
      // $('.ul-tab-mn').removeClass('ul-tab-mn-100');
    } else if (data_type == "3") {
      $('.ul-lists-list').hide();
      $('.list-cake-gps').hide();
      // $('.slide-bottom').removeClass('hide').fadeIn();
      $('.display-map').removeClass('hide').fadeIn();
      initAutocomplete();
      $('.show-price-gps').hide();
      $('.jsLoadmoreProd').remove();
      $('.jsLoadmoreProdList').remove();
      $('.remove-form select').prop("disabled", true);
      $('.remove-form select').css('opacity', '0.4');
      $('#displayInf').removeClass('location');
      $('.main-foot').removeClass('padd-60');
      $('footer').removeClass('hide-footer');
      // $('.ul-tab-mn').addClass('ul-tab-mn-100');
    }
  });

  $('.icon-mnnnn').click(function() {
    $('.main-menu').show();
    $('.over').show();
  });
  $('.clos').click(function(event) {
    $('.over').hide();
    $('.main-menu').hide();
  });

  $('.default-click').click(function(event) {
    $('.default-text').text('誕生日ケーキ・ホールケーキ');
    $('#default-val').val('1');
  });

  $('.close2').click(function(event) {
    $('.default-text').text('ジャンルを選択する');
    $('#default-val').val('');
  });


  $('#areaModal-area-station').on('show.bs.modal', function(e) {
    // $('#areaModal').modal('hide');
  });
  $('#areaModal-area-station').on('hide.bs.modal', function(e) {
    // $('#areaModal').modal('show');
  });
  $('#modalStation').on('show.bs.modal', function(e) {
    $('#areaModal-area-station').modal('show');
  });
  $('#modalStation').on('hide.bs.modal', function(e) {
    $('#areaModal-area-station').modal('show');
  });
  $('select[name="price"]').on('change', function() {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
  });

  $(document).on('click', '.ul-list-checkbox li.triggerCheckbox', function() {
    if ($(this).find('.check-ch').hasClass('active')) {
      $(this).find('.check-ch').removeClass('active');
      $(this).find('.check-ch').find('input').prop('checked', false);
    } else {
      $(this).find('.check-ch').addClass('active');
      $(this).find('.check-ch').find('input').prop('checked', true);
    }
  });
  $(document).on('click', '.ul-list-checkbox li.triggerCheckbox .check-ch', function() {
    if ($(this).parent().find('.check-ch').hasClass('active')) {
      $(this).parent().find('.check-ch').removeClass('active');
      $(this).parent().find('.check-ch').find('input').prop('checked', false);
    } else {
      $(this).parent().find('.check-ch').addClass('active');
      $(this).parent().find('.check-ch').find('input').prop('checked', true);
    }
  });

  $(document).on('click', '.active-checkb', function() {
    var _this = $(this);
    _this.parent().find('.label2').toggleClass('active-checkbox');
    var _flg = 0;
    var _inputs = $('.fieldset-size .div-checkb .label2');
    $.each(_inputs, function(index, val) {
      if ($(val).hasClass('active-checkbox')) {
        _flg = _flg + 1;
      }
    });
    if (_flg == 9) {
      $('#check_all').prop('checked', true);
      $('.label-all').addClass('active-checkbox-all');
    } else {
      $('#check_all').prop('checked', false);
      $('.label-all').removeClass('active-checkbox-all');
    }
  });
  //if load page have param check_all = on, add class and prop checked
   var check_all = $('.active-checkb-all.label-all').data('on');
   if (check_all == 'on') {
       $('.active-checkb-all.label-all').toggleClass('active-checkbox-all');
       $('#check_all').prop('checked', true);
   }
  $(document).on('click', '.active-checkb-all', function(e) {

    var _this = $(this);
    _this.parent().find('.label-all').toggleClass('active-checkbox-all');
    if ($('input[name="check_all"]').is(":checked")) {
      $('#size3').parent().find('.label2').removeClass('active-checkbox');
      $('#size4').parent().find('.label2').removeClass('active-checkbox');
      $('#size5').parent().find('.label2').removeClass('active-checkbox');
      $('#size6').parent().find('.label2').removeClass('active-checkbox');
      $('#size7').parent().find('.label2').removeClass('active-checkbox');
      $('#size8').parent().find('.label2').removeClass('active-checkbox');
      $('#size9').parent().find('.label2').removeClass('active-checkbox');
      $('#size10').parent().find('.label2').removeClass('active-checkbox');
      $('#size11').parent().find('.label2').removeClass('active-checkbox');
      $('#size3').prop('checked', false);
      $('#size4').prop('checked', false);
      $('#size5').prop('checked', false);
      $('#size6').prop('checked', false);
      $('#size7').prop('checked', false);
      $('#size8').prop('checked', false);
      $('#size9').prop('checked', false);
      $('#size10').prop('checked', false);
      $('#size11').prop('checked', false);
    } else {
      $('#size3').parent().find('.label2').addClass('active-checkbox');
      $('#size4').parent().find('.label2').addClass('active-checkbox');
      $('#size5').parent().find('.label2').addClass('active-checkbox');
      $('#size6').parent().find('.label2').addClass('active-checkbox');
      $('#size7').parent().find('.label2').addClass('active-checkbox');
      $('#size8').parent().find('.label2').addClass('active-checkbox');
      $('#size9').parent().find('.label2').addClass('active-checkbox');
      $('#size10').parent().find('.label2').addClass('active-checkbox');
      $('#size11').parent().find('.label2').addClass('active-checkbox');
      $('#size3').prop('checked', true);
      $('#size4').prop('checked', true);
      $('#size5').prop('checked', true);
      $('#size6').prop('checked', true);
      $('#size7').prop('checked', true);
      $('#size8').prop('checked', true);
      $('#size9').prop('checked', true);
      $('#size10').prop('checked', true);
      $('#size11').prop('checked', true);
    }
  });

  $('.check-ch').each(function() {
    if ($(this).find('input').is(':checked')) {
      $(this).addClass('active');
    };
  });

  $('.modal').on('hide.bs.modal', function(e) {
    $('body').css('position', 'static');
  });

  $('.find-add').on('click', function() {
    var postcode = $('.first_postcode').val() + $('.last_postcode').val();
    var self = $(this);
    var postcode_err = $('.postcode-err');
    if ($('.is-mobile').val()) {
      var input = self.siblings('.pull-left.txt-left').find('input');
      input.each(function() {
        if ($(this).val() == '') {
          $(this).focus();
          if (postcode_err.length > 0) {
            postcode_err.text('郵便番号を正しく入力してください。');
          } else {
            $('.err-code').html('郵便番号入力してください。');
          }
          return false;
        } else {
          if ($(this).hasClass('first_postcode')) {
            if ($(this).val().length != 3) {
              $(this).focus();
              if (postcode_err.length > 0) {
                postcode_err.text('郵便番号を正しく入力してください。');
              } else {
                $('.err-code').html('3文字を入力してください。');
              }
              return false;
            }
          } else {
            if ($(this).val().length != 4) {
              $(this).focus();
              if (postcode_err.length > 0) {
                postcode_err.text('郵便番号を正しく入力してください。');
              } else {
                $('.err-code').html('4文字を入力してください。');
              }
              return false;
            }
          }
        }
      });
    } else {
      self.siblings('input').each(function() {
        if ($(this).val() == '') {
          $(this).focus();
          if (postcode_err.length > 0) {
            postcode_err.text('郵便番号を正しく入力してください。');
          } else {
            $('.err-code').html('郵便番号入力してください。');
          }
          return false;
        } else {
          if ($(this).hasClass('first_postcode')) {
            if ($(this).val().length != 3) {
              $(this).focus();
              if (postcode_err.length > 0) {
                postcode_err.text('郵便番号を正しく入力してください。');
              } else {
                $('.err-code').html('3文字を入力してください。');
              }
              return false;
            }
          } else {
            if ($(this).val().length != 4) {
              $(this).focus();
              if (postcode_err.length > 0) {
                postcode_err.text('郵便番号を正しく入力してください。');
              } else {
                $('.err-code').html('4文字を入力してください。');
              }
              return false;
            }
          }
        }
      });
    }

    $.ajax({
      type: 'get',
      url: 'https://maps.googleapis.com/maps/api/geocode/json',
      crossDomain: true,
      dataType: 'json',
      data: {
        address: postcode,
        key : $('.get_google_api_key').val(),
        language: 'ja',
        sensor: false
      },
      success: function(resp) {
        if (postcode.length == 7) {
          if (resp.status == "OK") {
            // APIのレスポンスから住所情報を取得
            var obj = resp.results[0].address_components;
            if (obj.length < 5) {
              if (postcode_err.length > 0) {
                postcode_err.text('郵便番号を正しく入力してください。');
              } else {
                $('.err-code').html('正しい郵便番号を入力してください。');
              }
              return false;
            }
            $('.prefectures').val(obj[3]['long_name']); // 都道府県
            if ($('.prefectures option').length > 0) {
              $('.prefectures option').each(function() {
                if ($(this).text() == obj[3]['long_name']) {
                  $(this).prop('selected', true);
                }
              });
            } //set selected value for prefectures dropbox
            $('.city_country').val(obj[2]['long_name']); // 市区町村
            $('.street').val(obj[1]['long_name']); // 番地
          } else {
            if (postcode_err.length == 0) {
              $('.err-code').html('住所情報が取得できませんでした。');
            }
            return false;
          }
        }
      }
    });
  });

  $('.first_postcode').keyup(function() {
    if ($(this).val().length == 3) {
      if ($('.postcode-err').length > 0) {
        $('.postcode-err').text('');
      }
    }
  });

  $('.last_postcode').keyup(function() {
    if ($(this).val().length == 4) {
      if ($('.postcode-err').length > 0) {
        $('.postcode-err').text('');
      }
    }
  });


  if ($('.show-price-gps').length && $('.show-price-gps').is(':visible')) {
    $('.main-foot').addClass('padd-60');
  } else {
    $('.main-foot').removeClass('padd-60');
  }
  var _height_ul = $('.height-ul').height();
  $('.height-ul li').css('height', _height_ul + 'px');
  $('.height-ul li .pos-ab-bot').css('position', 'absolute');
  $('.height-ul li .pos-ab-bot').css('bottom', '0');

  // js of cart-checkout page
  var receipt_date = $('#receipt_date');
  var receipt_time = $('#receipt_time');
  var shop_contact_time = $('input[name="shop_contact_time"]');
  var errCarryTime = true;
  $('#disabled').on('click', function() {
    validate();
  });
  shop_contact_time.on('click', function() {
    if (!shop_contact_time.is(":checked")) {
      $('.p-err-shop-contact-time').show().html('電話の取りやすい時間が未設定');
    } else {
      $('.p-err-shop-contact-time').hide().html('');
    }

  });

  function validate() {
    if (receipt_date.val() == '') {
      $('.p-err').show().html('受取希望日が未設定');
    } else {
      $('.p-err').html('');
    }
    if (receipt_time.val() == '') {
      $('.p-err2').show().html('受取希望時間が未設定');
    } else {
      $('.p-err').html('');
    }
    if (!shop_contact_time.is(":checked")) {
      $('.p-err-shop-contact-time').show().html('電話の取りやすい時間が未設定');
    } else {
      $('.p-err-shop-contact-time').hide().html('');
    }
    if ($('#reservation-image').val() == '' && $('#imageBase64').val() == '') {
      $('.p-err-image').html('画像をアップしてください');
    } else {
      $('.p-err-image').hide().html('');
    }
    if ($('select[name="carry_time"]').length) {
      if ($('select[name="carry_time"]').val() == '') {
        $('.p-err-carry-time').html('持ち歩き時間を選択してください');
        errCarryTime = false;
      } else {
        $('.p-err-carry-time').hide().html('');
        errCarryTime = true;
      }
    }
    if (receipt_date.val() != '' &&
      receipt_time.val() != '' &&
      shop_contact_time.is(':checked') &&
      ($('#reservation-image').val() != '' || $('#imageBase64').val() != '') &&
      ($('.p-err-product-count').html() == "") && errCarryTime
    ) {
      $('#form-checkout').submit();
    }
  }
  if ($('.alert-danger').length > 0) {
    $('html,body').animate({
        scrollTop: $('.alert-danger').offset().top
      },
      'slow');
  }
  $('#receipt_date').on('change', function() {
    var _this = $(this);
    var receipt_date = _this.val();
    var product_count = $('select[name="product_count"]').val();
    var product_id = $('#product_id_cart').val();

    $.ajax({
        url: document.location.origin + '/cart/check-receiptdate',
        type: 'GET',
        dataType: 'JSON',
        data: {
          receipt_date: receipt_date,
          product_count: product_count,
          product_id: product_id
        },
      })
      .done(function(data) {
        var _html_ = "";
        $.each(data, function(index, val) {
          _html_ += "<option value='" + val + "'>" + val + "</option>";
        });
        $('#receipt_time').html('');
        $('#receipt_time').append(_html_);
      });

  });
  if ($('select[name="carry_time"]').length) {
    var text = $(this).find('option[selected="selected"]').text();
    $('input[name="carry_text"]').val(text);
  }
  $('select[name="carry_time"]').on('change', function() {
    var val = $(this).val();
    var text = $(this).find("option:selected").text();
    $('input[name="carry_text"]').val(text);
    if (val != '') {
      $('.p-err-carry-time').html('');
    } else {
      $('.p-err-carry-time').html('持ち歩き時間を選択してください');
    }
  });
  $(document).on('click', '#triggerClickFile', function() {
    $('#reservation-image').click();
  });
  $('#image').hide();
  if ($('#reservation-image').length > 0) {
    document.getElementById('reservation-image').onchange = function(e) {
      var loadingImage = loadImage.parseMetaData(e.target.files[0], function(data) {
        //default image orientation
        var orientation = 0;
        //if exif data available, update orientation
        if (data.exif) {
          orientation = data.exif.get('Orientation');
        }
        var loadingImage = loadImage(
          e.target.files[0],
          function(canvas) {
            var fileName = e.target.files[0].name;
            fileExtension = fileName.replace(/^.*\./, '');
            fileExtension = fileExtension.toLowerCase();
            if (fileExtension == 'jpg' || fileExtension == 'jpeg' || fileExtension == 'png' || fileExtension == 'gif') {
              if (e.target.files[0].size > 2048000) {
                $('.p-err-image').show().html('アップする画像は2MB以下にしてください。');
                $('#reservation-image').val('');
                $('#image').attr('src', '');
                $('#image').css('display', 'none');
                $('#btnDelImg').css('display', 'none');
                // localStorage.removeItem('base64data');
              } else {
                try {

                  //here's the base64 data result
                  var base64data = canvas.toDataURL('image/jpeg');
                  //here's example to show it as on imae preview
                  var img_src = base64data.replace(/^data\:image\/\w+\;base64\,/, '');

                  $('#image').attr('src', base64data);
                  $('#image').css('display', 'block');
                  $('#btnDelImg').css('display', 'block');
                  $('.span-txt-upimage').html('画像を変更する');
                  $('.p-err-image').hide().html('');
                } catch (err) {

                  $('.p-err-image').show().html('画像サイズが大きすぎます。他の画像を選択してください。');
                  $('#reservation-image').val('');
                  $('#image').attr('src', '');
                  $('#image').css('display', 'none');
                  // localStorage.removeItem('base64data');
                  $('#btnDelImg').css('display', 'none');
                }
              }
            } else {
              $('.p-err-image').show().html('画像は jpg, jpeg, png, gif のみ対応しております。');
              $('#reservation-image').val('');
              $('#image').attr('src', '');
              $('#image').css('display', 'none');
              $('#btnDelImg').css('display', 'none');
              // localStorage.removeItem('base64data');

            }

          }, {
            //should be set to canvas : true to activate auto fix orientation
            canvas: true,
            orientation: orientation
          }
        );
      });
      if (!loadingImage) {
        // Alternative code ...
      }

    };
    $('#btnDelImg').css('display', 'none');
    $(document).on('click', '#btnDelImg', function() {
      $(this).css('display', 'none');
      $('#image').removeAttr('src');
      $('#image').css('display', 'none');
      $('#reservation-image').val('');
      $('#imageBase64').val('');
      $('.span-txt-upimage').html('画像を選択する');
      $('.p-err-image').show().html('画像をアップしてください');
    });
  };

  $('.any-item-pulldown').on('change', function() {
    var item = $(this).find(":selected").attr('data-number');
    var text = $(this).find(":selected").text();
    var value = this.value;
    var inputItem = "input[name='any_item[" + item + "][pulldown][option_value]']";
    var inputPrice = "input[name='any_item[" + item + "][pulldown][option_price]']";
    $(inputItem).val(text);
    $(inputPrice).val(value);

    $('.option_price_' + item).html('価格：' + numberWithCommas(value) + '円(税込)');

    // Hide option price if its value is null
    $('.option_price_' + item).css('display', (!value || value == '0') ? 'none' : 'block');

    updatePrices();
  });

  function calculateTotalOptionPrice() {
    // Total option prices
    var totalOptionPrice = 0;
    $('.option-pull-down').each(function () {
      var value = $(this).find('.option-3').val();
      totalOptionPrice += (value ? (1 * value) : 0);
    });
    return totalOptionPrice;
  }

  function updatePrices () {
    // Total option prices
    var totalOptionPrice = calculateTotalOptionPrice();
    var quantity = 1 * $('select[name="product_count"]').val();
    var productPrice = 1 * $('input[name="product_price"]').val();
    var totalDiscount = 1 * $("#totalDiscount").val();

    $('#totalOptionPriceWrapper').css('display', (!totalOptionPrice || totalOptionPrice == '0') ? 'none' : 'block');
    $('.total-option-price').val(totalOptionPrice);
    $('.span-total-option-price').val(numberWithCommas(totalOptionPrice) + '円(税込)');

    $('.product-price-with-total-option-price').val(productPrice + totalOptionPrice);
    $('.span-product-price-with-total-option-price').val(numberWithCommas(productPrice + totalOptionPrice) + '円(税込)');
  }

  $(document).on('click', '.trigger-radio li', function() {
    $(this).parent().find('.radio-type').prop("checked", false);
    $(this).find('.radio-type').prop("checked", true);
  });
  $('.change-pull-down').on('change', function() {
    var this_ = $(this);
    var arr_pull_down = $('.option-pull-down');
    var pulldown = [];
    var productId = $('#product_id_cart').val();
    var number = $('#product-count').val();
    $.each(arr_pull_down, function(index, val) {
      pulldown.push($(val).find('.select').children('.option-3').val());
    });

    $.ajax({
      url: document.location.origin + '/get-total-price',
      type: 'GET',
      dataType: 'text',
      data: { type: 'total_price', pulldown: pulldown, productId: productId, number: number },
    })
    .done(function(data) {
      $('.span-total-price').val(numberWithCommas(data) + '円(税込)');
      $('.input-total-price').val(data);
    });

  });

  $("#product-count").focus(function() {
    previous = this.value;
  });
  $('#product-count').on('change', function() {
    var this_ = $(this);
    var number = this_.val();
    var productId = $('input[name="product_id"]').val();

    /** Get selected receipt date */
    var selectedReceiptDate = $('select[name=receipt_date]').val();
    var selectedReceiptText = $('select[name=receipt_date] option:selected').html();

    if (number <= 50) {
      $.ajax({
        type: "POST",
        url: document.location.origin + '/product/diff-receipt-days',
        dataType: 'json',
        data: {
          product_id: productId,
          product_count: parseInt(number),
          type: "check_number",
          _token: $('input[name="_token"]').val()
        }
      })
      .done(function(json) {
        if (json[0] != "受取可能日が存在しません" && json[0] != "受取可能日がありません") {
          $('.p-err-product-count').html('');

          // Remove error messages
          $('.err_ms').remove();
          $('.cart-error-msg').remove();

          /**
           * Checking for if selected receipt date is not in range of new shop receipt dates
           */
          if (Object.keys(json[1]).indexOf(selectedReceiptDate) < 0) {

            // Show error message
            var input_checkeds = $('#couponList input[name=coupon]:checked ~ span[class="cpn_term"]');
            var receiptable_period_start = input_checkeds.find('#receiptable_period_start').val();
            var receiptable_period_end = input_checkeds.find('#receiptable_period_end').val();

            if (receiptable_period_start && receiptable_period_end) {
              var message_err = '受け取り期間（'+receiptable_period_start+'～'+receiptable_period_end+'）の場合にこのクーポンを利用可能です。';
              var ele_msg = '<span style="color:#FF0000" class="err_ms">'+message_err+'</span>';
              if ($('.reservation-nav').length) {
                $('.reservation-nav').after(ele_msg);
              }
              if ($('.ul-new-reser').length) {
                $('.ul-new-reser').after(ele_msg);
              }
              scrollToErrorMessage();
            }

            json[1][selectedReceiptDate] = selectedReceiptText;
          }

          checkTotalAmountError();

          /** Reset cached var of receipt dates */
          arr_receiptdate_fixed = [];
          arr_receiptdate = [];

          // Append to receipt date select box
          var _html_ = "";
          $.each(json[1], function(index, val) {
            if (index == selectedReceiptDate) {
              _html_ += "<option value='" + index + "' selected>" + val + "</option>";
            } else {
              _html_ += "<option value='" + index + "'>" + val + "</option>";
            }
            arr_receiptdate.push(index);
            arr_receiptdate_fixed.push({ val: index, text: val });
          });
          $('#receipt_date').html(_html_);

          if ($('input[name="cp_code"]').length && $('input[name="cp_code"]').val() != '') {
            /**
             * Intersect receipt dates
             *
             */
            var input_checkeds = $('#couponList input[name=coupon]:checked ~ span[class="cpn_term"]');
            var receiptable_period_start = input_checkeds.find('#receiptable_period_start').val();
            var receiptable_period_end = input_checkeds.find('#receiptable_period_end').val();
            var data = {
              receiptable_period_start: receiptable_period_start,
              receiptable_period_end : receiptable_period_end,
              arr_receiptdate: arr_receiptdate
            }
            $.ajax({
              url: document.location.origin + '/cart/check-receiptdate-coupon',
              type: 'POST',
              data:  data,
              dataType: 'JSON',
            }).done(function (res) {
              if (res != '') {
                if (Object.keys(res).indexOf(selectedReceiptDate) < 0) {
                  res[selectedReceiptDate] = selectedReceiptText;

                  // Show error message
                  var input_checkeds = $('#couponList input[name=coupon]:checked ~ span[class="cpn_term"]');
                  var receiptable_period_start = input_checkeds.find('#receiptable_period_start').val();
                  var receiptable_period_end = input_checkeds.find('#receiptable_period_end').val();

                  if (receiptable_period_start && receiptable_period_end) {
                    var message_err = '受け取り期間（'+receiptable_period_start+'～'+receiptable_period_end+'）の場合にこのクーポンを利用可能です。';
                    var ele_msg = '<span style="color:#FF0000" class="err_ms">'+message_err+'</span>';
                    if ($('.reservation-nav').length) {
                      $('.reservation-nav').after(ele_msg);
                    }
                    if ($('.ul-new-reser').length) {
                      $('.ul-new-reser').after(ele_msg);
                    }
                    scrollToErrorMessage();
                  }
                }

                arr_receiptdate = [];
                arr_receiptdate_fixed = [];

                // Append to receipt date select box
                var _html_ = "";
                $.each(res, function(index, val) {
                  if (index == selectedReceiptDate) {
                    _html_ += "<option value='" + index + "' selected>" + val + "</option>";
                  } else {
                    _html_ += "<option value='" + index + "'>" + val + "</option>";
                  }
                  arr_receiptdate.push(index);
                  arr_receiptdate_fixed.push({ val: index, text: val });
                });
                $('#receipt_date').html(_html_);
              }
            });
          }

          var _html_time = "";
          $.each(json[2], function(index, val) {
            _html_time += "<option value='" + val + "'>" + val + "</option>";
          });
          $('#receipt_time').html(_html_time);

          var arr_pull_down = $('.option-pull-down');
          var pulldown = [];
          $.each(arr_pull_down, function(index, val) {
            pulldown.push($(val).find('.select').children('.option-3').val());
          });
          $.ajax({
            url: document.location.origin + '/get-total-price',
            type: 'GET',
            dataType: 'text',
            data: { type: 'total_price', pulldown: pulldown, productId: productId, number: number },
          })
          .done(function(data) {
            $('.span-total-price').val(numberWithCommas(data) + '円(税込)');
            $('.input-total-price').val(data);
          });
          previous = number;
        } else {
          if (json[3] != "") {
            $('.p-err-product-count').html(json[3]);
          } else {
            $('.p-err-product-count').html('在庫がありません');
          }
        }
      });
    }
  });

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  $(document).on('click', '.showMenu', function() {
    $('#mn-not-login').fadeIn(400);
    $('.b-cl-mn').fadeIn(400);
    $('.over').fadeIn(400);
  });
  $(document).on('click', '.b-cl-mn', function() {
    $('#mn-not-login').fadeOut(400);
    $('.b-cl-mn').fadeOut(400);
    $('.over').fadeOut(400);
  });
  $(document).on('click', '.over', function() {
    $('#mn-not-login').fadeOut(400);
    $('.b-cl-mn').fadeOut(400);
    $('.over').fadeOut(400);
  });
  var _h_li_ = $('.ul-new-reser li').width();
  $('.ul-new-reser li a').css('height', _h_li_ + 'px');
  $('.ul-new-reser li a').css('line-height', _h_li_ + 'px');
  $('.ul-new-reser li:nth-child(2) a,.ul-new-reser li:nth-child(4) a,.ul-new-reser li:nth-child(6) a').css('padding-top', ((_h_li_ / 2) - 7) + 'px');
  $(window).resize(function() {
    var _h_li_ = $('.ul-new-reser li').width();
    $('.ul-new-reser li a').css('height', _h_li_ + 'px');
    $('.ul-new-reser li a').css('line-height', _h_li_ + 'px');
    $('.ul-new-reser li:nth-child(2) a,.ul-new-reser li:nth-child(4) a,.ul-new-reser li:nth-child(6) a').css('padding-top', ((_h_li_ / 2) - 7) + 'px');
  });

  //js of top page
  $(window).bind("pageshow", function(event) {
    // remove loading indicator
    $('#loading').hide();
    $('.over').hide();
  });
  $('.btn-ser-new').on('click', function() {
    $('#loading').show();
    $('.over').show();
  });

  $('.tb-inp tr td.td-1').bind('click', function() {
    $('#areaModal-area-top').modal('show');
  });

  $('.modal-free-search').on('click', function() {
    $('#modal-free-search').fadeIn(300);
    $('.over').fadeIn(300);
    $('#inp-free-s').trigger('focus');
  });
  $(document).on('click', '.cl-btn', function() {
    $('#modal-free-search').fadeOut(300);
    $('.over').fadeOut(300);
  });
  $('.over').on('click', function() {
    $('#modal-free-search').fadeOut(300);
    $(this).fadeOut(300);
  });

  $('#modal-free-search').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
    $(this).find('#inp-free-s').focus();
  });

  $('.td-3').on('click', function() {
    $('#receipt-date').focus();
  });
  $(document).on('keyup', '#inp-free-s', function() {
    if ($(this).val() != "") {
      $('.span-x-2-1').removeClass('hide');
    } else {
      $('.span-x-2-1').addClass('hide');
    }
  });
  $(document).on('click', '.span-x-2-1', function() {
    $('#inp-free-s').val('');
    $(this).addClass('hide');
  });
  $(document).on('click', '.showMenu', function() {
    $('#mn-not-login').fadeIn(400);
    $('.b-cl-mn').fadeIn(400);
    $('.over').fadeIn(400);
  });
  $(document).on('click', '.b-cl-mn', function() {
    $('#mn-not-login').fadeOut(400);
    $('.b-cl-mn').fadeOut(400);
    $('.over').fadeOut(400);
  });
  $(document).on('click', '.over', function() {
    $('#mn-not-login').fadeOut(400);
    $('.b-cl-mn').fadeOut(400);
    $('.over').fadeOut(400);
  });
  $(".input-group-addon-2").on("change", function() {
    this.setAttribute(
      "data-date",
      moment(this.value, "YYYY-MM-DD")
      .format(this.getAttribute("data-date-format"))
    )
  });

  if (isLocalStorageNameSupported()) {
    // Code for localStorage/sessionStorage.
    var listKeyWords = JSON.parse(localStorage.getItem("objKeywords"));
    if (listKeyWords) {
      var listKw = "<p class=\"p-tt-fr-s\">検索キーワード履歴</p><ul class=\"ul-fre-s clearfix\">";
      var search = window.location.origin;
      if ($('input[name="full_url_except_keyword"]').val() == "1") {
        search = $('input[name="full_url_except_keyword"]').attr('data-url');
        $.each(listKeyWords, function(index, val) {
          listKw += "<li><a href= '" + search + "&keyword=" + val + "'>" + val + "</a></li>";
        });
      } else {
        $.each(listKeyWords, function(index, val) {
          listKw += "<li><a href= '" + search + "/shopsearch/all?keyword=" + val + "&sort=0'>" + val + "</a></li>";
        });
      }
      listKw += "</ul>"
      $('#freeword-history').html();
      $('#freeword-history').append(listKw);
    }
  }
  // check if localStorage/sessionStorage is supported
  isLocalStorageNameSupported = function() {
    return false;
    var testKey = 'test',
      storage = window.sessionStorage;
    try {
      storage.setItem(testKey, '1');
      storage.removeItem(testKey);
      return true;
    } catch (error) {
      return false;
    }
  }
  if (isLocalStorageNameSupported()) {
    // Code for localStorage/sessionStorage.
    var flg_key_word = localStorage.getItem("flg_key_word");
    $('.over').on('click', function() {
      $('#modal-free-search').removeClass('dis-block');
      $('.over').removeClass('dis-block');
      localStorage.setItem("flg_key_word", "0");
      $('input[name="keyword"]').val('');
      $('.span-x-2-1').addClass('hide');
    });
    $('.cl-btn').on('click', function() {
      $('#modal-free-search').removeClass('dis-block');
      $('.over').removeClass('dis-block');
      localStorage.setItem("flg_key_word", "0");
      $('input[name="keyword"]').val('');
      $('.span-x-2-1').addClass('hide');
    });
  }

});
/*
 * jquery-auto-height.js
 *
 * Copyright (c) 2010 Tomohiro Okuwaki (http://www.tinybeans.net/blog/)
 * Licensed under MIT Lisence:
 * http://www.opensource.org/licenses/mit-license.php
 * http://sourceforge.jp/projects/opensource/wiki/licenses%2FMIT_license
 *
 * Since:   2010-04-19
 * Update:  2015-03-26
 * version: 0.05
 * Comment:
 *
 * jQuery 1.2 <-> 1.10.2
 *
 */

 (function($){
    $.fn.autoHeight = function(options){
        var op = $.extend({

            column  : 0,
            clear   : 0,
            height  : 'minHeight',
            reset   : ''
        },options || {}); // optionsに値があれば上書きする

        var self = $(this);
        if (op.reset === 'reset') {
            self.removeAttr('style');
        }

        // 要素の高さを取得
        var hList = self.map(function(){
            return $(this).height();
        }).get();
        var hListLine = [];
        if (op.column > 1) {
            for(var i = 0, l = hList.length; i < Math.ceil(l / op.column); i++) {
                var x = i * op.column;
                // 指定カラム数の配列を切り出し、その中の高さの最大値を取得する
                hListLine.push(Math.max.apply(null, hList.slice(x, x + op.column)));
            }
        }

        // 高さの最大値を要素に適用
        var ie6 = typeof window.addEventListener === "undefined" && typeof document.documentElement.style.maxHeight === "undefined";
        if (op.column > 1) {
            for (var j=0; j<hListLine.length; j++) {
                for (var k=0; k<op.column; k++) {
                    if (ie6) {
                        self.eq(j*op.column+k).height(hListLine[j]);
                    } else {
                        self.eq(j*op.column+k).css(op.height,hListLine[j]);
                    }
                    if (k === 0 && op.clear !== 0) {
                        self.eq(j*op.column+k).css('clear','both');
                    }
                }
            }
        } else {
            // 取得した高さの数値の最大値を取得
            var hMax = Math.max.apply(null, hList);
            if (ie6) {
                self.height(hMax);
            } else {
                self.css(op.height, hMax);
            }
        }
    };
})(jQuery);
$(function(){
    $('ul.jsAutoHeight li div.div-autoheight').autoHeight({column:5});
});
function navigate(lat, lng) {
  // If it's an iPhone..
  if ((navigator.platform.indexOf("iPhone") !== -1) || (navigator.platform.indexOf("iPod") !== -1)) {
    function iOSversion() {
      if (/iP(hone|od|ad)/.test(navigator.platform)) {
        // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>
        var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
        return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
      }
    }
    var ver = iOSversion() || [0];
    if (ver[0] >= 6) {
      protocol = 'maps://';
    } else {
      protocol = 'http://';
    }
    window.open('https://maps.google.com/maps?q='+ lat +','+ lng);
  } else {
    window.open('https://maps.google.com/maps?q='+ lat +','+ lng);
  }
}
function convertCakeSize($cakeSize)
{
    if (9 == $cakeSize) {
        return (parseInt($cakeSize) + 2) + '号以上';
    }
    return (parseInt($cakeSize) + 2) + '号';
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
// Speed up calls to hasOwnProperty
var hasOwnProperty = Object.prototype.hasOwnProperty;

function isEmpty(obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // If it isn't an object at this point
    // it is empty, but it can't be anything *but* empty
    // Is it empty?  Depends on your application.
    if (typeof obj !== "object") return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}
fake_product_id = 0;
function changeInputPrices(self, productId) {
  if (!self.hasClass('purchase-item')) {
    self = self.parent().parent().parent('.purchase-item');
  }
  self.find('#totalPriceOfItem').attr('name', 'price[' + productId + '][totalPriceOfItem]');
  self.find('#totalDiscountOfItem').attr('name', 'price[' + productId + '][totalDiscountOfItem]');
  self.find('#optionPriceOfItem').attr('name', 'price[' + productId + '][optionPriceOfItem]');
  self.find('#priceOfItem').attr('name', 'price[' + productId + '][priceOfItem]');
}
$(document).on('change','#product_name', function(){
  if($(this).val() != ''){
    $(this).removeClass('color-ff0000');
    $(this).parent().parent().parent('.purchase-item').find('#product_size').removeClass('color-ff0000');
    $(this).parent().parent().parent().find('.p-err-last-name').html('');
  }
  var product_id = $(this).parent().parent().parent('.purchase-item').find('#product_name option:selected').attr('data-product-id');
  $(this).parent().parent().parent('.purchase-item').attr('data-product-id', product_id);
  $(this).parent().parent().parent('.purchase-item').find('.add-remove-links [data-action="removeItem"]').attr('data-product-id', product_id);

  var _this = $(this);
  _this.parent().find('#product_id').val(product_id);
  _this.attr('name', 'product_items['+product_id+'][product_name]');
  _this.parent().parent().parent('.purchase-item').find('#product_size').attr('name', 'product_items['+product_id+'][product_size]');
  _this.parent().parent().parent('.purchase-item').find('#item_number').attr('name', 'product_items['+product_id+'][item_number]');
  changeInputPrices(_this, product_id);
  var totalPrice = 0;
  var totalDiscount = 0;
  var optionPrice = 0;
  _this.parent().parent().parent('.purchase-item').attr('data-parent-id', product_id);
  var item_number = _this.parent().parent().parent('.purchase-item').find('#item_number option:selected').val();
  if (product_id) {
    $.ajax({
      url: document.location.origin + '/product/get-product-item/' + product_id,
      type: 'GET',
      dataType: 'JSON',
      data: {is_parent_product: true},
    })
    .done(function(res) {
      var child_data = res.item.child_data;
      var product_size = res.item.product_size;
      var product_price = res.item.product_price;
      productObject[product_id].size_count = countSizesFromAPI(res.item);
      updateProductSizeFromAPI(product_id, res.item);
      if (!isEmpty(child_data)) {
        var selectedSizeId = getSelectedSizeProductId(product_id);
        appendOptionProductSizeModified(_this, child_data, res.item, product_id, selectedSizeId);
        calcPriceOfItem(_this);
        product_id = _this.parent().parent().parent('.purchase-item').find('#product_size option:selected').attr('data-product-id');

        changeInputPrices(_this, product_id);
        _this.parent().find('#product_id').val(product_id);
        _this.attr('name', 'product_items['+product_id+'][product_name]');
        _this.parent().parent().parent('.purchase-item').find('#product_size').attr('name', 'product_items['+product_id+'][product_size]');
        _this.parent().parent().parent('.purchase-item').find('#item_number').attr('name', 'product_items['+product_id+'][item_number]');
        $.ajax({
          url: document.location.origin + '/product/get-product-item/' + product_id,
          type: 'GET',
          dataType: 'JSON',
          data: {is_parent_product: true},
        })
        .done(function(res) {
          var child_data = res.item.child_data;
          var product_size = res.item.product_size;
          var product_price = res.item.product_price;
          calcPriceOfItem(_this);
          var totalPrice = calcTotalPrice();
          handleTotalPrice(totalPrice);
          var portal_discount = res.item.portal_discount;
          var shop_discount = res.item.shop_discount;
          var totalDisCount = calcTotalDisCount(_this, portal_discount, shop_discount, item_number);
          handleTotalDiscount(totalDisCount);
          //option price
          optionPrice = calcOptionPrice(_this, res, item_number);
          var product_price_item = _this.parent().parent().parent('.purchase-item').find('#product_size option:selected').attr('data-price');
          _this.parent().parent().parent('.purchase-item').find('#product_price').val(product_price_item);
          _this.parent().parent().parent('.purchase-item').find('#product_price').attr('name', 'product_items['+product_id+'][product_price]');
          _this.parent().parent().parent('.purchase-item').attr('data-product-price', product_price);
          updateProductIdFromSelectedOptions();
          addOrRemoveProductBasedOnUsedProducts();
          refreshProductSelectors();
          refreshSizeSelectors();
          calculateSinglePayment(_this, product_price, optionPrice, totalDisCount, item_number);
        });
      } else {
        removeOptionProductSize(_this);
        appendOptionProductSize(_this, product_size, product_price, product_id);
        calcPriceOfItem(_this);
      }
      var totalPrice = calcTotalPrice();
      handleTotalPrice(totalPrice);
      var portal_discount = res.item.portal_discount;
      var shop_discount = res.item.shop_discount;
      var totalDisCount = calcTotalDisCount(_this, portal_discount, shop_discount, item_number);
      handleTotalDiscount(totalDisCount);
      //option price
      optionPrice = calcOptionPrice(_this, res, item_number);
      var product_price_item = _this.parent().parent().parent('.purchase-item').find('#product_size option:selected').attr('data-price');
      _this.parent().parent().parent('.purchase-item').find('#product_price').val(product_price_item);
      _this.parent().parent().parent('.purchase-item').find('#product_price').attr('name', 'product_items['+product_id+'][product_price]');
      _this.parent().parent().parent('.purchase-item').attr('data-product-price', product_price);
      // removeSizeIfHasSelected(_this, product_id);
      updateProductIdFromSelectedOptions();
      addOrRemoveProductBasedOnUsedProducts();
      refreshProductSelectors();
      refreshSizeSelectors();
      calculateSinglePayment(_this, product_price, optionPrice, totalDisCount, item_number);
    });
  }else{
    var _purchaseItem = _this.parent().parent().parent('.purchase-item');
    fake_product_id = minFakeProductId();
    fake_product_id = parseInt(fake_product_id) - 1;
    removeOptionProductSize(_this);

    changeInputPrices(_this, fake_product_id);
    _purchaseItem.find('#product_size').append('<option value="" selected="selected" data-price="0" data-product-id="">指定なし</option>');
    _purchaseItem.find('#product_price_of_size').html(numberWithCommas('0'));
    _purchaseItem.find('#totalPriceOfItem').val(0);
    _purchaseItem.find('#totalDiscountOfItem').val(0);
    _purchaseItem.find('#optionPriceOfItem').val(0);
    _purchaseItem.find('#priceOfItem').val(0);
    _purchaseItem.removeAttr('data-parent-id');
    _purchaseItem.removeAttr('data-product-id');
    _purchaseItem.removeAttr('data-product-price');
    _this.parent().find('#product_id').val(fake_product_id);
    _this.attr('name', 'product_items[' + fake_product_id + '][product_name]');
    _purchaseItem.find('#product_size').attr('name', 'product_items[' + fake_product_id + '][product_size]');
    _purchaseItem.find('#item_number').attr('name', 'product_items[' + fake_product_id + '][item_number]');
    _purchaseItem.find('#product_price').val('');
    _purchaseItem.find('#product_price').attr('name', 'product_items[' + fake_product_id + '][product_price]');
    refreshProductSelectors();
    refreshSizeSelectors();
    calculatePaymentPrice();
  }
});
$(document).on('change', '#product_size', function(e) {
  e.stopPropagation();
  var totalPrice = 0;
  var totalDiscount = 0;
  var optionPrice = 0;
  var _this = $(this);
  var product_id = _this.find(':selected').attr('data-product-id');
  $(this).parent().parent().parent('.purchase-item').attr('data-product-id', product_id);
  $(this).parent().parent().parent('.purchase-item').find('.add-remove-links [data-action="removeItem"]').attr('data-product-id', product_id);

  _this.attr('name', 'product_items['+product_id+'][product_size]');
  changeInputPrices(_this, product_id);
  _this.parent().parent().parent('.purchase-item').find('#product_price').attr('name', 'product_items['+product_id+'][product_price]');
  _this.parent().parent().parent('.purchase-item').find('#product_name').attr('name', 'product_items['+product_id+'][product_name]');
  _this.parent().parent().parent('.purchase-item').find('#item_number').attr('name', 'product_items['+product_id+'][item_number]');
  var number = _this.parent().parent().parent('.purchase-item').find('#item_number').val();
  var product_price = $(this).find(':selected').attr('data-price');
  var price = parseInt(product_price) * parseInt(number);
  // var totalPrice = 0;
  _this.parent().parent().parent('.purchase-item').find('#product_price_of_size').html(numberWithCommas(product_price));
  _this.parent().parent().parent('.purchase-item').find('#product_price').val(product_price);
  _this.parent().parent().parent('.purchase-item').find('#totalPriceOfItem').val(price);
  _this.parent().parent().parent('.purchase-item').attr('data-product-price', product_price);

  // $('input[name="totalPriceOfItem"]').each(function(index, el) {
  //   totalPrice += parseInt($(el).val());
  // });
  // $('input[name="totalPriceHidden"]').val(totalPrice);
  // $('#totalPrice').html(numberWithCommas(totalPrice));

  $.ajax({
    url: document.location.origin + '/product/get-product-item/' + product_id,
    type: 'GET',
    dataType: 'JSON',
    data: {is_parent_product: true},
  })
  .done(function(res) {
    if (res && res.item && res.item.parent_id == '0') {
      updateProductSizeFromAPI(product_id, res.item);
    }
    var portal_discount = res.item.portal_discount != '' ? res.item.portal_discount : 0;
    var shop_discount = res.item.shop_discount != '' ? res.item.shop_discount : 0;
    totalDiscount = calcTotalDisCount(_this, portal_discount, shop_discount);
    handleTotalDiscount(totalDiscount);
    //option price
    optionPrice = calcOptionPrice(_this, res, number);

    // var siblings_purchase_item = _this.parent().parent().parent('.purchase-item').siblings('.purchase-item');
    // siblings_purchase_item.each(function(index, el) {
    //   var data_product_sizes = $(el).find('#product_size option');
    //   data_product_sizes.each(function(ind, elm) {
    //     if($(elm).val() == _this.val()){
    //       $(elm).remove();
    //     }
    //   });
    // });
    updateProductIdFromSelectedOptions();
    refreshSizeSelectors();
    calculateSinglePayment(_this, product_price, optionPrice, totalDiscount, number);
  });
});
$(document).on('change', '#item_number', function(){
  var _this = $(this);
  var number = _this.val();
  var totalPrice = 0;
  var totalDiscount = 0;
  var optionPrice = 0;
  var product_price = _this.parent().parent().parent('.purchase-item').find('#product_size').find(':selected').attr('data-price');
  if (!product_price) {
    product_price = _this.parent().parent().parent('.purchase-item').attr('data-product-price');
  }
  if (!product_price) {
    return;
  }
  var price = parseInt(product_price) * parseInt(number);
  _this.parent().parent().parent('.purchase-item').find('#product_price_of_size').html(numberWithCommas(product_price));
  _this.parent().parent().parent('.purchase-item').find('#totalPriceOfItem').val(price);
  // $('input[name="totalPriceOfItem"]').each(function(index, el) {
  //   totalPrice += parseInt($(el).val());
  // });
  // $('input[name="totalPriceHidden"]').val(totalPrice);
  // $('#totalPrice').html(numberWithCommas(totalPrice));

  var product_id = _this.parent().parent().parent('.purchase-item').attr('data-product-id');
  $(this).parent().parent().parent('.purchase-item').attr('data-product-id', product_id);
  $(this).parent().parent().parent('.purchase-item').find('.add-remove-links [data-action="removeItem"]').attr('data-product-id', product_id);

  $.ajax({
    url: document.location.origin + '/product/get-product-item/' + product_id,
    type: 'GET',
    dataType: 'JSON',
    data: {is_parent_product: true},
  })
  .done(function(res) {
    if (!isEmpty(res)) {
      var portal_discount = res.item.portal_discount != '' ? res.item.portal_discount : 0;
      var shop_discount = res.item.shop_discount != '' ? res.item.shop_discount : 0;
      var totalDiscount = calcTotalDisCount(_this, portal_discount, shop_discount);
      handleTotalDiscount(totalDiscount);
      //option price
      optionPrice = calcOptionPrice(_this, res, number);
      calculateSinglePayment(_this, product_price, optionPrice, totalDiscount, number);
    }
  });
});
$(document).on('change', '#calendar', function(){
  var _this = $(this);
  if(_this.val() != ''){
    _this.removeClass('color-ff0000');
    _this.parent().parent().find('.p-err-last-name').html('');
  }
});


function removeOptionProductSize(_this)
{
  _this.parent().parent().parent('.purchase-item').find('#product_size').find('option').remove();
}
function appendOptionProductSize(_this, product_size, product_price, product_id)
{
  if(product_size == ''){
    if(product_price == ''){
      _this.parent().parent().parent('.purchase-item').find('#product_size').append('<option value="" selected="selected" data-price="0" data-product-id="">指定なし</option>');
    }else{
      _this.parent().parent().parent('.purchase-item').find('#product_size').append('<option value="'+product_size+'" selected="selected" data-price="'+product_price+'" data-product-id="'+product_id+'">指定なし</option>');
    }
  }else{
    _this.parent().parent().parent('.purchase-item').find('#product_size').append('<option value="'+product_size+'" data-price="'+product_price+'" data-product-id="'+product_id+'">'+convertCakeSize(product_size)+'</option>');
  }
}
function calcPriceOfItem(_this)
{
  var product_price = _this.parent().parent().parent('.purchase-item').find('#product_size').find(':selected').attr('data-price');
  var number = _this.parent().parent().parent('.purchase-item').find('#item_number').val();
  var price = parseInt(product_price) * parseInt(number);
  _this.parent().parent().parent('.purchase-item').find('#product_price_of_size').html(numberWithCommas(product_price));
  _this.parent().parent().parent('.purchase-item').find('#totalPriceOfItem').val(price);
}
function calcTotalPrice()
{
  var totalPrice = 0;
  $('input[name="totalPriceOfItem"]').each(function(index, el) {
    totalPrice += parseInt(this.value);
  });
  return totalPrice;
}
function handleTotalPrice(totalPrice)
{
  $('input[name="totalPriceHidden"]').val(totalPrice);
  $('#totalPrice').html(numberWithCommas(totalPrice));
}
function calcTotalDisCount(self, portal_discount, shop_discount, item_number)
{
  var portal_discount = portal_discount != '' ? portal_discount : 0;
  var shop_discount = shop_discount != '' ? shop_discount : 0;
  var totalDiscount = (parseFloat(portal_discount) + parseFloat(shop_discount));
  self.parent().parent().parent('.purchase-item').find('#totalDiscountOfItem').val(totalDiscount);
  return totalDiscount;
}
function handleTotalDiscount(totalDiscount)
{
  $('#totalDiscount').html(totalDiscount > 0 ? ('-' + numberWithCommas(totalDiscount)) : ('-' + 0));
  $('#totalDiscountHidden').val(totalDiscount);
}
function handlePaymentPrice(paymentPrice)
{
  $('#paymentPriceHidden').val(paymentPrice);
  $('#paymentPrice').html(numberWithCommas(paymentPrice));
  $('#totalDiscountOneItem').html(numberWithCommas(paymentPrice));
}

function removeSizeIfHasSelected(_this, product_id)
{
  var siblings_purchase_item = _this.parent().parent().parent('.purchase-item').siblings('.purchase-item');
  siblings_purchase_item.each(function() {
    var data_product_id = $(this).find('#product_name option:selected').attr('data-product-id');
    if (product_id == data_product_id){
      var size_product = $(this).find('#product_size option:selected').val();
      _this.parent().parent().parent('.purchase-item').find('#product_size option[value="'+size_product+'"][data-product-id="'+product_id+'"]').remove();
    }
  });
}

function calcOptionPrice(self, res, number)
{
  var optionPrice = 0;
  for (var i = 1; i <= 10; ++i) {
    var any_item = 'any_item_' + i;
    var pulldown = res.item[any_item].pulldown;
    if (!isEmpty(pulldown)) {
      var option_prices = pulldown.option_price;
      var option_prices_arr = [];
      if (option_prices != "") {
        option_prices = option_prices.trim();
        option_prices = option_prices.replace(/ /g, '');
        option_prices_arr = option_prices.split(',');
        if (option_prices_arr.length > 0) {
          optionPrice += parseFloat(option_prices_arr[0]);
        }
      }
    }
  }
  return optionPrice;
}
$(function () {
  $('#purchaseItems').on('click', '[data-action="addItem"]', function (e) {
    e.preventDefault();
    var $clone = $(this).closest('.purchase-item').clone();
    $(this).hide();
    $(this).prev().show();
    var _this = $(this);
    fake_product_id = minFakeProductId();
    fake_product_id = parseInt(fake_product_id) - 1;
    changeInputPrices($clone, fake_product_id);

    $clone.attr('data-product-id', fake_product_id);
    $clone.attr('data-parent-id', fake_product_id);
    $clone.attr('data-product-price', '0');
    $clone.find('.item_name').val('');
    $clone.find('.item_size').find('option').remove();
    $clone.find('.item_size').append('<option value="">指定なし</option>');
    $clone.find('.item_size').val('');
    $clone.find('.item_number').val('1');
    $clone.find('#product_price').val('0');
    $clone.find('#totalPriceOfItem').val('0');
    $clone.find('#totalDiscountOfItem').val('0');
    $clone.find('#optionPriceOfItem').val('0');
    $clone.find('#product_price_of_size').html('0');
    $clone.find('#priceOfItem').val('0');
    $clone.find('#product_name').removeClass('color-ff0000');
    $clone.find('#product_size').removeClass('color-ff0000');
    $clone.find('.p-err-last-name').html('');
    removeProductWhenAllSizesHaveSelected($clone);
    removeParentProductsHaveNoSize($clone);
    $('#purchaseItems').append($clone);

    var productId = _this.parent().parent('.purchase-item').attr('data-product-id');
    updateProductIdFromSelectedOptions();
    $clone.find('.item_name').attr('name', 'product_items[' + fake_product_id + '][product_name]');
    $clone.find('#product_size').attr('name', 'product_items[' + fake_product_id + '][product_size]');
    $clone.find('#product_price').attr('name', 'product_items['+fake_product_id+'][product_price]');
    $clone.find('#item_number').attr('name', 'product_items[' + fake_product_id + '][item_number]');

    refreshProductSelectors();
    refreshSizeSelectors();
    adjustAddRemoveLinks();
  }).on('click', '[data-action="removeItem"]', function (e) {
    e.preventDefault();
    var parentId = $(this).parent().parent('.purchase-item').attr('data-parent-id');
    $(this).closest('.purchase-item').remove();
    if (!isEmpty(parentId) && parentId != '') {
      addProductIfStillCanBeAdded(parentId);
    }
    calculatePaymentPrice();
    refreshProductSelectors();
    refreshSizeSelectors();
    adjustAddRemoveLinks();
  })
})
$(document).on('click', '#p-register', function(e){
  e.preventDefault();
  if($(this).find('#register').prop('checked')){
    $(this).find('#register').prop('checked', false);
  }else{
    $(this).find('#register').prop('checked', true)
  }
});
/** Appends options for sizes */
function appendOptionProductSizeModified(self, child_data, product_item, product_id, selectedSizeIds) {
  removeOptionProductSize(self);
  var sizes = [];
  var childDataIds = Object.keys(child_data);
  if (child_data && childDataIds.length) {
    sizes = childDataIds.map(function (id) {
      return {
        product_id: id,
        product_price: child_data[id].product_price,
        product_size: child_data[id].product_size
      };
    });
  }
  if (product_item.product_size != '') {
    sizes.push({
      product_id: product_id,
      product_price: product_item.product_price,
      product_size: product_item.product_size
    });
  }
  sizes.sort(function (a, b) {
    return parseInt(a.product_size) - parseInt(b.product_size);
  });
  var firstItem = {
    product_id: product_id,
    product_size: product_item.product_size,
    product_price: product_item.product_price
  };
  sizes = sizes.filter(function (item) {
    return selectedSizeIds.indexOf(item.product_id) < 0;
  });
  sizes.forEach(function (item) {
    appendSize(self, item, product_id);
  });
  return sizes;
}
function appendSize(self, product_item, product_id) {
  if (product_item.product_size == '') {
    self.parent().parent().parent('.purchase-item').find('#product_size').append('<option value="" selected="selected" data-price="0" data-product-id="">指定なし</option>');
  } else {
    self.parent().parent().parent('.purchase-item').find('#product_size').append('<option value="'+product_item.product_size+'" data-price="'+product_item.product_price+'" data-product-id="'+product_item.product_id+'" '+ (product_item.product_id == product_id ? 'selected':'') +'>' + convertCakeSize(product_item.product_size) + '</option>');
  }
}
function adjustAddRemoveLinks() {
  var items = $('#purchaseItems .purchase-item');
  if (items.length > 1) {
    items.each(function (index, element) {
      var productId = $(this).attr('data-product-id');
      $(this).find('.add-remove-links').html('<a href="#" class="add-arrow color-ca1419 pull-right" data-action="removeItem" data-product-id="' + productId + '">商品を削除する</a>');
      if (items.length < 5 && index == items.length - 1) { // Append add link to last item but not over 5 items
        $(this).find('.add-remove-links').append('<a href="#" class="add-arrow color-ca1419 pull-left mar-t-20px" data-action="addItem">商品を追加する</a>');
      }
    });
  } else { // Has one item
    $(items[items.length - 1]).find('.add-remove-links').html('<a href="#" class="add-arrow color-ca1419 pull-left mar-t-20px" data-action="addItem">商品を追加する</a>');
  }
}
function sumDOMs(jQueryDOM) {
  var result = 0;
  jQueryDOM.each(function () {
    result += parseFloat(this.value);
  });
  return result;
}
function calculatePaymentPrice() {
  var totalPrice = sumDOMs($('input[class="totalPriceOfItem"]'));
  var totalDiscount = sumDOMs($('input[class="totalDiscountOfItem"]'));
  var totalOptions = sumDOMs($('input[class="optionPriceOfItem"]'));
  var totalPayment = sumDOMs($('input[class="priceOfItem"]'));
  handleTotalPrice(totalPrice);
  handleTotalDiscount(totalDiscount)
  handlePaymentPrice(totalPayment);
  return totalPayment;
}
function calculateSinglePayment(self, productPrice, optionPrices, totalDiscount, quantity) {
  var total = (parseFloat(productPrice) + optionPrices - totalDiscount) * quantity;
  var parent = self.parent().parent().parent('.purchase-item');
  parent.find('#totalPriceOfItem').val(productPrice * quantity);
  parent.find('#totalDiscountOfItem').val(totalDiscount * quantity);
  parent.find('#optionPriceOfItem').val(optionPrices * quantity);
  parent.find('#priceOfItem').val(total);
  calculatePaymentPrice();
  return total;
}
function updateProductIdFromSelectedOptions() {
  // Update product id from selected options
  $('select.item_name, select.item_size').each(function () {
    var productId = $(this).find('option:selected').attr('data-product-id');
    if (productId) {
      var parent = $(this).parent().parent().parent('.purchase-item');
      parent.attr('data-product-id', productId);
      parent.find('#product_name').attr('name', 'product_items[' + productId + '][product_name]');
      parent.find('#product_size').attr('name', 'product_items[' + productId + '][product_size]');
      parent.find('#item_number').attr('name', 'product_items[' + productId + '][item_number]');
    }
  });
}
/** Remove all products with parent_id has no size */
function removeParentProductsHaveNoSize(cloneDOM) {
  var parentProducts = $('.purchase-item');
  var parent_ids = [];
  parentProducts.each(function (index) {
    var self = $(this);
    var parent_id = self.attr('data-parent-id');
    var size = self.find('#product_size');
    if (size.val() == '' && size.find('option').length == 1) {
      parent_ids.push(parent_id);
    }
  });
  parent_ids.forEach(function (id) {
    cloneDOM.find('#product_name option[data-product-id="' + id + '"]').remove();
  });
  return parent_ids;
}
function getSelectedSizeProductId(productId) {
  var result = [];
  $('.purchase-item[data-parent-id="' + productId + '"]').each(function () {
    if ($(this).find('#product_size').val() != '') {
      result.push($(this).find('#product_size option:selected').attr('data-product-id'));
    }
  });
  return result;
}
function removeProductWhenAllSizesHaveSelected(cloneDOM) {
  var purchaseItems = $('.purchase-item');
  var lookupObject = {};
  purchaseItems.each(function () {
    var parentId = $(this).attr('data-parent-id');
    if (!lookupObject[parentId]) {
      lookupObject[parentId] = 0;
    }
    lookupObject[parentId] += 1;
  });

  /**
   * Filter product-parent-id need to be removed
   * by comparing with max sizes of product
   */
  Object.keys(lookupObject).forEach(function (id) {
    if (!canAddedMoreProduct(id)) {
      cloneDOM.find('#product_name option[data-product-id="' + id + '"]').remove();
    }
  });

}
$(document).on('focus', '.inp-s-product-2', function(){
  $('#areaModal').css('position','static');
  $("html, body").animate({ scrollTop: $(document).height() }, 100);
});
function countUsedProducts(product_id) {
  var count = 0;
  $('.purchase-item').each(function () {
    if ($(this).attr('data-parent-id') == product_id) {
      count += 1;
    }
  });
  return count;
}
function canAddedMoreProduct(product_id) {
  var usedCount = countUsedProducts(product_id);
  if (isEmpty(productObject) || isEmpty(productObject[product_id])) {
    return false;
  }
  if (usedCount == 0 && productObject[product_id].data.product_size == '') {
    return true;
  }
  return usedCount < productObject[product_id].size_count;
}
function removeProductFromOtherSelector(product_id) {
  $('.purchase-item').each(function () {
    var self = $(this);
    if (self.attr('data-parent-id') != product_id) {
      self.find('#product_name option[data-product-id="' + product_id + '"]').remove();
    }
  });
}
function addProductToOtherSelector(parentId) {
  $('.purchase-item').each(function () {
    if ($(this).attr('data-parent-id') != parentId) {
      var productDetail = productObject[parentId].data;
      if (!isEmpty(productDetail)) {
        $(this).find('#product_name').append('<option value="' + productDetail.product_name + '" data-product-id="' + parentId + '">' + productDetail.product_name + '</option>');
      }
    }
  });
}
function addOrRemoveProductBasedOnUsedProducts() {
  var purchaseItems = $('.purchase-item');
  var parentId = '';
  purchaseItems.each(function () {
    parentId = $(this).attr('data-parent-id');
    if (!canAddedMoreProduct(parentId)) {
      removeProductFromOtherSelector(parentId);
    }
  });
}
function minFakeProductId(){
  var min = 0;
  $('.purchase-item').each(function(index, el) {
    var data_product_id = parseInt($(el).attr('data-product-id'));
    if(data_product_id < 0){
      if(data_product_id < min){
        min = data_product_id;
      }
    }
  });
  return min;
}
/** Remove item from screen */
function addProductIfStillCanBeAdded(parentId) {
  if (parentId && !isEmpty(parentId) && parentId != '0' && (canAddedMoreProduct(parentId) || (productObject[parentId] && productObject[parentId].data.product_size == ''))) {
    addProductToOtherSelector(parentId);
  }
}
function countSizesFromAPI(product) {
  var count = 0;
  if (!isEmpty(product.product_size) && product.product_size != '') {
    count += 1;
  }
  if (!isEmpty(product.child_data)) {
    count += Object.keys(product.child_data).length;
  }
  return count;
}
function refreshProductSelectors() {
  // Iterate all .purchase-item -> parentId
  // -- Loop product array -> product_id
  // -- -- If product_id == parentId || canAddedMoreItem(product_id)
  // -- -- -- Push to haystack
  $('.purchase-item').each(function () {
    var self = $(this);
    var parentId = self.attr('data-parent-id');
    // Remove all product options
    self.find('#product_name').html('<option value="">選択してください</option>');
    productArray.forEach(function (product, index) {
      if (product.product_id == parentId || canAddedMoreProduct(product.product_id)) {
        // If product item in iteration is matched with parent id. Mark as selected
        if (product.product_id == parentId) {
          self.find('#product_name').append('<option value="' + product.product_name + '" data-product-id="' + product.product_id + '" selected>' + product.product_name + '</option>');
        } else {
          self.find('#product_name').append('<option value="' + product.product_name + '" data-product-id="' + product.product_id + '">' + product.product_name + '</option>');
        }
      }
    });
  });
}
function updateProductSizeFromAPI(parentId, product) {
  if (!product || isEmpty(product)) {
    return;
  }

  var sizes = [];
  if (!isEmpty(product.child_data)) {

    Object.keys(product.child_data).forEach(function (childId, index) {
      sizes.push({
        product_id: childId,
        product_size: product.child_data[childId].product_size,
        product_price: product.child_data[childId].product_price
      });
    });

  }
  if (product.product_size != '') {
    sizes.push({
      product_id: parentId,
      product_size: product.product_size,
      product_price: product.product_price
    });
  }
  sizes.sort(function (a, b) {
    return parseInt(a.product_size) - parseInt(b.product_size);
  });
  productSizeLookup[parentId] = sizes;
}
function getUsedProductIdByParentId(parent_id) {
  var result = [];
  $('.purchase-item[data-parent-id="' + parent_id + '"]').each(function () {
    // var productId = $(this).find('#product_size option:selected').attr('data-product-id');
    var productId = $(this).attr('data-product-id');
    if (!isEmpty(productId) && productId != '') {
      result.push(productId);
    }
  });
  return result;
}
function canSizeBeUsed(product_id, parent_id) {
  var usedProductId = getUsedProductIdByParentId(parent_id);
  return usedProductId.indexOf(product_id) < 0;
}
function refreshSizeSelectors() {
  // Loop .purchase-item -> data-parent-id, data-product-id
  // Iterating through productSizeLookup[parent_id]
  // -- If product_id == data-product-id || canSizeBeUsed(product_id, parent_id)
  // -- -- Push to haystack
  $('.purchase-item').each(function () {
    var self = $(this);
    var parent_id = self.attr('data-parent-id');
    var selected_product_id = self.attr('data-product-id');
    if (productSizeLookup[parent_id] && productSizeLookup[parent_id].length) {
      self.find('#product_size').html('');
      // Iterating through productSizeLookup
      productSizeLookup[parent_id].forEach(function (size, index) {
        if (selected_product_id == size.product_id || canSizeBeUsed(size.product_id, parent_id)) {
          // PUSH TO OPTIONS
          if (selected_product_id == size.product_id) {
            self.find('#product_size').append('<option value="' + size.product_size + '" data-price="' + size.product_price + '" data-product-id="' + size.product_id + '" selected>' + convertCakeSize(size.product_size) + '</option>');
          } else {
            self.find('#product_size').append('<option value="' + size.product_size + '" data-price="' + size.product_price + '" data-product-id="' + size.product_id + '">' + convertCakeSize(size.product_size) + '</option>');
          }
        }
      });
    }
  });
}
