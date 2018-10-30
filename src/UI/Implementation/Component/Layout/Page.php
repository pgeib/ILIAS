<?php
/* Copyright (c) 2017 Nils Haagen <nils.haagen@concepts-and-training.de> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Implementation\Component\Layout;

use ILIAS\UI\Component as C;
use ILIAS\UI\Implementation\Component\ComponentHelper;

/**
 * Page
 */
class Page implements C\Layout\Page {
	use ComponentHelper;

	/**
	 * @var 	mixed
	 */
	private $content;

	/**
	 * @var 	ILIAS\UI\Component\Layout\Metabar
	 */
	private $metabar;

	/**
	 * @var 	ILIAS\UI\Component\Layout\Sidebar
	 */
	private $sidebar;

	/**
	 * @var 	ILIAS\UI\Component\Breadcrumbs
	 */
	private $breadcrumbs;

	/**
	 * @var 	bool
	 */
	private $with_headers = true;


	public function __construct($content)
	{
		$this->content = $content;
	}

	/**
	 * @inheritdoc
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @inheritdoc
	 */
	public function withContent($content): C\Layout\Page
	{
		$clone = clone $this;
		$clone->content = $content;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function withMetabar(C\Layout\Metabar $metabar): C\Layout\Page
	{
		$clone = clone $this;
		$clone->metabar = $metabar;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getMetabar()
	{
		return $this->metabar;
	}

	/**
	 * @inheritdoc
	 */
	public function withSidebar(C\Layout\Sidebar $sidebar): C\Layout\Page
	{
		$clone = clone $this;
		$clone->sidebar = $sidebar;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getSidebar()
	{
		return $this->sidebar;
	}

	/**
	 * @param 	bool 	$use_headers
	 * @return 	Page
	 */
	public function withHeaders($use_headers): C\Layout\Page
	{
		$clone = clone $this;
		$clone->with_headers = $use_headers;
		return $clone;
	}

	/**
	 * @return 	bool
	 */
	public function getWithHeaders()
	{
		return $this->with_headers;
	}

	/**
	 * @inheritdoc
	 */
	public function withBreadcrumbs(C\Breadcrumbs\Breadcrumbs $breadcrumbs): C\Layout\Page
	{
		$clone = clone $this;
		$clone->breadcrumbs = $breadcrumbs;
		return $clone;
	}

	/**
	 * @inheritdoc
	 */
	public function getBreadcrumbs()
	{
		return $this->breadcrumbs;
	}

}
