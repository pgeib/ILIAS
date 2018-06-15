<?php

function base() {
	//init Factory and Renderer
	global $DIC;
	$f = $DIC->ui()->factory()->listing()->workflow();
	$renderer = $DIC->ui()->renderer();

	//setup steps
	$step = $f->step('','');
	$steps = [
		$f->step('step1', 'completed')->withStatus($step::STATUS_COMPLETED),
		$f->step('step2 has a longish title', 'is completed, but with a heavier description-length.')->withStatus($step::STATUS_COMPLETED),
		$f->step('step3', 'in progress, active')->withStatus($step::STATUS_INPROGRESS),
		$f->step('step4', 'not applicable')->withStatus($step::STATUS_NOTAPPLICABLE),
		$f->step('step5', 'in progress')->withStatus($step::STATUS_INPROGRESS),
		$f->step('step6', 'completed')->withStatus($step::STATUS_COMPLETED),
		$f->step('step7', 'not started'),
		$f->step('step8', 'not applicable')->withStatus($step::STATUS_NOTAPPLICABLE),
		$f->step('step9', 'not started'),
	];

	//setup linear workflow
	$wf = $f->linear('Linear Workflow', $steps)
		->withActive(2);

	//render
	return $renderer->render($wf);
}
