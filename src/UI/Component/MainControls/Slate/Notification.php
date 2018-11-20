<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls\Slate;

/**
 * This describes the Notification
 */
interface Notification extends Prompt
{
	/**
	 * Adds a prompt to the Notification Slate.
	 *
	 * @param string $id
	 * @param Bulky|Prompt $entry
	 */
	public function withPrompt(string $id, $entry): Notification;
}
