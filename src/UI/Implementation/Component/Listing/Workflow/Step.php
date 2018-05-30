<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Listing\Workflow;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Class Step
 * @package ILIAS\UI\Implementation\Component\Listing\Workflow
 */
class Step implements C\Listing\Workflow\Step {

	use ComponentHelper;

	/**
	 * @var	string
	 */
	private  $label;

	/**
	 * @var	string
	 */
	private  $description;

	/**
	 * @var	int
	 */
	private  $status;

	/**
	 * @var	bool
	 */
	private  $active;

	/**
	 * @param string 	$label
	 * @param string 	$description
	 */
	public function __construct($label, $description='') {
		$this->checkStringArg("string", $label);
		$this->checkStringArg("string", $description);
		$this->label = $label;
		$this->description = $description;
		$this->status = static::STATUS_NOTSTARTED;
		$this->active = false;
	}

	/**
	 * @inheritdoc
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @inheritdoc
	 */
	public function getDescription() {
		return $this->description;

	}

	/**
	 * @inheritdoc
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @inheritdoc
	 */
	public function withStatus($status) {

	}
}