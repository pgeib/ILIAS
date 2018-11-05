<?php

/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts.and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper as UITemplateWrapper;
use ILIAS\UI\Component\Signal;

class Renderer extends AbstractComponentRenderer {
	/**
	 * @inheritdoc
	 */
	public function render(Component\Component $component, RendererInterface $default_renderer) {
		$this->checkComponent($component);

		if ($component instanceof Component\Layout\Page) {
			return $this->renderPage($component, $default_renderer);
		}
		if ($component instanceof Component\Layout\Sidebar) {
			return $this->renderSidebar($component, $default_renderer);
		}
		if ($component instanceof Component\Layout\Metabar) {
			return $this->renderMetabar($component, $default_renderer);
		}
	}

	protected function renderSidebar(Component\Layout\Sidebar $component, RendererInterface $default_renderer) {
		$tpl = $this->getTemplate("tpl.sidebar.html", true, true);
		$entry_signal = $component->getEntryClickSignal();
		$tools_signal = $component->getToolsClickSignal();
		$tools_removal_signal = $component->getToolsRemovalSignal();
		$tools = $component->getTools();
		$active =  $component->getActive();

		if (count($tools) > 0) {
			//add the tools button
			$tools_active = array_key_exists($active, $tools);
			$f = $this->getUIFactory();
			$icon = $f->icon()->custom('./src/UI/examples/Layout/Page/icon-sb-more.svg', '');
			$button = $f->button()
				->bulky($icon->withSize('large'), $component->getToolsLabel(), '#')
				->withOnClick($tools_signal)
				->withEngagedState($tools_active);

			//this is the main button ("Tools ...")
			$tpl->setCurrentBlock("tools_trigger");
			$tpl->setVariable("BUTTON", $default_renderer->render($button));
			$tpl->parseCurrentBlock();

			//this is to remove a tool
			$button = $f->button()
				->close()
				->withOnClick($tools_removal_signal);

			$tpl->setCurrentBlock("tool_removal");
			$tpl->setVariable("REMOVE_TOOL", $default_renderer->render($button));
			$tpl->parseCurrentBlock();

			//tool entries
			$this->renderTriggerButtonsAndSlates(
				$tpl, $default_renderer, $entry_signal,
				'tools_trigger_item',
				$tools,
				$active
			);

			if($tools_active) {
				$tpl->touchBlock('tools_trigger_initially_active');
			}

		}

		//"regular" entries
		$this->renderTriggerButtonsAndSlates(
			$tpl, $default_renderer, $entry_signal,
			'trigger_item',
			$component->getEntries(),
			$active
		);

		$component = $component->withOnLoadCode(
			function($id) use ($entry_signal, $tools_signal, $tools_removal_signal) {
				return "
					$(document).on('{$entry_signal}', function(event, signalData) {
						il.UI.layout.sidebar.onClickEntry(event, signalData, '{$id}');
						return false;
					});
					$(document).on('{$tools_signal}', function(event, signalData) {
						il.UI.layout.sidebar.onClickToolsEntry(event, signalData, '{$id}');
						return false;
					});
					$(document).on('{$tools_removal_signal}', function(event, signalData) {
						il.UI.layout.sidebar.onClickToolsRemoval(event, signalData, '{$id}');
						return false;
					});
				";
			}
		);

		$id = $this->bindJavaScript($component);
		$tpl->setVariable('ID', $id);

		return $tpl->get();
	}

	protected function renderTriggerButtonsAndSlates(
		UITemplateWrapper $tpl,
		RendererInterface $default_renderer,
		Signal $entry_signal,
		string $block,
		array $entries,
		string $active = null
	) {
		foreach ($entries as $index=>$entry) {
			$engaged = (string)$index === $active;
			$slate = $entry->getSlate();
			$button = $entry->getButton();

			if($slate) {
				//if a buttons comes with a slate, its action is to open the slate.
				$button = $button->withOnClick($slate->getToggleSignal());
			}
			$button = $button
				->appendOnClick($entry_signal)
				->withEngagedState($engaged);

			//$tpl->setCurrentBlock("trigger_item");
			$tpl->setCurrentBlock($block);
			$tpl->setVariable("BUTTON", $default_renderer->render($button));
			$tpl->parseCurrentBlock();

			if($slate) {
				$slate = $slate->withActive($engaged) //show?
					->withCloseSignal($entry_signal); //disengage button on close
				$tpl->setCurrentBlock("slate_item");
				$tpl->setVariable("SLATE", $default_renderer->render($slate));
				$tpl->parseCurrentBlock();
			}
		}
	}


