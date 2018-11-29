<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;


/**
 * Awareness
 */

class Awareness extends Prompt implements ISlate\Awareness
{
	/**
	 * @var ILIAS\UI\Component[]
	 */
	private $contents = array();

	/**
	 * @var int
	 */
	private $count;


	public function __construct(
		SignalGeneratorInterface $signal_generator,
		string $name
	) {
		global $DIC;
		$ui_factory = $DIC['ui.factory'];
		$symbol = $ui_factory->glyph()->user();

		parent::__construct($signal_generator, $name, $symbol);

	}

	/**
	 * @inheritdoc
	 */
	public function getContents(): array
	{
		return $this->contents;
	}

	/**
	 * @inheritdoc
	 */
	public function withContents(array $contents): ISlate\Awareness
	{
		$clone = clone $this;
		$clone->contents = $contents;
		return $clone;
	}

}
