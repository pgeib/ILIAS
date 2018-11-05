<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Component\Layout;
use ILIAS\UI\Component as C;

/**
 * This describes the Page
 */
interface Page extends C\Component {

	/**
	 * @return 	Component|Component[]
	 */
	public function getContent();

	/**
	 * @param 	Component|Component[]
	 * @return 	Page
	 */
	public function withContent($content): Page;

	/**
	 * @param 	ILIAS\UI\Component\Layout\Metabar $metabar
	 * @return 	Page
	 */
	public function withMetabar(C\Layout\Metabar $metabar): Page;

	/**
	 * @return 	ILIAS\UI\Component\Layout\Metabar | null
	 */
	public function getMetabar();

	/**
	 * @param 	ILIAS\UI\Component\Layout\Sidebar 	$sidebar
	 * @return 	Page
	 */
	public function withSidebar(C\Layout\Sidebar $sidebar): Page;

	/**
	 * @return 	ILIAS\UI\Component\Layout\Sidebar | null
	 */
	public function getSidebar();

	/**
	 * @param 	ILIAS\UI\Component\Breadcrumbs 	$breadcrumbs
	 * @return 	Page
	 */
	public function withBreadcrumbs(C\Breadcrumbs\Breadcrumbs $breadcrumbs): Page;

	/**
	 * @return 	ILIAS\UI\Component\Breadcrumbs | null
	 */
	public function getBreadcrumbs();

}
