var $formAdd = $('#searchForm');

$('#butFiltrOpen').on('click', function(event) {
	event.preventDefault();
	$formAdd.slideToggle();

});