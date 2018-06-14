<?php

function vertical() {
	//init Factory and Renderer
	global $DIC;
	$f = $DIC->ui()->factory()->listing()->workflow();
	$renderer = $DIC->ui()->renderer();

	//setup steps
	$step = $f->step('','');
	$steps = [
		$f->step('step1', 'not applicable')->withStatus($step::STATUS_NOTAPPLICABLE),
		$f->step('step2', 'completed')->withStatus($step::STATUS_COMPLETED),
		$f->step('step3', 'not started'),
		$f->step('step4', 'in progress, active')->withStatus($step::STATUS_INPROGRESS),
		$f->step('step5', 'not started')
	];

	//setup linear workflow
	$wf = $f->linear('Linear Workflow', $steps);
	$wf = $wf
		->withActive(3)
		->withOrientation($wf::VERTICAL);

	//render
	return $renderer->render($wf);
}
