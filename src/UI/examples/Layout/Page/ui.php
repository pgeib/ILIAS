<?php
include_once('z_auxilliary.php');

function ui() {
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$url = 'src/UI/examples/Layout/Page/ui.php?new_ui=1';
	$btn = $f->button()->standard('See UI in fullscreen-mode', $url);
	return $renderer->render($btn);
}

if ($_GET['new_ui'] == '1') {
	_initIliasForPreview();
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	if($_GET['rpc']) {
		handleRPC($f, $renderer);
	}

	$content = array (
		$f->panel()->standard('Demo Content',
			$f->legacy("some content<br>some content<br>some content<br>x.")),
		$f->panel()->standard('Demo Content 2',
			$f->legacy("some content<br>some content<br>some content<br>x.")),
		$f->panel()->standard('Demo Content 3',
			$f->legacy("some content<br>some content<br>some content<br>x.")),
		$f->panel()->standard('Demo Content 4',
			$f->legacy("some content<br>some content<br>some content<br>x."))
	);

	$crumbs = array (
		$f->link()->standard("entry1", '#'),
		$f->link()->standard("entry2", '#'),
		$f->link()->standard("entry3", '#'),
		$f->link()->standard("entry4", '#')
	);
	$breadcrumbs = $f->breadcrumbs($crumbs);

	$metabar = buildMetabar($f);
	$sidebar = pagedemoSidebar($f)
		->withActive("2");

	$page = $f->layout()->page($content)
		->withMetabar($metabar)
		->withSidebar($sidebar)
		->withBreadCrumbs($breadcrumbs);

	echo $renderer->render($page);
}
