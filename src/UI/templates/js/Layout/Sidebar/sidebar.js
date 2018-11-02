il = il || {};
il.UI = il.UI || {};
il.UI.layout = il.UI.layout || {};


(function($, layout) {
	layout.sidebar = (function($) {
		var _cls_engaged = 'engaged',
			_cls_tools_container = 'il-sidebar-tool-triggers',
			_last_tool_button,
			_last_tool_slate
		;

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
				main_tool_button = $('#' + id + ' .il-sidebar-tools-button .btn')
				;

			//set all non-triggerer to inactive
			all_triggers.each( function(index, obj) {
				if($(obj).attr('id') != triggerer.attr('id')) {
					$(obj).removeClass(_cls_engaged);
					$(obj).attr('aria-pressed', false);
				}
			});

			//toggle triggerer active/inactive (if not a tool)
			if(! is_tool_triggerer) {
				_toggleButton(triggerer);
				main_tool_button.removeClass(_cls_engaged);

			} else {
				triggerer.addClass(_cls_engaged);
				triggerer.attr('aria-pressed', true);
				_last_tool_button = triggerer;
				_last_tool_slate = $('#' + id + ' .il-maincontrol-menu-slate.engaged');

				main_tool_button.addClass(_cls_engaged);
			}
		};


		var onClickToolsEntry = function(event, signalData, id) {
			var tools_button = signalData.triggerer
				trigger_buttons = $('#' + id + ' .il-sidebar-triggers .btn');

			//if engaged: disengage all others
			if(! tools_button.hasClass(_cls_engaged)) {
				trigger_buttons.removeClass(_cls_engaged);
			}

			if(! _last_tool_button) { //clicked for the first time (before any tool was active)
				var tool_trigger_buttons = $('#' + id + ' .il-sidebar-tool-triggers .btn');
				_last_tool_button = tool_trigger_buttons[0];
				_last_tool_button.click();
				_last_tool_slate = $('#' + id + ' .il-maincontrol-menu-slate.engaged');
				tools_button.removeClass(_cls_engaged);
				_last_tool_button.removeClass(_cls_engaged);
				_last_tool_slate.removeClass(_cls_engaged);
			}

			il.UI.maincontrols.menu.slate.toggle(_last_tool_slate);
			_toggleButton(_last_tool_button);
			_toggleButton(tools_button);
		}


		var _toggleButton = function(btn) {
			if(btn.hasClass(_cls_engaged)) {
				btn.removeClass(_cls_engaged);
				btn.attr('aria-pressed', false);
			} else {
				btn.addClass(_cls_engaged);
				btn.attr('aria-pressed', true);
			}
		};

		return {
			onClickEntry: onClickEntry,
			onClickToolsEntry: onClickToolsEntry
		}

	})($);
})($, il.UI.layout);
