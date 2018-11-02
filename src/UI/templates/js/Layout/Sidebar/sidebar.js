il = il || {};
il.UI = il.UI || {};
il.UI.layout = il.UI.layout || {};


(function($, layout) {
	layout.sidebar = (function($) {
		var _cls_engaged = 'engaged';
		var _cls_tools_container = 'il-sidebar-tool-triggers';

		/**
		 * @param string id 	the sidebar's id
		 */
		var onClickEntry = function(event, signalData, id) {
			var triggerer = signalData.triggerer,
				trigger_buttons = $('#' + id + ' .il-sidebar-triggers .btn'),
				tool_trigger_buttons = $('#' + id + ' .il-sidebar-tool-triggers .btn'),
				all_triggers = trigger_buttons.add(tool_trigger_buttons)
				is_tool_triggerer = signalData.triggerer.parent()
					.hasClass(_cls_tools_container)
				main_tool_button = $('#' + id + ' .il-sidebar-tools-button .btn');

			//set all non-triggerer to inactive
			all_triggers.each( function(index, obj) {
				if($(obj).attr('id') != triggerer.attr('id')) {
					$(obj).removeClass(_cls_engaged);
					$(obj).attr('aria-pressed', false);
				}
			});

			//toggle triggerer active/inactive (if not a tool)
			if(! is_tool_triggerer) {
				if(triggerer.hasClass(_cls_engaged)) {
					triggerer.removeClass(_cls_engaged);
					triggerer.attr('aria-pressed', false);
				} else {
					triggerer.addClass(_cls_engaged);
					triggerer.attr('aria-pressed', true);
				}
				main_tool_button.removeClass(_cls_engaged);

			} else {
					triggerer.addClass(_cls_engaged);
					triggerer.attr('aria-pressed', true);
					main_tool_button.addClass(_cls_engaged);
			}
		};

		return {
			onClickEntry: onClickEntry
		}

	})($);
})($, il.UI.layout);
