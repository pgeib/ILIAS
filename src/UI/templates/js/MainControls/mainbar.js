il = il || {};
il.UI = il.UI || {};
il.UI.maincontrols = il.UI.maincontrols || {};

(function($, maincontrols) {
	maincontrols.mainbar = (function($) {

		var id
			,_cls_btn_engaged = 'engaged'
			,_cls_page_active_slates = 'with-mainbar-slates-engaged' //set on _page_div
			,_cls_entries_wrapper = 'il-mainbar-entries' //encapsulating div of all entries
			,_cls_toolentries_wrapper = 'il-mainbar-tools-entries' //tools (within  _cls_entries_wrapper)
			,_cls_tools_wrapper = 'il-mainbar-tools-entries' //encapsulating div of all tool-entries
			,_cls_tools_btn = 'il-mainbar-tools-button' //encapsulating div of the tools-button
			,_cls_page_div = 'il-layout-page' //encapsulating div of the page
			,_cls_slates_wrapper = 'il-mainbar-slates' //encapsulating div of mainbar's slates
			,_cls_single_slate = false //class of one single slate, will be set on registerSignals
			,_cls_slate_engaged = false //engaged class of a slate, will be set on registerSignals
		;

		var registerSignals = function (
			component_id,
			entry_signal,
			close_slates_signal,
			tools_signal,
			tools_removal_signal
		) {
			id = component_id;
			_cls_single_slate = il.UI.maincontrols.slate._cls_single_slate;
			_cls_slate_engaged = il.UI.maincontrols.slate._cls_engaged;

			$(document).on(entry_signal, function(event, signalData) {
				onClickEntry(event, signalData);
				return false;
			});
			$(document).on(close_slates_signal, function(event, signalData) {
				onClickDisengageAll(event, signalData);
				return false;
			});
			$(document).on(tools_signal, function(event, signalData) {
				onClickToolsEntry(event, signalData);
				return false;
			});
			$(document).on(tools_removal_signal, function(event, signalData) {
				onClickToolRemoval(event, signalData);
				return false;
			});
		};

		var initActive = function(component_id) {
			id = component_id;
			var btn = _getAllButtons()
				.filter('.' + _cls_btn_engaged);
			_disengageButton(btn);
			btn.click();
		}

		var onClickEntry = function(event, signalData) {
			var btn = signalData.triggerer;
			if(_isEngaged(btn)) {
				if(! _isToolButton(btn)) {
					_disengageButton(btn);
					_setPageSlatesActive(false);
				}
			} else {
				_disengageAllButtons(); //reset, so that only _one_ is active
				_disengageAllSlates();
				_engageButton(btn);
				_setPageSlatesActive(true);
				if(_isToolButton(btn)) {
					_setToolsActive(true);
					_engageButton(_getToolsButton());
				} else {
					_setToolsActive(false);
				}
			}
		};

		var onClickDisengageAll = function(event, signalData) {
			_disengageAllButtons();
			_disengageAllSlates();
			_setPageSlatesActive(false);
		};

		var onClickToolsEntry = function(event, signalData) {
			var btn = signalData.triggerer;

			if(_isEngaged(btn)) {
				_setPageSlatesActive(false);
				_setToolsActive(false);
				_disengageButton(btn);
			} else {
				_setPageSlatesActive(true);
				_setToolsActive(true);
				_engageButton(btn);

				if(!_isAnyToolActive()) {
					_getAllToolButtons()[0].click();
				}
			}
		};

		var onClickToolRemoval = function(event, signalData) {
			var search = '#' + id + ' .' + _cls_toolentries_wrapper + ' .btn',
			active_tool_btn = $(search).filter(' .' + _cls_btn_engaged),
			remaining;

			active_tool_btn.remove();
			remaining = $(search);

			if(remaining.length > 0) {
				$(remaining[0]).click();
			} else {
				_disengageAllSlates();
				_setPageSlatesActive(false);
				_setToolsActive(false);
				_getToolsButton().remove();
			}
		};

		var _getToolsButton = function() {
			return $('#' + id + ' .' + _cls_tools_btn + ' .btn');
		};

		var _isToolButton = function(btn) {
			return btn.parent().hasClass(_cls_tools_wrapper);
		};

		var _isAnyToolActive = function(btn) {
			return _getAllToolButtons()
				.filter('.' + _cls_btn_engaged)
				.length > 0;
		};

		var _getAllToolButtons = function() {
			var search = '#' + id + ' .' + _cls_tools_wrapper + ' .btn';
			return $(search);
		};

		var _getAllButtons = function() {
			var search = '#' + id + ' .' + _cls_entries_wrapper + ' .btn';
			return $(search);
		};

		/**
		 * If any slates are active in the mainbar,
		 * the overall template has to be alerted
		 * in order to make room for the slate.
		 */
		var _setPageSlatesActive = function(active) {
			var page_div = $('.' + _cls_page_div);
			if(active) {
				page_div.addClass('with-engaged-slates'); //TODO: remove
				page_div.addClass(_cls_page_active_slates);
			} else {
				page_div.removeClass('with-engaged-slates'); //TODO: remove
				page_div.removeClass(_cls_page_active_slates);
			}
		};

		var _setToolsActive = function(active) {
			var tools_area = $('#' + id +' .' + _cls_toolentries_wrapper);
			if(active) {
				tools_area.addClass(_cls_btn_engaged);
			} else {
				tools_area.removeClass(_cls_btn_engaged);
			}
		};

		var _engageButton = function(btn) {
			btn.addClass(_cls_btn_engaged);
			btn.attr('aria-pressed', true);
		};

		var _disengageButton = function(btn) {
			btn.removeClass(_cls_btn_engaged);
			btn.attr('aria-pressed', false);
		};

		var _isEngaged = function(btn) {
			return btn.hasClass(_cls_btn_engaged);
		};

		var _toggleButton = function(btn) {
			_isEngaged(btn)? _disengageButton(btn) : _engageButton(btn);
		};

		var _disengageAllButtons = function() {
			_getAllButtons().filter('.' + _cls_btn_engaged).each(
				function(i, btn) {
					_disengageButton($(btn));
				}
			);
		};

		var _disengageAllSlates = function() {
			$('#' + id + ' .' + _cls_slates_wrapper)
			.children('.' + _cls_single_slate + '.' + _cls_slate_engaged)
			.each(
				function(i, slate) {
					il.UI.maincontrols.slate.disengage($(slate));
				}
			)
		};

		return {
			registerSignals: registerSignals,
			initActive: initActive
		}

	})($);
})($, il.UI.maincontrols);
