<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Menu;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Plank
 */
class Plank implements C\MainControls\Menu\Plank {
	use ComponentHelper;

	/**
	 * @var 	Component[]
	 */
	private $contents = array();

	/**
	 * @inheritdoc
	 */
	public function withContents(array $contents) {
		$clone = clone $this;
		$clone->contents = $contents;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getContents() {
		return $this->contents;
	}

}
