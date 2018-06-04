<?php

function base() {
	//init Factory and Renderer
	global $DIC;
	$f = $DIC->ui()->factory()->listing()->workflow();
	$renderer = $DIC->ui()->renderer();

	//setup steps
	$steps = [
		$f->step('step1', 'description'),
		$f->step('step2', 'description'),
		$f->step('step3', 'description'),
		$f->step('step4', 'description'),
		$f->step('step5', 'description')
	];

	//setup linear workflow
	$wf = $f->linear('Linear Workflow', $steps)
		->withActive(2);

	//render
	return $renderer->render($wf);
}
