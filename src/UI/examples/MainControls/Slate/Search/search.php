<?php
function search()
{
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$icon = $f->glyph()->search();
	$slate = $f->maincontrols()->slate()->search('search', $icon);

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
