<?php
/* Copyright (c) 1998-2018 ILIAS open source, Extended GPL, see docs/LICENSE */

use ILIAS\UI\Component\Component;
use ILIAS\UI\Factory;

/**
 * Class ilTermsOfServiceNullCriterion
 * @author Michael Jansen <mjansen@databay.de>
 */
class ilTermsOfServiceNullCriterion implements \ilTermsOfServiceCriterionType
{
	/**
	 * @inheritdoc
	 */
	public function getTypeIdent(): string
	{
		return 'null';
	}

	/**
	 * @inheritdoc
	 */
	public function evaluate(\ilObjUser $user, array $config): bool
	{
		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function getGUI(\ilLanguage $lng): \ilTermsOfServiceCriterionTypeGUI
	{
		return new class($lng) implements \ilTermsOfServiceCriterionTypeGUI {
			/** @var \ilLanguage */
			protected $lng;

			/**
			 *  constructor.
			 * @param ilLanguage $lng
			 */
			public function __construct(\ilLanguage $lng)
			{
				$this->lng = $lng;
			}

			/**
			 * @inheritdoc
			 */
			public function appendOption(\ilRadioGroupInputGUI $option, array $config)
			{
			}

			/**
			 * @inheritdoc
			 */
			public function getConfigByForm(\ilPropertyFormGUI $form): array
			{
				return [];
			}

			/**
			 * @inheritdoc
			 */
			public function getIdentPresentation(): string
			{
				return $this->lng->txt('deleted');
			}

			/**
			 * @inheritdoc
			 */
			public function getValuePresentation(array $config, Factory $uiFactory): Component
			{
				return $uiFactory->legacy('-');
			}
		};
	}
}