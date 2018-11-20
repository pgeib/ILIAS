<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls\Slate;

/**
 * This describes the Awareness-Tool
 */
interface Awareness extends Prompt
{
	/**
	 * Sets the contents of the Awareness Slate.
	 *
	 * @param Component[] $contents
	 */
	public function withContents(array $contents): Awareness;

}
