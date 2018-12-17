<?php
function buildAwareness($f) {
	$contents = array(
		$f->legacy('<h3>AwarenessTool</h3>'),
		$f->divider()->horizontal(),
		$f->legacy('<p>something that wants your attention</p>'),
		$f->divider()->horizontal(),
		$f->legacy('<p>something else that wants your attention</p>')
	);

	return $f->maincontrols()->slate()
		->awareness('awareness')
		->withContents($contents)
		->withUpdatedStatusCounter(3);
}

function awareness() {
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$awareness = buildAwareness($f);


	$triggerer = $f->button()->bulky(
		$awareness->getSymbol(),
		$awareness->getName()
		, '#'
	)
	->withOnClick($awareness->getToggleSignal());

	return $renderer->render([
		$triggerer,
		$awareness
	]);
}
