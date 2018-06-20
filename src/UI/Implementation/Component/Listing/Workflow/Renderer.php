<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Listing\Workflow;

use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component;

/**
 * Class Renderer
 * @package ILIAS\UI\Implementation\Component\Listing\Workflow
 */
class Renderer extends AbstractComponentRenderer {
	/**
	 * @inheritdocs
	 */
	public function render(Component\Component $component, RendererInterface $default_renderer) {
		$this->checkComponent($component);

		if ($component instanceof Component\Listing\Workflow\Linear) {
			return $this->render_linear($component, $default_renderer);
		}
	}

	/**
	 * @param Component\Listing\Linear $component
	 * @param RendererInterface $default_renderer
	 * @return string
	 */
	protected function render_linear(Component\Listing\Workflow\Linear $component, RendererInterface $default_renderer)
	{
		$tpl = $this->getTemplate("tpl.linear.html", true, true);
		$tpl->setVariable("TITLE", $component->getTitle());

		foreach ($component->getSteps() as $index=>$step) {
			$tpl->setCurrentBlock("step");
			$tpl->setVariable("LABEL", $step->getLabel());
			$tpl->setVariable("DESCRIPTION", $step->getDescription());

			if($index === 0) {
				$tpl->touchBlock('first');
				$tpl->setCurrentBlock("step");
			}
			if($index === $component->getAmountOfSteps() - 1) {
				$tpl->touchBlock('last');
				$tpl->setCurrentBlock("step");
			}

			if($index === $component->getActive()) {
				$tpl->touchBlock('active');
			} else {

				switch ($step->getAvailability()) {
					case Component\Listing\Workflow\Step::AVAILABLE:
						$tpl->touchBlock('available');
						break;
					case Component\Listing\Workflow\Step::NOT_YET:
						$tpl->touchBlock('not_yet');
						break;
					case Component\Listing\Workflow\Step::NOT_ANYMORE:
						$tpl->touchBlock('not_anymore');
						break;
				}
			}
			$tpl->setCurrentBlock("step");

			switch ($step->getStatus()) {
				case Component\Listing\Workflow\Step::NOT_STARTED:
					$tpl->touchBlock('status_notstarted');
					break;
				case Component\Listing\Workflow\Step::IN_PROGRESS:
					$tpl->touchBlock('status_inprogress');
					break;
				case Component\Listing\Workflow\Step::SUCCESSFULLY:
					$tpl->touchBlock('status_completed_successfully');
					break;
				case Component\Listing\Workflow\Step::UNSUCCESSFULLY:
					$tpl->touchBlock('status_completed_unsuccessfully');
					break;
			}
			$tpl->setCurrentBlock("step");
			$tpl->parseCurrentBlock();
		}
		return $tpl->get();
	}



	/**
	 * @inheritdocs
	 */
	protected function getComponentInterfaceName() {
		return [
			Component\Listing\Workflow\Workflow::class
			//, Component\Listing\Workflow\Step::class
		];
	}
}