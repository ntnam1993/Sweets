$(document).ready(function(){
    // scrolltop page
        var topBtn = $('.toppage');
        topBtn.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
	//vote
	 $('.ratings_stars').hover(
        // Handles the mouseover
        function() {
            $(this).prevAll().andSelf().addClass('ratings_hover');
            // $(this).nextAll().removeClass('ratings_vote');
        },
        function() {
            $(this).prevAll().andSelf().removeClass('ratings_hover');
            // set_votes($(this).parent());
        }
    );
	$('.ratings_stars').click(function(){
		var Values =  $(this).find("input").val();
    	if ($(this).hasClass('ratings_over')) {
            $('.ratings_stars').removeClass('ratings_over');
            $(this).prevAll().andSelf().addClass('ratings_over');
        } else {
        	$(this).prevAll().andSelf().addClass('ratings_over');
        }
    });
    $('.check-ch, .c-check-ch').click(function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('input').removeAttr('checked');
        }else{
            $(this).addClass('active');
            $(this).find('input').attr('checked','checked');
        }
    });
    // if($('#get-date-picker1').length > 0){
    //     $('#get-date-picker1').datetimepicker({
    //         format: 'YYYY年MM月DD日',
    //     });
    // }

    $('.full-more-ch').click(function(){
        $(this).prev().addClass('kb5-mor-show');
        $(this).prev().find('span.opacity-span').remove();
    });

    $('script').each(function(){
        if($(this).attr('src') == '/assets/pc/js/jquery.dotdotdot.min.js'){
            $('.3-lines').dotdotdot();
        }
    });

    //Check open time that end time should be greater than start time
    $('.cus-select.start-time').change(function(){
        if(parseInt($(this).val()) >= parseInt($('.cus-select.end-time').val()) && $('.cus-select.end-time').val() != ''){
            alert('閉店時間は、開店時間より後にしてください');
            $(this).val('');
        }
    });

    $('.cus-select.end-time').change(function(){
        if(parseInt($(this).val()) <= parseInt($('.cus-select.start-time').val()) && $('.cus-select.start-time').val() != ''){
            alert('閉店時間は、開店時間より後にしてください');
            $(this).val('');
        }
    });

});

$(window).load(function() {
  for (var i = 2; i < 4; i++) {
    var src = $('#item-view-' + i).children().attr('src');
    if (src == '') {
      $('#item-view-' + i).remove();
      $('#item-prev-' + i).remove();
      $('#item-next-' + i).remove();
      $('#item-nav-' + i).remove();
    }
  }
});
$(document).ready(function(){
    var imgs = $('img');
    $.each(imgs, function(index, val) {
        var _src = $(val).attr('src');
        if(_src == ""){
            $(val).attr('src', '/assets/pc/images/thum-def.png');
        }
    });

});

