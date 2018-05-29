<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Listing\Workflow;

/**
 * This describes a Linear Workflow.
 */
interface Linear extends \ILIAS\UI\Component\Component {

	/**
	 * Get a workflow like this with title $title.
	 *
	 * @param 	string 	$title
	 * @return 	Step
	 */
	public function withTitle($title);

	/**
	 * Get the title of this workflow.
	 *
	 * @return 	string
	 */
	public function getTitle();
}