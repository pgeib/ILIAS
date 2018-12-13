<?php
function mainbar()
{
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$mainbar = buildMainbar($f);
	return $renderer->render($mainbar);
}

function buildMainbar($f)
{
	list($entries, $tools) = getSomeEntries($f);

	$mainbar = $f->mainControls()->mainbar();

	foreach ($entries as $id=>$entry) {
		$mainbar = $mainbar->withEntry($id, $entry);
	}
	foreach ($tools as $id=>$entry) {
		$mainbar = $mainbar->withToolEntry($id, $entry);
	}

	return $mainbar;
}

function getSomeEntries($f)
{
	$entries = [];
	$tools = [];

	//add a slate
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-navigation.svg', '')->withSize('medium');
	$symbol2 = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-navigation.svg', '')->withSize('medium');
	$slate = $f->maincontrols()->slate()->legacy('Legacy', $symbol, 'legacy content');
	$entries['example1'] = $slate;

	//a slate with buttons and more slates
	$icon = $f->icon()->standard('', '')->withSize('medium')->withAbbreviation('X');
	$button = $f->button()->bulky($icon, 'Button 1', '#');

	$slate1 = $f->maincontrols()->slate()->legacy('Legacy 1', $symbol, 'legacy content1');
	$slate2 = $f->maincontrols()->slate()->legacy('Legacy 2', $symbol2, 'legacy content 2');
	$slate3_1 = $f->maincontrols()->slate()->legacy('Legacy 3.1', $symbol, 'legacy content 3.1');
	$slate3_2 = $f->maincontrols()->slate()->legacy('Legacy 3.2 - long', $symbol, loremIpsum(9));
	$slate3 = $f->maincontrols()->slate()->combined('Slate with Sub-Slates', $symbol)
		->withEntry($slate3_1)
		->withEntry($slate3_2)
		->withEntry($button->withLabel('Button 3.3'));

	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-cockpit.svg', '')->withSize('medium');
	$slate = $f->maincontrols()->slate()->combined('Combined', $symbol)
		->withEntry($button)
		->withEntry($button->withLabel('Button 2'))
		->withEntry($button->withLabel('Button 3'))
		->withEntry($slate1)
		->withEntry($slate2)
		->withEntry($button->withLabel('Button 4'))
		->withEntry($slate3)
		->withEntry($button->withLabel('Button 5'))
	;
	$entries['example2'] = $slate;

	//add a button
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-more.svg', '')->withSize('medium');
	$entries['extra'] = $f->button()->bulky($symbol,'Extra', '#');

	//add tool(slate)
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-cockpit.svg', '')->withSize('medium');
	$slate = $f->maincontrols()->slate()->legacy('Tool 1', $symbol, 'tool 1');
	$tools['tool1'] = $slate;

	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-navigation.svg', '')->withSize('medium');
	$slate = $f->maincontrols()->slate()->legacy('Tool 2', $symbol, 'tool 2');
	$tools['tool2'] = $slate;

	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/icon-sb-navigation.svg', '')->withSize('medium');
	$slate = $f->maincontrols()->slate()->legacy('Tool 3', $symbol, 'tool 3');
	$tools['tool3'] = $slate;


	return [$entries, $tools];
}

function loremIpsum():string {
	return <<<EOT
	<h2>Lorem ipsum</h2>
	<p>
	Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
	</p>
	<p>
	Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
	</p>
	<p>
	Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
	</p>
	<p>
	Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer
	</p>
EOT;
}
