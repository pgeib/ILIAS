<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

/**
 * SideBar
 */
class SidebarEntry implements C\Layout\SidebarEntry {
	use ComponentHelper;
	//use JavaScriptBindable;

	/**
	 * @var Button\Iconographic | Glyph\Glyph
	 */
	private $button;

	/**
	 * @var bool
	 */
	private $active;

	/**
	 * @var ILIAS\UI\Component\MainControls\Menu\Slate
	 */
	private $slate;


	public function __construct(
		$button,
		bool $active = false,
		C\MainControls\Menu\Slate $slate=null
	) {
		$this->button = $button;
		$this->slate = $slate;
		$this->active = $active;
	}

	/**
	 * @inheritdoc
	 */
	public function getButton()
	{
		return $this->button;
	}

	/**
	 * @inheritdoc
	 */
	public function getSlate()
	{
		return $this->slate;
	}

	/**
	 * @inheritdoc
	 */
	public function getActive(): bool
	{
		return $this->active;
	}

	public function withActive(bool $active): C\Layout\SidebarEntry
	{
		$clone = clone $this;
		$clone->active = $active;
		return $clone;
	}

}
