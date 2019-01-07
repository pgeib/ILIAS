<?php

/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts.and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component;
use ILIAS\UI\Component\MainControls\Slate as ISlate;

class Renderer extends AbstractComponentRenderer
{
	/**
	 * @inheritdoc
	 */
	public function render(Component\Component $component, RendererInterface $default_renderer) {
		$this->checkComponent($component);
		return $this->renderSlate($component, $default_renderer);
	}

	protected function renderSlate(
		ISlate\Slate $component,
		RendererInterface $default_renderer
	) {
		$tpl = $this->getTemplate("Slate/tpl.slate.html", true, true);
		$f = $this->getUIFactory();

		if ($component instanceof ISlate\Combined) {
			$contents = [];
			foreach ($component->getContents() as $entry) {
				if($entry instanceof ISlate\Slate) {
					$triggerer = $f->button()->bulky($entry->getSymbol(), $entry->getName(), '#')
						->withOnClick($entry->getToggleSignal());
					$contents[] = $triggerer;
				}
				$contents[] = $entry;
			}
		} else {
			$contents = $component->getContents();
		}

		list($bl_label, $bl_url) = $component->getBacklink();
		if($bl_url && $bl_label) {
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/arrow_left.svg', '')->withSize('small');
			$backlink = $f->button()->bulky($symbol, $bl_label, $bl_url);
			$tpl->setVariable('BACKLINK', $default_renderer->render($backlink));
		}
		$tpl->setVariable('CONTENTS', $default_renderer->render($contents));

		if($component->getEngaged()) {
			$tpl->touchBlock('engaged');
		}else {
			$tpl->touchBlock('disengaged');
		}

		$toggle_signal = $component->getToggleSignal();
		$show_signal = $component->getShowSignal();
		$replace_content_signal = $component->getReplaceContentSignal();

		$component = $component->withOnLoadCode(function($id) use ($toggle_signal, $show_signal, $replace_content_signal) {
			return "
				$(document).on('{$toggle_signal}', function(event, signalData) {
					il.UI.maincontrols.slate.onToggleSignal(event, signalData, '{$id}');
					return false;
				});
				$(document).on('{$show_signal}', function(event, signalData) {
					il.UI.maincontrols.slate.onShowSignal(event, signalData, '{$id}');
					return false;
				});
				$(document).on('{$replace_content_signal}', function(event, signalData) {
					il.UI.maincontrols.slate.onReplaceContentSignal(event, signalData, '{$id}');
					return false;
				});

			";
		});
		$id = $this->bindJavaScript($component);
		$tpl->setVariable('ID', $id);

		return $tpl->get();
	}

	/**
	 * @inheritdoc
	 */
	public function registerResources(\ILIAS\UI\Implementation\Render\ResourceRegistry $registry) {
		parent::registerResources($registry);
		$registry->register('./src/UI/templates/js/MainControls/slate.js');
	}

	/**
	 * @inheritdoc
	 */
	protected function getComponentInterfaceName() {
		return array(
			ISlate\Legacy::class,
			ISlate\Combined::class,
			ISlate\Search::class,
			ISlate\Awareness::class,
			ISlate\Notification::class
		);

	}

}