	protected function renderMetabar(Component\Layout\Metabar $component, RendererInterface $default_renderer) {
		$f = $this->getUIFactory();
		$tpl = $this->getTemplate("tpl.metabar.html", true, true);

		$tpl->setVariable("LOGO", $default_renderer->render($component->getLogo()));

		foreach ($component->getElements() as $element) {
			$tpl->setCurrentBlock('meta_element');
			$tpl->setVariable("ELEMENT", $default_renderer->render($element));
			$tpl->parseCurrentBlock();
		}
		$logout_glyph = $f->glyph()->logout(ILIAS_HTTP_PATH .'/logout.php');
		$tpl->setVariable("LOGOUT", $default_renderer->render($logout_glyph));
		return $tpl->get();
	}

	protected function renderPage(Component\Layout\Page $component, RendererInterface $default_renderer) {
		$tpl = $this->getTemplate("tpl.page.html", true, true);

		if($metabar = $component->getMetabar()) {
			$tpl->setVariable('METABAR', $default_renderer->render($metabar));
		}
		if($sidebar = $component->getSidebar()) {
			$tpl->setVariable('SIDEBAR', $default_renderer->render($sidebar));
		}
		if($breadcrumbs = $component->getBreadcrumbs()) {
			$tpl->setVariable('BREADCRUMBS', $default_renderer->render($breadcrumbs));
		}

		$tpl->setVariable('CONTENT', $default_renderer->render($component->getContent()));

		if($component->getWithHeaders()) {
			$tpl = $this->setHeaderVars($tpl);
		}
		return $tpl->get();
	}

	/**
	 * When rendering the whole page, all resources must be included.
	 * This is for now and the page-demo to work, lateron this must be replaced
	 * with resources set as properties at the page or similar mechanisms.
	 */
	protected function setHeaderVars($tpl) {

		global $DIC;
		$il_tpl = $DIC["tpl"];

		$base_url = '../../../../../';

		// always load jQuery
		include_once("./Services/jQuery/classes/class.iljQueryUtil.php");
		\iljQueryUtil::initjQuery($il_tpl);
		include_once("./Services/UICore/classes/class.ilUIFramework.php");
		\ilUIFramework::init($il_tpl);

		$il_js_files = $il_tpl->js_files_batch;
		asort($il_js_files);

		$js_files = array();
		foreach($il_js_files as $il_js_file=>$batch) {
			$js_files[] = $il_js_file;
		}

		$css_files = array();
		foreach($il_tpl->css_files as $il_css_file) {
			$css_files[] = $il_css_file['file'];
		}
		$css_files[] = \ilUtil::getStyleSheetLocation("filesystem", "delos.css");
		$css_files[] = \ilUtil::getNewContentStyleSheetLocation();

		$css_inline = $il_tpl->inline_css;

		$olc = '';
		if($il_tpl->on_load_code) {
			foreach ($il_tpl->on_load_code as $key => $value) {
				$olc .= implode(PHP_EOL, $value);
			 }
		}

		 //fill
		foreach ($js_files as $js_file) {
			$tpl->setCurrentBlock("js_file");
			$tpl->setVariable("JS_FILE", $js_file);
			$tpl->parseCurrentBlock();
		}
		foreach ($css_files as $css_file) {
			$tpl->setCurrentBlock("css_file");
			$tpl->setVariable("CSS_FILE", $css_file);
			$tpl->parseCurrentBlock();
		}
		$tpl->setVariable("CSS_INLINE", implode(PHP_EOL, $css_inline));
		$tpl->setVariable("OLCODE", $olc);

		$tpl->setVariable("BASE", $base_url);
		return $tpl;
	}

	/**
	 * @inheritdoc
	 */
	public function registerResources(\ILIAS\UI\Implementation\Render\ResourceRegistry $registry) {
		parent::registerResources($registry);
		$registry->register('./src/UI/templates/js/Layout/Sidebar/sidebar.js');
	}

	/**
	 * @inheritdoc
	 */
	protected function getComponentInterfaceName() {
		return array(
			Component\Layout\Sidebar::class,
			Component\Layout\MetaBar::class,
			Component\Layout\Page::class
		);

	}

}
