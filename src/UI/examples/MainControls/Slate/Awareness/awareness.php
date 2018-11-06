<?php
function buildAwareness($f) {
	$contents = array(
		$f->legacy('<b>AwarenessTool</b>'),
		$f->divider()->horizontal(),
		$f->legacy('something that wants your attention'),
		$f->divider()->horizontal(),
		$f->legacy('something else that wants your attention')
	);

	return $f->maincontrols()->slate()
		->awareness('awareness', $f->glyph()->user())
		//->withCounter(2) //novelty counter only, thus internalized
		;
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
