<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls;

use ILIAS\UI\Component\Signal;
use ILIAS\UI\Component\MainControls;
use ILIAS\UI\Component\Image\Image;
use ILIAS\UI\Component\Button\Bulky;
use ILIAS\UI\Component\MainControls\Slate\Slate;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

/**
 * Metabar
 */
class Metabar implements MainControls\Metabar
{
	use ComponentHelper;
	use JavaScriptBindable;

	/**
	 * @var SignalGeneratorInterface
	 */
	private $signal_generator;

	/**
	 * @var Image
	 */
	private $logo;

	/**
	 * @var Signal
	 */
	private $entry_click_signal;

	/**
	 * @var array<string, Bulky|Prompt>
	 */
	protected $entries;

	public function __construct(
		SignalGeneratorInterface $signal_generator,
		Image $logo
	) {
		$this->signal_generator = $signal_generator;
		$this->logo = $logo;
		$this->initSignals();
	}

	/**
	 * @inheritdoc
	 */
	public function getLogo(): Image
	{
		return $this->logo;
	}

	/**
	 * @inheritdoc
	 */
	public function getEntries(): array
	{
		return $this->entries;
	}

	/**
	 * @inheritdoc
	 */
	public function withEntry(string $id, $entry): MainControls\Metabar
	{
		$classes = [Bulky::class, Slate::class];
		$check = [$entry];
		$this->checkArgListElements("Bulky or Slate", $check, $classes);

		$clone = clone $this;
		$clone->entries[$id] = $entry;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getEntryClickSignal(): Signal
	{
		return $this->entry_click_signal;
	}


	/**
	 * Set the signals for this component
	 */
	protected function initSignals()
	{
		$this->entry_click_signal = $this->signal_generator->create();
	}

}