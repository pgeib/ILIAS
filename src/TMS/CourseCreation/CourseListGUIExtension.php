<?php

/* Copyright (c) 2018 Richard Klees <richard.klees@concepts-and-training.de> */

namespace ILIAS\TMS\CourseCreation;

/**
 * Enhances a course list gui with methods required for display of the action to
 * create the course.
 */
trait CourseListGUIExtension {
	/**
	 * Overwritten from ilObjectListGUI. Enhances the supplied commands by
	 * a custom command for the course creation.
	 *
	 * @inheritdocs
	 */
	public function getCommands() {
		$commands = parent::getCommands();
		if ($this->getCreateCourseAccessGranted()) {
			$commands[] =
				[ "cmd" => $this->getCreateCourseCommand()
				, "link" => $this->getCreateCourseCommandLink()
				, "frame" => ""
				, "lang_var" => $this->getCreateCourseCommandLngVar()
				, "txt" => null
				, "granted" => $this->getCreateCourseAccessGranted()
				, "access_info" => null
				, "img" => null
				, "default" => null
				];
		}
		return $commands;
	}

	protected function getCreateCourseCommand() {
		return "create_course_from_template";
	}

	protected function getCreateCourseCommandLink() {
		return "http://www.google.de";
	}

	protected function getCreateCourseCommandLngVar() {
		assert('!is_null($this->lng)');
		$this->lng->loadLanguageModule("tms");
		return "create_course_from_template";
	}

	protected function getCreateCourseAccessGranted() {
		return ilObjectCourseAccess::_checkAccess($this->getCreateCourseCommand(), "copy", $this->ref_id, $this->obj_id);
	}
}
