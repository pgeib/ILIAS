<?php
/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Listing\Workflow;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Class Workflow
 * @package ILIAS\UI\Implementation\Component\Listing\Workflow
 */
class Workflow implements C\Listing\Workflow\Workflow {
	use ComponentHelper;

	/**
	 * @var	array
	 */
	private  $steps;


	/**
	 * Linear Workflow constructor.
	 * @param $steps
	 */
	public function __construct($steps) {
		$types = array('string',C\Component::class);
		$this->checkArgListElements("steps", $steps, $types);
		$this->steps = $steps;
	}
}