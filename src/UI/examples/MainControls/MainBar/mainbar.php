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
		$mainbar = $mainbar->withAdditionalEntry($id, $entry);
	}
	foreach ($tools as $id=>$entry) {
		$mainbar = $mainbar->withAdditionalToolEntry($id, $entry);
	}

	return $mainbar;
}

function getSomeEntries($f)
{
	$entries = [];
	$tools = [];

	//add a slate
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/layers.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->legacy('Repository', $symbol, loremIpsum());
	$entries['example1'] = $slate;

	//a slate with buttons and more slates
	$icon = $f->icon()->standard('', '')->withSize('small')->withAbbreviation('X');
	$button = $f->button()->bulky($icon, 'Button 1', '#');
	$slate1 = $f->maincontrols()->slate()->legacy('Short Legacy', $symbol, '<h2>legacy content</h2>');
	$slate2 = $f->maincontrols()->slate()->legacy('Long Legacy', $symbol, loremIpsum());
	$slate3_1 = $f->maincontrols()->slate()->legacy('Legacy 3.1', $symbol, 'legacy content 3.1');
	$slate3_2 = $f->maincontrols()->slate()->legacy('Legacy 3.2 - long', $symbol, loremIpsum(9));
	$slate3 = $f->maincontrols()->slate()->combined('Slate with Sub-Slates', $symbol)
		->withAdditionalEntry($slate3_1)
		->withAdditionalEntry($slate3_2)
		->withAdditionalEntry($button->withLabel('Button 3.3'));
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/user.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->combined('Personal Desktop', $symbol)
		->withAdditionalEntry($button)
		->withAdditionalEntry($button->withLabel('Button 2'))
		->withAdditionalEntry($button->withLabel('Button 3'))
		->withAdditionalEntry($slate1)
		->withAdditionalEntry($slate2)
		->withAdditionalEntry($button->withLabel('Button 4'))
		->withAdditionalEntry($slate3)
		->withAdditionalEntry($button->withLabel('Button 5'))
	;
	$entries['example2'] = $slate;

	//add a button
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/options.svg', '')->withSize('small');
	$entries['extra'] = $f->button()->bulky($symbol,'More', '#');
	//add tool(slate)
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/question.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->legacy('Tool 1', $symbol, '<h2>tool 1</h2><p>Some Text for Tool 1 entry</p>');
	$tools['tool1'] = $slate;
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/pencil.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->legacy('Tool 2', $symbol, '<h2>tool 2</h2><p>Some Text for Tool 1 entry</p>');
	$tools['tool2'] = $slate;
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/notebook.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->legacy('Tool 3', $symbol, loremIpsum());
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
