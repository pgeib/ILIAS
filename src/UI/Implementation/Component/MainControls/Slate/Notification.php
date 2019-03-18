<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Component\Button\Bulky;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;


/**
 * Notification
 */
class Notification extends Prompt implements ISlate\Notification
{
	use ComponentHelper;

	/**
	 * @var array <string, Bulky|Prompt>
	 */
	protected $entries = [];


	public function __construct(
		SignalGeneratorInterface $signal_generator,
		string $name
	) {
		global $DIC;
		$ui_factory = $DIC['ui.factory'];
		$symbol = $ui_factory->glyph()->notification();

		parent::__construct($signal_generator, $name, $symbol);

	}

	/**
	 * @inheritdoc
	 */
	public function withPrompt(string $id, $entry): ISlate\Notification
	{
		$classes = [Bulky::class, IPrompt\Prompt::class];
		$check = [$entry];
		$this->checkArgListElements("Bulky-Button or Prompt", $check, $classes);
		$this->checkEntryId($id, false);

		$clone = clone $this;
		$clone->entries[$id] = $entry;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getContents(): array
	{
		return array_values($this->entries);
	}


	protected function checkEntryId(string $id, bool $should_exist)
	{
		$exist = array_key_exists($id, $this->entries);
		if($should_exist !== $exist) {
			if($should_exist) {
				$msg = "The id '$id' does not exist in entries.";
			} else {
				$msg = "The id '$id' already exists in entries.";
			}
			throw new \InvalidArgumentException($msg);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function withUpdatedNoveltyCounterFor(string $id, int $count): ISlate\Notification
	{
		$this->checkEntryId($id, true);
		$entry = $this->entries[$id];
		if($entry instanceof Glyph) {
			$f = $this->getUIFactory();
			$entry = $entry->withCounter($f->counter()->novelty($count));
		}
		if($entry instanceof Prompt) {
			$entry = $entry->withUpdatedNoveltyCounter($count);
		}
		return $this->updateEntry($id, $entry);
	}

	/**
	 * @inheritdoc
	 */
	public function withUpdatedStatusCounterFor(string $id, int $count): ISlate\Notification
	{
		$this->checkEntryId($id, true);
		$entry = $this->entries[$id];
		if($entry instanceof Glyph) {
			$f = $this->getUIFactory();
			$entry = $entry->withCounter($f->counter()->status($count));
		}
		if($entry instanceof Prompt) {
			$entry = $entry->withUpdatedStatusCounter($count);
		}
		return $this->updateEntry($id, $entry);
	}


	protected function updateEntry(string $id, $entry): ISlate\Notification
	{
		$clone = clone $this;
		$clone->entries[$id] = $entry;
		return $clone;
	}

}