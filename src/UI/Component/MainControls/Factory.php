<?php

/* Copyright (c) 2018 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\MainControls;

use \ILIAS\UI\Component\Image\Image;

/**
 * This is what a factory for main controls looks like.
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
	 *     The Metabar is rendered horizontally at the very top of the page.
	 *     It is always visible and available (except in exam/kiosk mode)
	 *     as a static screen element and is tunaffected by scrolling.
	 *     The Metabar always features the logo on the left hand side, while
	 *     further elements are placed on the right hand side.
	 *     Currently, these are "Search", "Help", "Notifications" and "Awareness"
	 *
	 *   effect: >
	 *     Especially in mobile context, the witdth of all entries may exceed
	 *     the availble width of the screen. In this case, all entries are
	 *     summarized under a "more..."-Button. The logo remains.
	 *
	 * rules:
	 *   usage:
	 *     1: The Metabar is unique for the page - there MUST be but one.
	 *     2: Elements in the Metabar MUST NOT vary according to context.
	 *     3: New elements in the Metabar MUST be approved by JF.
	 *
	 *   style:
	 *     1: The bar MUST have a fixed height.
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Metabar
	 */
	public function metabar(Image $logo): Metabar;

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Mainbar is a unique page section that bundles access to
	 *     content-based navigational strategies (like search or the repository tree)
	 *     as well as navigation to services unrelated to the actual content,
	 *     like the user's profile or administrative settings.
	 *
	 *     The contents of the bar are never modified by changing context,
	 *     but may vary according to e.g. the current user's permissions or
	 *     settings of the installation.
	 *     An exception to this is the invocation of Tools, e.g. search or help,
	 *     from the Metabar.
	 *
	 *   composition: >
	 *     The Mainbar holds Bulky Buttons. Clicking the button will carry out
	 *     its configured action.
	 *     Usually, a button is associated with a Slate that provides further navigational options.
	 *
	 *     In a desktop environment, a vertical bar is rendered on the left side
	 *     of the screen covering the full height (minus header- and footer area).
	 *     Entries are aligned vertically.
	 *     In a mobile context, the bar will be rendered horizontally on the bottom.
	 *
	 *     When the entries of a Mainbar exceed the available height (mobile: witdth),
	 *     remaining buttons will be collected in a "more..."-Button.
	 *
	 *   effect: >
	 *     The Mainbar is always visible and available (except in exam/kiosk mode)
	 *     as a static screen element unaffected by scrolling.
	 *
	 *     Bulky buttons in the Mainbar are stateful, i.e. they have a
	 *     pressed-status that can either be toggled by clicking the same button
	 *     again or by clicking a different button.
	 *     When clicking an entry, usually a Slate with further options is expanded.
	 *     This will also close all other slates triggered by the Mainbar.
	 *     In desktop-environments, Slates open on the right hand of the Mainbar,
	 *     between bar and content, thus "pushing" the content to the right.
	 *     The Slate's height equals that of the Mainbar; also, its position
	 *     will remain static when the page is scrolled.
	 *     A "close slate"-button is rendered underneath the slate, that will
	 *     close all visible Slates and reset the states of all mainbar-Entries.
	 *
	 *     When a Tool (such as help or search) is being triggered, whose contents
	 *     are displayed in a Slate, a special entry is rendered as first element
	 *     of the Mainbar, making the available/invoked tool(s) accessible.
	 *     Tools can be closed, i.e. removed from the Mainbar, via a Close Button.
	 *     When the last Tool is closed, the Tools-Entry is removed as well.
	 *
	 *
	 *   rivals:
	 *     Tab Bar: >
	 *       The Mainbar (and its components) shall not be used to substitute
	 *       functionality available at objects, such as settings, members or
	 *       learning progress. Those remain in the Tab Bar.
	 *
	 *     Content Actions: >
	 *       Also, adding new items, the actions-menu (with comments, notes and tags),
	 *       moving, linking or deleting objects and the like are not part of
	 *       the Mainbar.
	 *
	 *     Personal Desktop: >
	 *       The Personal Desktop provides access to services and tools and
	 *       displays further information at first glance (e.g. the calendar).
	 *       The Mainbar may reference those tools as well, but rather in form
	 *       of a link than a widget.
	 *
	 *     Notification Center: >
	 *       Notifications of the system to the user, e.g. new Mail, are placed
	 *       in the Notification Center.
	 *       The direction of communication for the Mainbar is "user to system",
	 *       while the direction is "system to user" in the Notification Center.
	 *       However, navigation from both components can lead to the same page.
	 *
	 *     Modal: >
	 *       Forms with the intention of modifying the content are placed in modals
	 *       or on the content-page.
	 *
	 * rules:
	 *   usage:
	 *     1: There SHOULD be a Mainbar on the page. Kiosk-Mode is the only exception.
	 *     2: If there is a Mainbar, it MUST be unique for the page.
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
	 * @return  \ILIAS\UI\Component\MainControls\Mainbar
	 */
	public function mainbar(): Mainbar;


	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     A Slate is a collection of Components that serve a specific and singular
	 *     purpose in their entirety.
	 *     It MUST be possible to subsume this purpose in one Icon/Glyph or one word,
	 *     for Slates will act as elaboration on one specific concept in ILIAS.
	 *     Accordingly, Slates depend on a triggering Component controlling their
	 *     visibility.
	 *     Slates are not part of the content and will reside next to or over it,
	 *     but will have a fixed place in the page.
	 *     Slates will open and close without changing the current context.
	 *
	 *     In contrast to purely receptive Components, Slates will ususally provide
	 *     a form of interaction, whereas this interaction may trigger a navigation
	 *     or alter the contents of the slate itself.
	 *     However, the usage of a Slate MUST NOT modify content in any way.
	 *
	 *     Examples: A Help-Screen, where the user can read a certain text and also
	 *     search available topics via a text-input, or a drill-down navigation,
	 *     where all siblings of the current level are shown next to a "back"-button.
	 *
	 *   composition: >
	 *     Slates may hold a variety of components. These can be navigational
	 *     entries, text and images or combinations of those.
	 *     When content-length exceeds the Slate's height, the contents will
	 *     start scrolling vertically with a scrollbar on the right.
	 *
	 *   effect: >
     *     TODO: this is wrong!
     *     When a Slate is opened, it will close all sibling-Slates.
     *
     *
	 *   rivals:
	 *     Panel: >
	 *       Panel...
	 *
	 *     Modal: >
	 *       Modal...
	 *
	 *     Item: >
	 *       Item...
	 *
	 *     Popover: >
	 *       Item..
	 *
	 * context:
     *     - Slates are used in the Mainbar.
     *     - Slates are used in the Metabar.
	 *
	 *
	 * rules:
	 *   usage:
	 *     1: Slates MUST NOT be used standalone, i.e. without a controlling Component.
	 *     2: There MUST be only one Slate visible at the same time per triggering Component.
	 *     3: Elements in the Slate MUST NOT modify content.
	 *     4: Slates MUST be closeable without changing context.
	 *
	 *   style:
	 *     1: Slates MUST have a fixed width.
	 *     2: Slates MUST NOT use horizontal scrollbars.
	 *     3: Slates SHOULD NOT use vertical scrollbars.
	 *     4: Slates MUST visually relate to their triggering Component.
	 *     4: Slates SHOULD NOT be affected by scrolling the page.
	 *
	 *   accessibility:
	 *     1: The Slate MUST be closeable by only using the keyboard
	 *     2: >
	 *        Actions or navigational elements offered inside a Slate
	 *        MUST be accessible by only using the keyboard
	 *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Slate\Factory
	 */
	public function slate(): Slate\Factory;

}
