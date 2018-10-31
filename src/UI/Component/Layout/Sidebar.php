<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Layout;

use ILIAS\UI\Component\JavaScriptBindable;
use \ILIAS\UI\Component as C;

/**
 * This describes the Sidebar
 */
interface Sidebar extends C\Component, JavaScriptBindable
{

	/**
	 * @return 	\ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	public function getEntries(): array;

	public function getEntryClickSignal(): C\Signal;

	public function withResetSignals(): Sidebar;

	/**
	 * @param array $tool_entries 	<entry_id => \ILIAS\UI\Component\Layout\SidebarEntry>
	 */
	public function withTools(array $tool_entries): Sidebar;

	/**
	 * @return \ILIAS\UI\Component\Layout\SidebarEntry[]
	 */
	public function getTools(): array;

	/**
	 * @param mixed $active depending on the configuration of entries, this can be be string or int; use string!
	 * @throws InvalidArgumentException 	if $active is not an element-identifier in entries
	 */
	public function withActive(string $active): Sidebar;

	/**
	 * @return string|null
	 */
	public function getActive();

}
