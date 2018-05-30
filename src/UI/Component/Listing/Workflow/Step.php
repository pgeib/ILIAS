<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Listing\Workflow;

/**
 * This describes a Workflow Step
 */
interface Step extends \ILIAS\UI\Component\Component {

	const STATUS_NOTAPPLICABLE	= 1;
	const STATUS_NOTSTARTED		= 2;
	const STATUS_INPROGRESS		= 3;
	const STATUS_COMPLETED		= 4;

	/**
	 * Get the label of this step.
	 *
	 * @return 	string
	 */
	public function getLabel();

	/**
	 * Get the description of this step.
	 *
	 * @return 	string
	 */
	public function getDescription();

	/**
	 * Get the status of this step.
	 *
	 * @return 	int
	 */
	public function getStatus();

	/**
	 * Get a step like this with completion status according to parameter.
	 *
	 * @param 	int 	$status
	 * @return 	Step
	 */
	public function withStatus($status);

}