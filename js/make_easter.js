;(function($, window, undefined) {
	
	var elem = document.getElementById("make_easter_question");
	var helpElement = document.getElementById("make_easter-help");
	
	elem.addEventListener('mouseover', function(e) {
		helpElement.style.display = 'block';
	});
	
	elem.addEventListener('mouseout', function(e) {
		helpElement.style.display = 'none';
	});
	
})(jQuery, window, undefined);