<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Awareness
 */

class Awareness extends Prompt implements ISlate\Awareness
{
	use ComponentHelper;

	/**
	 * @var ILIAS\UI\Component[]
	 */
	private $contents = array();
	/**
	 * @var int
	 */
	private $count;


	/**
	 * @inheritdoc
	 */
	public function getContents(): array
	{
		return [];
	}

	/**
	 * @inheritdoc
	 */
	public function withContents($contents) {
		$clone = clone $this;
		$clone->contents = $contents;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getCounter() {
		return $this->count;
	}

	/**
	 * @inheritdoc
	 */
	public function withCounter($count) {
		$clone = clone $this;
		$clone->count = $count;
		return $clone;
	}


}
