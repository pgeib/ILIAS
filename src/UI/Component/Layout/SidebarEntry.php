<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Layout;

use \ILIAS\UI\Component as C;

/**
 * This describes the SidebarEntry.
 */
interface SidebarEntry extends C\Component {

	/**
	 * @return 	 Button\Iconographic | Glyph\Glyph
	 */
	public function getButton();

	/**
	 * @return C\MainControls\Menu\Slate | null
	 */
	public function getSlate();



}
