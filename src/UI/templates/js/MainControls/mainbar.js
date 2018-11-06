il = il || {};
il.UI = il.UI || {};
il.UI.maincontrols = il.UI.maincontrols || {};

(function($, maincontrols) {
	maincontrols.mainbar = (function($) {

		var id
			,_cls_btn_engaged = 'engaged'
			,_cls_toolentries_engaged = 'tools_engaged'
			,_cls_page_active_slates = 'with-mainbar-slates-engaged' //set on _page_div
			,_cls_entries_wrapper = 'il-mainbar-entries' //encapsulating div of all entries
			,_cls_tools_wrapper = 'il-mainbar-tools-entries' //encapsulating div of all tool-entries
			,_cls_tools_btn = 'il-mainbar-tools-button' //encapsulating div of the tools-button
			,_cls_page_div = 'il-layout-page' //encapsulating div
		;

		var registerSignals = function (
			component_id,
			entry_signal,
			close_slates_signal,
			tools_signal,
			tools_removal_signal
		) {
			id = component_id;
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
				console.log('REMOVE TOOL');
				return false;
			});
		}

		var onClickEntry = function(event, signalData) {
			var btn = signalData.triggerer;
			if(_isEngaged(btn)) {
				if(! _isToolButton(btn)) {
					_disengageButton(btn);
					_setPageSlatesActive(false);
				}
			} else {
				_disengageAllButtons(); //reset, so that only one is active
				//_disengageAllSlates();
				_engageButton(btn);
				_setPageSlatesActive(true);
				if(_isToolButton(btn)) {
					_engageButton(_getToolsButton());
				}
			}
		}

		var onClickDisengageAll = function(event, signalData) {
			_disengageAllButtons();
			_disengageAllSlates();
			_setPageSlatesActive(false);
		}

		var onClickToolsEntry = function(event, signalData) {
			console.log('onClickToolsEntry');
		}

		var onClickToolRemoval = function(event, signalData) {
			console.log('onClickToolsRemoval');
		}

		var _getToolsButton = function() {
			return $('#' + id + ' .' + _cls_tools_btn + ' .btn');
		}

		var _isToolButton = function(btn) {
			return btn.parent().hasClass(_cls_tools_wrapper);
		}

		var _getAllButtons = function() {
			var search = '#' + id + ' .' + _cls_entries_wrapper + ' .btn';
			return $(search);
		}

		/**
		 * If any slates are active in the mainbar,
		 * the overall template has to be alerted
		 * in order to make room for the slate.
		 */
		var _setPageSlatesActive = function(active) {
			var _page_div = $('.' + _cls_page_div);
			if(active) {
				_page_div.addClass('with-engaged-slates'); //TODO: remove
				_page_div.addClass(_cls_page_active_slates);
			} else {
				_page_div.removeClass('with-engaged-slates'); //TODO: remove
				_page_div.removeClass(_cls_page_active_slates);
			}
		}

		var _engageButton = function(btn) {
			btn.addClass(_cls_btn_engaged);
			btn.attr('aria-pressed', true);
		}
		var _disengageButton = function(btn) {
			btn.removeClass(_cls_btn_engaged);
			btn.attr('aria-pressed', false);
		}
		var _isEngaged = function(btn) {
			return btn.hasClass(_cls_btn_engaged);
		}
		var _toggleButton = function(btn) {
			_isEngaged(btn)? _disengageButton(btn) : _engageButton(btn);
		}
		var _disengageAllButtons = function() {
			_getAllButtons().filter('.' + _cls_btn_engaged).each(
				function(i, btn) {
					_disengageButton($(btn));
				}
			);
		}

		var _disengageAllSlates = function() {
			$('.il-mainbar-slates .il-maincontrols-slate.engaged').each( //TODO: vars for classes
				function(i, slate) {
					il.UI.maincontrols.slate.disengage($(slate));
				}
			)
		}

		return {
			registerSignals: registerSignals
		}

	})($);
})($, il.UI.maincontrols);

