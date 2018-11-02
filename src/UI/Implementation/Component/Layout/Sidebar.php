<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

/**
 * Sidebar
 */
class Sidebar implements C\Layout\Sidebar {
	use ComponentHelper;
	use JavaScriptBindable;

	/**
	 * @var 	SignalGeneratorInterface
	 */
	private $signal_generator;

	/**
	 * @var 	Signal
	 */
	private $entry_click_signal;

	/**
	 * @var 	Signal
	 */
	private $tools_click_signal;

	/**
	 * @var 	Signal
	 */
	private $tools_removal_signal;

	/**
	 * @var 	\ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	private $entries;

	/**
	 * @var 	\ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	private $tools;

	/**
	 * @var 	string
	 */
	private $tools_label;

	/**
	 * @var 	string | null
	 */
	private $active;


	public function __construct (
			SignalGeneratorInterface $signal_generator,
			array $entries
	) {

		$classes = array(\ILIAS\UI\Component\Layout\SidebarEntry::class);
		$this->checkArgListElements('entries', $entries, $classes);
		$this->entries = $entries;
		$this->tools = [];
		$this->tools_label = 'Tools';

		$this->signal_generator = $signal_generator;
		$this->initSignals();
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
	public function getEntryClickSignal(): C\Signal
	{
		return $this->entry_click_signal;
	}

	/**
	 * @inheritdoc
	 */
	public function getToolsClickSignal(): C\Signal
	{
		return $this->tools_click_signal;
	}

	/**
	 * @inheritdoc
	 */
	public function getToolsRemovalSignal(): C\Signal
	{
		return $this->tools_removal_signal;
	}

	/**
	 * Set the signals for this component
	 */
	protected function initSignals()
	{
		$this->entry_click_signal = $this->signal_generator->create();
		$this->tools_click_signal = $this->signal_generator->create();
		$this->tools_removal_signal = $this->signal_generator->create();
	}

	/**
	 * @inheritdoc
	 */
	public function withResetSignals(): C\Layout\Sidebar
	{
		$clone = clone $this;
		$clone->initSignals();
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function withTools(array $tool_entries): C\Layout\Sidebar
	{
		$classes = array(\ILIAS\UI\Component\Layout\SidebarEntry::class);
		$this->checkArgListElements('entries', $tool_entries, $classes);
		//TODO: check for attached slate...
		$clone = clone $this;
		$clone->tools =  $tool_entries;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getTools(): array
	{
		return $this->tools;
	}

	public function withToolsLabel(string $label): C\Layout\Sidebar
	{
		$clone = clone $this;
		$clone->tools_label =  $label;
		return $clone;
	}

	public function getToolsLabel(): string
	{
		return $this->tools_label;
	}


	/**
	 * @inheritdoc
	 */
	public function getActive()
	{
		return $this->active;
	}

	/**
	 * @inheritdoc
	 */
	public function withActive(string $active): C\Layout\Sidebar
	{
		$clone = clone $this;
		$clone->active = $active;
		return $clone;
	}

}
