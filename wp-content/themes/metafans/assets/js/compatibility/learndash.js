jQuery(document).ready(function(){
	jQuery('.lms-toggle-lesson').on('click', function(e){
		e.preventDefault();
		jQuery(this).parents('.lms-lesson-item').toggleClass('item-open').find('.lms-lesson-content').slideToggle();
	});
});