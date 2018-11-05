<?php

namespace ILIAS\UI\Component\Layout;

use \ILIAS\UI\Component\MainControls as MainControls;

/**
 * This is what a factory for layout-elements looks like.
 */
interface Factory {

    /**
     * ---
     * description:
     *   purpose: >
     *     The Metabar is a unique page section to accomodate elements that
     *     should permamently be in sight of the user.
     *     Contents of the bar are never modified, but may depend on (user-) configuration.
     *
     *   composition: >
     *     The Metabar always features the logo on the left hand side, while
     *     further elements (prompts) are placed on the right hand side.
     *     The last element to the right will be the logout-button.
     *
     *   effect: >
     *     The bar is rendered horizontally on top of the page.
     *
     *
     * rules:
     *   usage:
     *     1: The Metabar is unique for the page - there MUST be but one.
     *     2: Elements in the Metabar MUST NOT vary according to context.
     *     3: New elements in the Metabar MUST be approved by JF.
     *
     *   composition:
     *     1: The bar MUST contain the logo.
     *     2: The bar SHOULD contain prompts.
     *     3: The bar MUST contain a logout-button.
     *
     *   style:
     *     1: The bar MUST have a fixed height.
     * ----
     *
     * @return  \ILIAS\UI\Component\Layout\Metabar
     */
    public function metabar(\ILIAS\UI\Component\Image\Image $logo);

    /**
     * ---
     * description:
     *   purpose: >
     *     The Sidebar is a unique page section that bundles access to
     *     content-based navigational strategies (like search or the repository tree)
     *     as well as navigation to services unrelated to the actual content,
     *     like the user's profile or administrative settings.
     *
     *     The contents of the bar are never modified by changing context,
     *     but may vary according to e.g. the current user's permissions or
     *     settings of the installation.
     *
     *     An exception for this is the invocation of Tools, e.g. search or help,
     *     from the Metabar.
     *
     *   composition: >
     *     The Sidebar holds Bulky Buttons. Usually, a button is associated
     *     with a Slate that provides further navigational options.
     *     In a desktop environment, a vertical bar is rendered on the left side
     *     of the screen covering the full height minus the header-area.
     *     Entries are aligned vertically.
     *
     *
     *   effect: >
     *     The Sidebar is always visible and available (except in exam/kiosk mode).
     *
     *     Like the header, the bar is a static screen element unaffected by scrolling.
     *     Thus, entries will become inaccessible when the window is of smaller height
     *     than the height of all entries together.
     *
     *     The contents of the bar itself will not scroll.
     *
     *     When clicking a button, usually a Slate with further options is expanded.
     *     There is but one active slate in the bar.
     *     Bulky buttons in the Sidebar are stateful, i.e. they have a
     *     pressed-status that can either be toggled by clicking the same button again
     *     or by clicking a different button.
     *
     *     When a Tool (such as help or search) is being triggered, whose contents
     *     are displayed in a Slate, a special entry is rendered as first element
     *     of the Sidebar, making the available/invoked tool(s) accessible.
     *     Tools can be closed, i.e. removed from the Sidebar, via a Close Button.
     *     When the last Tool is closed, the Tools-Entry is removed as well.
     *
     *   rivals:
     *     Tab Bar: >
     *       The Sidebar (and its components) shall not be used to substitute
     *       functionality available at objects, such as settings, members or
     *       learning progress. Those remain in the Tab Bar.
     *
     *     Content Actions: >
     *       Also, adding new items, the actions-menu (with comments, notes and tags),
     *       moving, linking or deleting objects and the like are not part of
     *       the sidebar.
     *
     *     Personal Desktop: >
     *       The Personal Desktop provides access to services and tools and
     *       displays further information at first glance (e.g. the calendar).
     *       The Sidebar may reference those tools as well, but rather in form
     *       of a link than a widget.
     *
     *     Notification Center: >
     *       Notifications of the system to the user, e.g. new Mail, are placed
     *       in the Notification Center.
     *       The direction of communication for the Sidebar is "user to system",
     *       while the direction is "system to user" in the Notification Center.
     *       However, navigation from both components can lead to the same page.
     *
     *     Modal: >
     *       Forms with the intention of modifying the content are placed in modals
     *       or on the content-page.
     *
     * rules:
     *   usage:
     *     1: There SHOULD be a Sidebar on the page. Kiosk-Mode is the only exception.
     *     2: If there is a Sidebar, it MUST be unique for the page.
     *
     *   composition:
     *     1: The bar MUST NOT contain items other than bulky buttons.
     *     2: The bar MUST contain at least one bulky button.
     *     3: The bar SHOULD NOT contain more than five bulky buttons.
     *
     *   style:
     *     1: The bar MUST have a fixed witdth (desktop).
     *
     *   interaction:
     *     1: >
     *        Operating elements in the bar MUST either lead to further
     *        navigational options within the bar (open a slate)
     *        OR actually invoke navigation, i.e. change the location/content
     *        of the current page.
     *     2: Elements in the bar MUST NOT open a modal or window.
     *
     * ----
     *
     * @param  array $entries <entry_id=> ILIAS\UI\Component\Layout\SidebarEntry[]>
     * @return  \ILIAS\UI\Component\Layout\Sidebar
     */
    public function sidebar(array $entries);


    /**
     * ---
     * description:
     *   purpose: >
     *     The sidebar entry bundles an Bulky Button and a Slate.
     *   composition: >
     *     There is no composition (=visual appearance) of this component itself -
     *     its button will be rendered in the sidebar with a signal triggering
     *     its slate.
     *
     * ----
     *
     * @param  \ILIAS\UI\Component\Button\Bulky   $button
     * @param  \ILIAS\UI\Component\MainControls\Menu\Slate | null   $slate
     * @return  \ILIAS\UI\Component\Layout\SidebarEntry
     */
    public function sidebarEntry(
        \ILIAS\UI\Component\Button\Bulky $button,
        MainControls\Menu\Slate $slate=null
    );


	/**
	 * ---
	 * description:
	 *   purpose: >
	 *    The Page is the user's view upon ILIAS in total.
	 *
     *   composition: >
     *      The main parts of a Page are the Metabar hosting the logo and tools,
     *      the Sidebar providing main navigation, breadcrumbs and, of coourse,
     *      the pages's content.
     *
     * featurewiki:
     *       - Desktop: https://docu.ilias.de/goto_docu_wiki_wpage_4563_1357.html
     *       - Mobile: https://docu.ilias.de/goto_docu_wiki_wpage_5095_1357.html
     *
     * rules:
     *   usage:
     *     1: The page MUST be rendered with content.
     *     2: The page SHOULD be rendered with a Metabar.
     *     3: The page SHOULD be rendered with a Sidebar.
     *     3: The page SHOULD be rendered with Breadcrumbs.
     *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\Layout\Page
	 */
	public function page($content);

}
