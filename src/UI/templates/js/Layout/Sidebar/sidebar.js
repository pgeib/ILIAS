il = il || {};
il.UI = il.UI || {};
il.UI.layout = il.UI.layout || {};


(function($, layout) {
	layout.sidebar = (function($) {
		var _cls_engaged = 'engaged';


		var onClickEntry = function(event, signalData, id) {
			var triggerer = signalData.triggerer;

				//set all non-triggerer to inactive
				result = $('#' + id + ' .il-sidebar-triggers .btn');
				result.each( function(index, obj) {
					if($(obj).attr('id') != triggerer.attr('id')) {
						$(obj).removeClass(_cls_engaged);
						$(obj).attr('aria-pressed', false);
					}
				});
				//toggle triggerer active/inactive
				if(triggerer.hasClass(_cls_engaged)) {
					triggerer.removeClass(_cls_engaged);
					triggerer.attr('aria-pressed', false);
				} else {
					triggerer.addClass(_cls_engaged);
					triggerer.attr('aria-pressed', true);
				}
		};



		return {
			onClickEntry: onClickEntry
		}

	})($);
})($, il.UI.layout);
