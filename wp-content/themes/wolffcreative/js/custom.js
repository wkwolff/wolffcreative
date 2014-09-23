jQuery(window).load(function() {

	var jQuerycontainer = jQuery('.portfolio');
		jQuerycontainer.masonry({
		  columnWidth: 40,	
		  itemSelector: '.portfolio-item'
	});
});