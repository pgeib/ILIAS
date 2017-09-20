<?php

class ilPreviewFactory {
	const CONTEYT_TUTOR_MANUAL = "crs_context_tutor_manual";

	public function getPreviewForContext($context) {
		switch($context) {
			case self::CONTEYT_TUTOR_MANUAL:
				return $this->getTutorContextPreview();
			default:
				throw new Exception("Unknown context: ".$context);
		}
	}

	protected function getTutorContextPreview() {
		require_once "Services/Mail/classes/Preview/class.ilCourseMailTemplateTutorContextPreview.php";
		return new ilCourseMailTemplateTutorContextPreview();
	}
}