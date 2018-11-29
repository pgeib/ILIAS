<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls;

<<<<<<< HEAD
use ILIAS\UI\Component as C;
=======
use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Signal;
use ILIAS\UI\Component\Image\Image;
>>>>>>> f3c273715418ee0afae500b77e4acb53a79d57fb
use ILIAS\UI\Component\JavaScriptBindable;

/**
 * This describes the Metabar.
 */
<<<<<<< HEAD
interface Metabar extends C\Component, JavaScriptBindable {

	/**
	 *  @return 	\ILIAS\UI\Component\Image\Image
	 */
	public function getLogo();
=======
interface Metabar extends Component, JavaScriptBindable
{
	public function getLogo(): Image;
>>>>>>> f3c273715418ee0afae500b77e4acb53a79d57fb

	/**
	 * Append an entry.
	 *
	 * @param string $id
	 * @param Bulky|Slate $entry
	 * @throws InvalidArgumentException 	if $id is already taken
	 */
	public function withEntry(string $id, $entry): Metabar;

	/**
	 * @return array <string, Bulky|Slate>
	 */
	public function getEntries(): array;

	public function getEntryClickSignal(): Signal;
}
