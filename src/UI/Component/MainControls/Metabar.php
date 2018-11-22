<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls;

use ILIAS\UI\Component as C;
use ILIAS\UI\Component\JavaScriptBindable;

/**
 * This describes the Metabar.
 */
interface Metabar extends C\Component, JavaScriptBindable {

	/**
	 *  @return 	\ILIAS\UI\Component\Image\Image
	 */
	public function getLogo();

	/**
	 * Append an entry.
	 *
	 * @param string $id
	 * @param Clickable|Slate $entry
	 * @throws InvalidArgumentException 	if $id is already taken
	 */
	public function withEntry(string $id, $entry): Metabar;

	/**
	 * @return array <string, Clickable|Slate>
	 */
	public function getEntries(): array;

}