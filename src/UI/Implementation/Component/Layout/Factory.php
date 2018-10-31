<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Component\Layout as Layout;
use \ILIAS\UI\Component\MainControls as MainControls;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

class Factory implements Layout\Factory {
	/**
	 * @var SignalGeneratorInterface
	 */
	protected $signal_generator;

	/**
	 * @param SignalGeneratorInterface $signal_generator
	 */
	public function __construct(SignalGeneratorInterface $signal_generator) {
		$this->signal_generator = $signal_generator;
	}

	/**
	 * @inheritdoc
	 */
	public function metabar(\ILIAS\UI\Component\Image\Image $logo){
		return new Metabar($logo);
	}

	/**
	 * @inheritdoc
	 */
	public function sidebar(array $entries){
		return new Sidebar($this->signal_generator, $entries);
	}

	/**
	 * @inheritdoc
	 */
	public function sidebarEntry(
		\ILIAS\UI\Component\Button\Iconographic $button,
		MainControls\Menu\Slate $slate=null
	) {
		return new SidebarEntry($button, $slate);
	}

	/**
	 * @inheritdoc
	 */
	public function page($content){
		return new Page($content);
	}
}
