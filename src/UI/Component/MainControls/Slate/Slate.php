<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls\Slate;

use ILIAS\UI\Component\JavaScriptBindable;
use ILIAS\UI\Component\Signal;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Icon\Icon;
use ILIAS\UI\Component\Glyph\Glyph;


/**
 * This describes a Slate
 */
interface Slate extends Component, JavaScriptBindable
{

	public function getName(): string;

	/**
	 * @return Icon|Glyph
	 */
	public function getSymbol();

	/**
	 * Signal, that toggles the slate when triggered.
	 */
	public function getToggleSignal(): Signal;

	/**
	 * Signal, that is triggered when the slate is being closed
	 */
	public function getOnShowSignal(): Signal;

	/**
	 * Signal, that is triggered when the slate is being closed
	 */
	public function getOnCloseSignal(): Signal;

	/**
	 * @return Component[]
	 */
	public function getContents();

}
