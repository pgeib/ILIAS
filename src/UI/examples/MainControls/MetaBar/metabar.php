<?php
function metabar()
{
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	return $renderer->render(buildMetabar($f));
}

function buildMetabar($f)
{

	require_once('src/UI/examples/MainControls/Slate/Notification/notification.php');
	require_once('src/UI/examples/MainControls/Slate/Awareness/awareness.php');


	$search = $f->maincontrols()->slate()
		->search('search', $f->glyph()->search());

	$help = $f->button()->bulky($f->glyph()->help(),'Help', '#');

	$notifications = buildNotification($f)
		->withUpdatedStatusCounter(42)
		->withUpdatedNoveltyCounter(3);

	$awareness = buildAwareness($f);

	$metabar = $f->mainControls()->metabar()
		->withAdditionalEntry('search', $search)
		->withAdditionalEntry('help', $help)
		->withAdditionalEntry('notifications', $notifications)
		->withAdditionalEntry('awareness', $awareness)
		;

	return $metabar;
}
