<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Metabar
 */
class Metabar implements C\Layout\Metabar {
	use ComponentHelper;

	/**
	 * @var 	ILIAS\UI\Component\Image\Image
	 */
	private $logo;

	/**
	 * @var 	mixed[]
	 */
	private $elements = array();


	public function __construct(C\Image\Image $logo) {
		$this->logo = $logo;
	}

	/**
	 * @inheritdoc
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * @inheritdoc
	 */
	public function withElement($element) {
		$clone = clone $this;
		$clone->elements[] = $element;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getElements() {
		return $this->elements;
	}

}
