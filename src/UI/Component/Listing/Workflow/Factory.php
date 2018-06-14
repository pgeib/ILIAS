<?php
namespace ILIAS\UI\Component\Listing\Workflow;
/**
 * This is the interface for a workflow factory.
 */
interface Factory {

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *      A workflow step represents a single step in a sequence of steps.
	 *      A step may be applicable or not and has a state that either is
	 *      completed, in progress or not started.
	 *   composition: >
	 *     A workflow step consists of a label, a description and a marker
	 *     that indicates if the step has already been completed, is in progress
	 *     or has not been started.
	 *
	 * ----
	 *
	 * @param string 	$label
	 * @param string 	$description
	 * @return  \ILIAS\UI\Component\Listing\Workflow\Step
	 */
	public function step($label, $description='');

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *      A linear workflow is the basic form of a workflow: the user
	 *      should tackle every step, one after the other.
	 *   composition: >
	 *     A linear workflow has a title and lists a sequence of steps.
	 *     If the user is currently working on a step, the step is marked as active.
	 *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\Listing\Workflow\Linear
	 */
	public function linear($title, array $steps);
}