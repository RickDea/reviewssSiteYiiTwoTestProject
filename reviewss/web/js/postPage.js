var $formAdd = $('#formAddComment');
$formAdd.hide();

$('#butComment').on('click', function(event) {
	event.preventDefault();
	
	$formAdd.slideToggle();
	$(this).fadeOut();
});