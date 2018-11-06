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
	 *     The Legacy Slate used to wrap content into a slate where there is
	 *     no other possibility (yet).
	 *     In general, this should not be used and may vanish with the
	 *     progress of specific slates.
	 *
	 *   composition: >
	 *     The Legacy Slate will take any HTML-string and render it.
	 *
	 * rules:
	 *   usage:
	 *     1: Legacy Slates SHOULD NOT be used at all.
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
	 *     1: TODO
	 *   style:
	 *     1: The symbol for this slate MUST be the Search Glyph
	 *
	 * ----
	 *
	 * @param string $name
	 * @param \ILIAS\UI\Component\Icon\Icon | \ILIAS\UI\Component\Glyph\Glyph $symbol
	 * @return \ILIAS\UI\Component\MainControls\Slate\Search
	 */
	public function search(string $name, $symbol): Search;

		/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Combined Slate bundles any number of Slates into one.
	 *
	 *   composition: >
	 *     The Search Slate consists of more Slates.
	 *
	 *   effect: >
	 *      TODO
	 *
	 *
	 * context:
     *     - TODO
	 *
	 * rules:
	 *   usage:
	 *     1: TODO
	 *   style:
	 *     1: TODO
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
	 *     The Notification Center concentrates the visualization of
	 *     system notifications into one expandable glyph.
	 *     This unification removes the multitude of dedicated notification-icons
	 *     in favor of visual cleanliness as well as providing a designated
	 *     location for further extensions.
	 *
	 *   composition: >
	 *      The Notification Center is visualized as a glyph with a counter.
	 *      Clicked, a pop-over list with the notifying services and their
	 *      respective counter-glyphs is expanded.
	 *      The entries each consist of the services' respective glyph, counter
	 *      and title.
	 *
	 *   effect: >
	 *      All notifications, regardless of their origin, are summed up in
	 *      the counter of the Notification Center's glyph.
	 *      When clicked, a list is shown with all notifying services.
	 *      Entries as well can be clicked; the user is then directed to the
	 *      view of the service or the popovers content is changed to offer
	 *      direct interaction.
	 *
	 *   rivals:
	 *     Awareness Tool: >
	 *        2do
	 *
 	 *
	 * context:
      *     - The Notification is used in the Metabar only.
	 *
	 *
	 * rules:
	 *   usage:
	 *     1: The Notification MUST be unique for the page.
	 *     2: The Notification MUST be in the metabar.
	 *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Slate\Notification
	 */
	public function notification(string $name, $symbol): Notification;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     X
	 *
	 *   composition: >
	 *      X
	 *
	 *   effect: >
	 *      X
	 *
	 *   rivals:
	 *     Notification: >
	 *        The Notification Center is for permament notes, such as mails in
	 *        the inbox. Also, the contents are limited to more counter-glyphs
	 *        which will change the context when operated.
	 *
	 * context:
      *     - The Awarenes Tool is used in the Metabar only.
	 *
	 * rules:
	 *   usage:
	 *     1: There MUST be but one Awareness Tool on the page.
	 *     2: The Awareness Tool MUST be in the metabar.
	 *---
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Slate\Awareness
	 */
	public function awareness(string $name, $symbol): Awareness;

}