<?php

function buildNotification($f)
{
	$mail_glyph = $f->glyph()->mail('#')
		->withCounter($f->counter()->status(3));
	$mails = $f->button()->bulky($mail_glyph, 'Mails', '#');

	$comment_glyph = $f->glyph()->comment('#')
		->withCounter($f->counter()->novelty(1));
	$comments = $f->button()->bulky($comment_glyph, 'Comments', '#');


	$notification = $f->maincontrols()->slate()
		->notification('notification')
		->withPrompt('mails', $mails)
		->withPrompt('comments', $comments)
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
