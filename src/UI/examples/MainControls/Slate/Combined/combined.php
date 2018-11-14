<?php

function combined() {
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$icon = $f->glyph()->comment();
	$contents = "some contents.";
	$slate1 = $f->maincontrols()->slate()->legacy('legacy1', $icon, $contents);
	$slate2 = $f->maincontrols()->slate()->legacy('legacy2', $icon, $contents);

	$slate = $f->maincontrols()->slate()
		->combined('combined_example', $f->glyph()->briefcase())
		->withSlate($slate1)
		->withSlate($slate2);


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