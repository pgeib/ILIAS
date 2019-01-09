<?php
include_once('z_auxilliary.php');

function ui()
{
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$url = 'src/UI/examples/Layout/Page/Standard/ui.php?new_ui=1';
	$btn = $f->button()->standard('See UI in fullscreen-mode', $url);
	return $renderer->render($btn);
}


if ($_GET['new_ui'] == '1') {
	_initIliasForPreview();
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$logo = $f->image()
		->responsive("src/UI/examples/Image/HeaderIconLarge.svg", "ILIAS");

	$breadcrumbs = demoBreadcrumbs($f);
	$metabar = buildMetabar($f);
	$content = demoContent($f);
	$mainbar = buildDemoMainbar($f, $renderer, $_GET);

	if($_GET['mbactive']) {
		$mainbar = $mainbar->withActive($_GET['mbactive']);
	}

	$page = $f->layout()->page()->standard(
		$metabar,
		$mainbar,
		$content,
		$breadcrumbs,
		$logo
	);

	echo $renderer->render($page);
}

if ($_GET['slate_contents']) {
	_initIliasForPreview();
	$f = $DIC->ui()->factory();
	$r = $DIC->ui()->renderer();

	$slate = buildRPCedSlate($f, $r, $_GET['slate_contents']);

	echo $r->renderAsync($slate);
	exit();
}


function buildDemoMainbar($f, $r, array $get)
{
	$tools_btn = $f->button()->bulky(
		$f->icon()->custom('./src/UI/examples/Layout/Page/Standard/grid.svg', ''),
		'Tools',
		'#'
	);
	$mainbar = $f->mainControls()->mainbar()
		->withToolsButton($tools_btn);

	$entries = [
		'Repository',
		'Personal Workspace',
		'Achievements',
		'Communication',
		'Organisation',
		'Administration'
	];

	$tools = [
		'Help',
		'Editor',
		'Local Navigation'
	];

	foreach ($entries as $id) {
		$slate = getDemoEntry($f, $r, $id);
		$mainbar = $mainbar->withAdditionalEntry($id, $slate);
	}
	foreach ($tools as $id) {
		$slate = getDemoEntry($f, $r, $id);
		$mainbar = $mainbar->withAdditionalToolEntry($id, $slate);
	}
	return $mainbar;
}

function getDemoEntry($f, $r, $which)
{
	$content = '';
	switch ($which){
		case 'Repository':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/layers.svg', '');
			break;
		case 'Personal Workspace':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/user.svg', '');
			break;
		case 'Achievements':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/achievements.svg', '');
			$content = loremIpsum();
			break;
		case 'Communication':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/communication.svg', '');
			$content = loremShort();
			break;
		case 'Organisation':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/organisation.svg', '');
			$content = loremShort();
			break;
		case 'Administration':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/administration.svg', '');
			break;
		case 'Help':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/question.svg', '');
			$content = loremIpsum();
			break;
		case 'Editor':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/pencil.svg', '');
			$content = loremShort();
			break;
		case 'Local Navigation':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/notebook.svg', '');
			break;
	}

	$symbol = $symbol->withSize('small');

	if(! $content) {
		$slate = $f->maincontrols()->slate()->combined($which, $symbol);
		$slate = populateEntries($f, $r, $slate);
	} else {
		$slate = $f->maincontrols()->slate()->legacy($which, $symbol, $content);
	}

	return $slate;
}

function populateEntries($f, $r, $slate)
{
	$entries = [];
	if($slate->getName() === 'Repository') {
		$entries = getRepositoryEntries($f);
	}
	if($slate->getName() === 'Personal Workspace') {
		$entries = getPersonalWorkspaceEntries($f, $r);
	}
	if($slate->getName() === 'Administration') {
		$entries = getAdministrationEntries($f, $r, $slate);
	}

	foreach ($entries as $entry) {
		$slate = $slate->withAdditionalEntry($entry);
	}
	return $slate;

}

