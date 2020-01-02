jQuery( document ).ready(
	function($){
		'use strict';

		$('.sa-selectize').selectize({
		    create: true,
		    sortField: 'text'
		});

		$('.sa-checkbox').on( 'change', function() {
			if ( $(this).prop('checked') ) {
				$(this).parent().next().next().removeClass('sa-hide');
			} else {
				$(this).parent().next().next().addClass('sa-hide');
			}
		});
	}
);