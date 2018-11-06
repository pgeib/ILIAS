<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

/**
 * Combined Slate
 */
class Combined extends Slate implements ISlate\Combined
{
	/**
	 * @var Slate[]
	 */
	protected $contents = [];


	public function __construct(
		SignalGeneratorInterface $signal_generator,
		string $name,
		$symbol
	) {
		parent::__construct($signal_generator, $name, $symbol);
	}

	public function withSlate(ISlate\Slate $slate): ISlate\Combined
	{
		$clone = clone $this;
		$clone->contents[] = $slate;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getContents(): array
	{
		return $this->contents;
	}

}
