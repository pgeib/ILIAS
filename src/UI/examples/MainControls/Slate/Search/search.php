<?php
function search()
{
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$slate = $f->maincontrols()->slate()->search('search');

	$triggerer = $f->button()->bulky(
		$slate->getSymbol(),
		$slate->getName()
		, '#'
	)
	->withOnClick($slate->getToggleSignal());

	return $renderer->render([
		$triggerer,
		$slate
	]);
}