function buildRPCedSlate($f, $r, $which)
{
	switch ($which){
		case 'General Settings':
			return getGeneralSettingsSlate($f, $r);

		case 'SomeSettings':
			$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/administration.svg', '')->withSize('small');
			$slate = $f->maincontrols()->slate()->legacy('Some Settings', $symbol, loremShort())
				->withBacklink('General Settings', './src/UI/examples/Layout/Page/Standard/ui.php?slate_contents=General Settings');
			return $slate;

		case 'Layout':
			return getLayoutSlate($f, $r)
				->withBacklink('Administration', './src/UI/examples/Layout/Page/Standard/ui.php?slate_contents=Administration');

		case 'Administration':
			return getDemoEntry($f, $r, 'Administration');
	}
}


function getRepositoryEntries($f)
{
	$icon = $f->icon()->standard('', '')->withSize('small')->withAbbreviation('X');
	$button = $f->button()->bulky($icon, 'button', './src/UI/examples/Layout/Page/Standard/ui.php?new_ui=1&mbactive=Repository');
	return [
		$button->withLabel('Repository - Home'),
		$button->withLabel('Repository - Tree'),
		$button->withLabel('Repository - Last visited'),
		$button->withLabel('Favorites'),
		$button->withLabel('Courses'),
		$button->withLabel('Groups'),
		$button->withLabel('Study Programme'),
		$button->withLabel('Own Repository-Objects')
	];
}

function getPersonalWorkspaceEntries($f, $r)
{
	$icon = $f->icon()->standard('', '')->withSize('small')->withAbbreviation('Y');
	$button = $f->button()->bulky($icon, 'button', './src/UI/examples/Layout/Page/Standard/ui.php?new_ui=1&mbactive=Personal Workspace');
	return [
		$button->withLabel('Overview'),
		getBookmarksSlate($f, $r),
		$button->withLabel('Calendar'),
		$button->withLabel('Tasks'),
		$button->withLabel('Portfolios'),
		$button->withLabel('Personal Resources'),
		$button->withLabel('Shared Resources'),
		$button->withLabel('Notes'),
		$button->withLabel('News'),
		$button->withLabel('Background Tasks')
	];
}

function getBookmarksSlate($f, $r)
{
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/bookmarks.svg', '')->withSize('small');
	$bookmarks = implode('<br />', [
		$r->render($f->button()->shy('my bookmark 1', '#')),
		$r->render($f->button()->shy('my bookmark 2', '#'))
	]);
	$slate = $f->maincontrols()->slate()->legacy('Bookmarks', $symbol, $bookmarks)
		->withEngaged(true);

	return $slate;
}


function getAdministrationEntries($f, $r, $slate)
{
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/administration.svg', '')->withSize('small');

	$general_settings = getGeneralSettingsSlate($f, $r);

	$layout_settings = $f->button()->bulky($symbol, 'Layout and Styles', '')
		->withOnClick(
			$slate->getReplaceContentSignal()
				->withAsyncRenderUrl('./src/UI/examples/Layout/Page/Standard/ui.php?slate_contents=Layout')
		);

	return [
		$general_settings,
		$layout_settings
	];
}


function getGeneralSettingsSlate($f, $r)
{
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/administration.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->combined('General Settings', $symbol);

	$icon = $f->icon()->standard('', '')->withSize('small')->withAbbreviation('S');
	$button =  $f->button()->bulky($icon, '', '')
		->withOnClick(
			$slate->getReplaceContentSignal()
			->withAsyncRenderUrl('./src/UI/examples/Layout/Page/Standard/ui.php?slate_contents=SomeSettings')
		);

	$slate = $slate
		->withAdditionalEntry($button->withLabel('BasicSetting'))
		->withAdditionalEntry($button->withLabel('Server'))
		->withAdditionalEntry($button->withLabel('CronJobs'))
		;

	return $slate;
}


function getLayoutSlate($f, $r)
{
	$icon = $f->icon()->standard('', '')->withSize('small')->withAbbreviation('S');
	$symbol = $f->icon()->custom('./src/UI/examples/Layout/Page/Standard/administration.svg', '')->withSize('small');
	$slate = $f->maincontrols()->slate()->combined('Layout', $symbol)
		->withAdditionalEntry($f->maincontrols()->slate()->legacy('delos', $icon, loremIpsum()))
		->withAdditionalEntry($f->maincontrols()->slate()->legacy('custom', $icon, loremIpsum()))
		->withAdditionalEntry($f->maincontrols()->slate()->legacy('special', $icon, loremIpsum()))
		;

	return $slate;
}
