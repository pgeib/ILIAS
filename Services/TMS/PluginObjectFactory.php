<?php

trait PluginObjectFactory {
	protected function getCourseCreationPlugin() {
		return $this->getPluginFor("xccr");
	}

	private function getPluginFor($plugin) {
		require_once("Services/Component/classes/class.ilPluginAdmin.php");
		if (!\ilPluginAdmin::isPluginActive($plugin)) {
			return null;
		}

		return \ilPluginAdmin::getPluginObjectById($plugin);
	}
}