<?php

trait ilObjCategoryExtension {
	public function CategoryDB() {
		if($this->category_db === null) {
			global $DIC;
			require_once("Services/TMS/Category/CategoryDB.php");
			$this->category_db = new CategoryDB($DIC->database());
		}

		return $this->category_db;
	}

	/**
	* @inheritdoc
	*/
	function update()
	{
		$this->updateTMSSettings();
		$ret = parent::update();
		$this->throwUpdateEvent();

		return $ret;
	}

	/**
	 * read
	 *
	 * @access public
	 * @param
	 * @return
	 */
	public function read()
	{
		$this->selectTMSSettings();
		parent::read();
	}

	/**
	 * Should the cockpit be displayed in the cockpit
	 *
	 * @return bool
	 */
	public function getShowInCockpit() {
		return $this->tms_settings->getShowInCockpit();
	}

	/**
	 * Should the cockpit be displayed in the cockpit
	 *
	 * @param bool 	$show_in_cockpit
	 *
	 * @return void
	 */
	public function setShowInCockpit($show_in_cockpit) {
		$this->tms_settings = $this->tms_settings->withShowInCockpit($show_in_cockpit);
	}

	/**
	 * Update the TMS special settings
	 *
	 * @return void
	 */
	protected function updateTMSSettings() {
		$this->CategoryDB()->upsert($this->tms_settings);
	}

	/**
	 * Update the TMS special settings
	 *
	 * @return void
	 */
	protected function deleteTMSSettings() {
		$this->CategoryDB()->deleteFor((int)$this->getId());
	}

	/**
	 * Selects the TMS special settings
	 *
	 * @return void
	 */
	protected function selectTMSSettings() {
		$this->tms_settings = $this->CategoryDB()->selectFor((int)$this->getId());
	}

	protected function throwUpdateEvent() {
		global $DIC;
		$ilAppEventHandler = $DIC['ilAppEventHandler'];
		$ilAppEventHandler->raise(
			'Modules/Category',
			'tms_update',
			array('object' => $this
				,'show_in_cockpit' => $this->getShowInCockpit()
			)
		);
	}
}