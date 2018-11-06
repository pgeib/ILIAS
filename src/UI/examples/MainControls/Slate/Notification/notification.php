<?php

function buildNotification($f)
{
	$mails = $f->glyph()->mail('#')
		->withCounter($f->counter()->status(3));

	$notification = $f->maincontrols()->slate()
		->notification('notification', $f->glyph()->notification())
		->withPrompt('mails', $mails)
		;

	return $notification;
}

function notification() {
	global $DIC;
	$f = $DIC->ui()->factory();
	$renderer = $DIC->ui()->renderer();

	$notification = buildNotification($f)
		->withUpdatedNoveltyCounterFor('mails', 1)
		->withUpdatedStatusCounter(4);


	$triggerer = $f->button()->bulky(
		$notification->getSymbol(),
		$notification->getName()
		, '#'
	)
	->withOnClick($notification->getToggleSignal());

	return $renderer->render([
		$triggerer,
		$notification
	]);

}
