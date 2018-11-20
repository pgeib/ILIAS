<?php

namespace ILIAS\UI\Component\MainControls\Slate;

/**
 * This is what a factory for slates looks like.
 */
interface Factory
{
	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Legacy Slate is used to wrap content into a slate when there is
	 *     no other possibility (yet).
	 *     In general, this should not be used and may vanish with the
	 *     progress of specific slates.
	 *
	 *   composition: >
	 *     The Legacy Slate will take any HTML-string and render it.
	 *
	 * rules:
	 *   usage:
	 *     1: >
	 *       This component MUST only be used to ensure backwards compatibility
	 *       with existing UI elements in ILIAS. It SHOULD only contain Elements
	 *       which cannot be generated using other UI Components.
	 *
	 * ----
	 *
	 * @param string $name
	 * @param \ILIAS\UI\Component\Icon\Icon | \ILIAS\UI\Component\Glyph\Glyph $symbol
	 * @param string $contents
	 * @return \ILIAS\UI\Component\MainControls\Slate\Legacy
	 */
	public function legacy(string $name, $symbol, string $contents): Legacy;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Search Slate offers the user a quick way to access the main
	 *     search functions/options.
	 *
	 *   composition: >
	 *     The Search Slate consists of a Text Input with a Submit Button.
	 *     It also features an Option Input to limit the search to
	 *     globally, current positions or users.
	 *
	 *   effect: >
	 *      When the Search Slate is used (the form is submitted),
	 *      the search results are displayed below the search form.
	 *
	 * context:
     *     - The Search Slate is used in the Metabar.
	 *
	 * rules:
	 *   usage:
	 *     1: There MUST be only one Search Slate per page.
	 *   style:
	 *     1: The symbol for this slate MUST be the Search Glyph
	 *
	 * ----
	 *
	 * @param string $name
	 * @return \ILIAS\UI\Component\MainControls\Slate\Search
	 */
	public function search(string $name): Search;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Combined Slate bundles related controls; these can also be further
	 *     Slates.
	 *     Combined Slates are used when a specific purpose is being subdivided
	 *     into further aspects.
	 *
	 *   composition: >
	 *     The Combined Slate consists of more Slates and/or Bulky Buttons.
	 *     The symbol and name of contained Slates are turned into a Bulky Button
	 *     to control opening and closing the contained Slate.
	 *
	 *   effect: >
	 *      Opening a Combined Slate will display its contained Slates with an
	 *      operating Bulky Button for closing/expanding.
	 *      Clicking on a Button not connected to a Slate will carry out its action.
 	 *
	 * ----
	 *
	 * @param string $name
	 * @param \ILIAS\UI\Component\Icon\Icon | \ILIAS\UI\Component\Glyph\Glyph $symbol
	 * @return \ILIAS\UI\Component\MainControls\Slate\Combined
	 */
	public function combined(string $name, $symbol): Combined;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Notification Slate is a Prompt that concentrates all
	 *     system notifications into one expandable glyph.
	 *     It sums up the counters of contained Prompts and Bulky Buttons' Glyphs.
	 *
	 *   composition: >
	 *      The Notification Slate's symbol (=glyph) has a counter;
	 *      its value is the sum of all contained counter-values.
	 *      The expanded Notification Slate will list contained Elements
	 *      with their respective symbols, counters and names.
	 *
	 *   effect: >
	 *      Opening the Notification Slate will display a list of contained
	 *      Prompts and Glyphs. Those, again, can be clicked and will
	 *      then expand (Prompts) or carry out the configured action (Glyphs).
 	 *
	 * context:
     *     - The Notification is used in the Metabar only.
	 *
	 * rules:
	 *   usage:
	 *     1: The Notification MUST be unique for the page.
	 *     2: The Notification MUST be in the Metabar.
	 *   style:
	 *     1: The symbol for this slate MUST be the Notification Glyph
	 *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Slate\Notification
	 */
	public function notification(string $name): Notification;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Awareness Slate provides collaborative features and possibilities
	 *     to contact other users.
	 *
	 *   composition: >
	 *      The Awareness Slate features (Public User Slates) and a Text Input to
	 *      filter the entries.
	 *      As the Awareness Slate is a Prompt, its Glyph will bear a counter
	 *      indicating the number of users currently online.
	 *
	 *   effect: >
	 *      When expanded, the list of (Public User Slates) is shown under the
	 *      filter input. By typing into the filter input, the list of (User Slates)
	 *      is filtered for users, whose login matches the typed string.
	 *
	 * context:
     *     - The Awareness Slate is used in the Metabar only.
	 *
	 * rules:
	 *   usage:
	 *     1: There MUST be but one Awareness Slate on the page.
	 *     2: The Awareness Slate MUST be in the Metabar.
	 *   style:
	 *     1: The Slate's Symbol MUST be the User Glyph.
	 *
	 *---
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Slate\Awareness
	 */
	public function awareness(string $name): Awareness;

}
