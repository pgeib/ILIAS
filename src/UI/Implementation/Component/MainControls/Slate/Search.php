<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\MainControls\Slate;

use ILIAS\UI\Component\MainControls\Slate as ISlate;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;

/**
 * Search Slate
 */
class Search extends Slate implements ISlate\Search
{
	/**
	 * @var Component[]
	 */
	protected $contents = [];

	/**
	 * @var Factory
	 */
	protected $ui_factory;

	public function __construct(
		SignalGeneratorInterface $signal_generator,
		string $name
	) {
		global $DIC;
		$this->ui_factory = $DIC['ui.factory'];
		$symbol = $this->ui_factory->glyph()->search();

		parent::__construct($signal_generator, $name, $symbol);
		$this->initContents();
	}

	public function initContents()
	{
		//TODO: translate
		$search_input = $this->ui_factory->input()->field()->text("search", "");
		$search_options = $this->ui_factory->input()->field()->radio("where", "")
			->withOption('global', 'Globally')
			->withOption('here', 'At Current Position')
			->withOption('users', 'Search Users')
			;
		$search_form = $this->ui_factory->input()->container()->form()
			->standard("#", [
				$search_input,
				$search_options
			]);

		$this->contents = [
			$search_form
		];
	}

	/**
	 * @inheritdoc
	 */
	public function getContents(): array
	{
		return $this->contents;
	}

}
