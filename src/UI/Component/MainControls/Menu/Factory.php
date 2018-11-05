<?php

namespace ILIAS\UI\Component\MainControls\Menu;

/**
 * This is what a factory for menu-elements looks like.
 */
interface Factory {
	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     The Slate is a page-area within the sidebar; it acts like an enhanced
	 *     fly-out menu for sidebar-entries.
	 *     The contents of a Slate can vary heavily: A search form, the repository tree,
	 *     contextual help, further navigation via buttons, etc.
	 *     However, tools within the Slate should not modify the systems data
	 *     in any way - it is for navigation only.
	 *
	 *   composition: >
	 *     The Slate can hold a large variety of components. These can be (further)
	 *     navigational entries, text and images or combinations of those.
	 *
	 *   effect: >
	 *     When triggered, the Slate opens on the right hand of the sidebar,
	 *     between bar and content, thus "pushing" the content to the right.
	 *     The Slate's height equals that of the sidebar; also, its position
	 *     will remain static when the page is scrolled.
	 *
	 *     The Slate will allways have a "close"-button at its bottom.
	 *
	 *     When content-length exceeds the Slate's height, the area above the
	 *     close button will start scrolling vertically with a scrollbar on the right.
	 *
	 * rules:
	 *   usage:
	 *     1: There MUST be only one Slate visible at the same time.
	 *     2: Elements in the Slate MUST NOT modify content.
	 *
	 *   accessibility:
	 *     1: The Slate MUST be closeable by only using the keyboard
	 *     2: >
	 *        Actions or navigational elements offered inside a Slate
	 *        MUST be accessible by only using the keyboard
	 *
	 * ----
	 *
	 * @param      \ILIAS\UI\Component\MainControls\Menu\Plank[] 	$planks
	 * @return    \ILIAS\UI\Component\MainControls\Menu\Slate
	 */
	public function slate(array $planks);

	/**
	 * ---
	 * description:
	 *   purpose: >
	 *     A Plank is used to further cluster elements of a slate.
	 *
	 *   composition: >
	 *     Planks MAY contain further planks as well as other components.
	 *
	 * ----
	 *
	 * @return  \ILIAS\UI\Component\MainControls\Menu\Plank
	 */
	public function plank();

}