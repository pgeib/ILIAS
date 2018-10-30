<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Layout;
use ILIAS\UI\Component\JavaScriptBindable;
use \ILIAS\UI\Component as C;

/**
 * This describes the Sidebar
 */
interface Sidebar extends C\Component, JavaScriptBindable {

	/**
	 * @return 	\ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	public function getEntries(): array;

	/**
	 * @return 	Signal
	 */
	public function getEntryClickSignal();

	/**
	 * @return 	Sidebar
	 */
	public function withResetSignals(): Sidebar;

	/**
	 * @param \ILIAS\UI\Component\Layout\SidebarEntry[] $tool_entries
	 */
	public function withTools(array $tool_entries): Sidebar;

	/**
	 * @return \ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	public function getTools(): array;

}