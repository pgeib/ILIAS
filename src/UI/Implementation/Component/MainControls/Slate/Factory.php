<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

class Factory implements ISlate\Factory
{
	/**
	 * @var SignalGeneratorInterface
	 */
	protected $signal_generator;

	public function __construct(SignalGeneratorInterface $signal_generator)
	{
		$this->signal_generator = $signal_generator;
	}

	public function legacy(string $name, $symbol, string $contents): ISlate\Legacy
	{
		return new Legacy($this->signal_generator, $name, $symbol, $contents);
	}

	public function search(string $name, $symbol): ISlate\Search
	{
		return new Search($this->signal_generator, $name, $symbol);
	}

	public function combined(string $name, $symbol): ISlate\Combined
	{
		return new Combined($this->signal_generator, $name, $symbol);
	}

	public function notification(string $name, $symbol): ISlate\Notification
	{
		return new Notification($this->signal_generator, $name, $symbol);
	}

	public function awareness(string $name, $symbol): ISlate\Awareness
	{
		return new Awareness($this->signal_generator, $name, $symbol);
	}
}
