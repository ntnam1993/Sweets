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
    $('.check-ch').click(function(){
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

});
