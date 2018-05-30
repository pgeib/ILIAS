<?php

function base() {
	//Init Factory and Renderer
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

	$wf = $f->linear('Linear Workflow', $steps);

	//Render
	return $renderer->render($wf);
}
