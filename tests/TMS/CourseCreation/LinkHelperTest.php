<?php

use ILIAS\TMS\CourseCreation\LinkHelper;
use ILIAS\TMS\CourseCreation\Request;
use PHPUnit\Framework\TestCase;

class LinkHelperMock {
	use  LinkHelper;

	protected function getCtrl() {
	}

	protected function getLng() {
	}

	protected function getUser() {
	}

	protected function sendInfo() {
	}

	public function _maybeShowRequestInfo(\ilCourseCreationPlugin $xccr_plugin = null, $waiting_time = 30000) {
		return $this->maybeShowRequestInfo($xccr_plugin, $waiting_time);
	}

	public function _getUsersDueRequests($user, \ilCourseCreationPlugin $plugin = null) {
		return $this->getUsersDueRequests($user, $plugin);
	}

	public function _getTrainingTitleByRequest(\ILIAS\TMS\CourseCreation\Request $request) {
		return $this->getTrainingTitleByRequest($request);
	}
}


/**
 * @group needsInstalledILIAS
 */
class LinkHelperTest extends TestCase {
	public static function setUpBeforeClass() {
		require_once("./Services/User/classes/class.ilObjUser.php");
		require_once("./Services/Language/classes/class.ilLanguage.php");

		if(file_exists(
				"./Customizing/global/plugins/Services/Cron/CronHook/CourseCreation/classes/class.ilCourseCreationPlugin.php"
			)
		) {
			require_once("./Customizing/global/plugins/Services/Cron/CronHook/CourseCreation/classes/class.ilCourseCreationPlugin.php");
		}
	}

	public function test_user_has_no_open_request() {
		$usr = $this->getMockBuilder(ilObjUser::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper = $this->getMockBuilder(LinkHelperMock::class)
			->setMethods(array("getUsersDueRequests", "getUser", "sendInfo"))
			->getMock();

		$link_helper->expects($this->never())
			->method("sendInfo");

		$link_helper->expects($this->once())
			->method("getUsersDueRequests")
			->will($this->returnValue(array()));

		$link_helper->expects($this->once())
			->method("getUser")
			->will($this->returnValue($usr));

		$this->assertFalse($link_helper->_maybeShowRequestInfo());
	}

	public function test_user_has_open_requests() {
		$txt_message = "This is the user info";

		$usr = $this->getMockBuilder(ilObjUser::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper = $this->getMockBuilder(LinkHelperMock::class)
			->setMethods(
				array(
					"getUsersDueRequests"
					, "getUser"
					, "sendInfo"
					, "getMessage"
				)
			)
			->getMock();

		$request = $this->getMockBuilder(\ILIAS\TMS\CourseCreation\Request::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper->expects($this->once())
			->method("getUsersDueRequests")
			->will($this->returnValue(array($request)));

		$link_helper->expects($this->once())
			->method("getMessage")
			->will($this->returnValue($txt_message));

		$link_helper->expects($this->once())
			->method("sendInfo")
			->with($this->equalTo($txt_message));

		$link_helper->expects($this->once())
			->method("getUser")
			->will($this->returnValue($usr));

		$this->assertTrue($link_helper->_maybeShowRequestInfo());
	}

	public function test_user_has_open_cached_requests() {
		$usr = $this->getMockBuilder(ilObjUser::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper = $this->getMockBuilder(LinkHelperMock::class)
			->setMethods(
				array(
					"getCachedRequests"
					, "setCachedRequests"
				)
			)
			->getMock();

		$request = $this->getMockBuilder(\ILIAS\TMS\CourseCreation\Request::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper->expects($this->once())
			->method("getCachedRequests")
			->will($this->returnValue(array($request)));

		$link_helper->expects($this->never())
			->method("setCachedRequests");

		$this->assertEquals(array($request), $link_helper->_getUsersDueRequests($usr));
	}

	public function test_user_has_no_cached_request_and_no_plugin() {
		$usr = $this->getMockBuilder(ilObjUser::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper = $this->getMockBuilder(LinkHelperMock::class)
			->setMethods(
				array(
					"getCachedRequests"
					, "setCachedRequests"
				)
			)
			->getMock();

		$request = $this->getMockBuilder(\ILIAS\TMS\CourseCreation\Request::class)
			->disableOriginalConstructor()
			->getMock();

		$link_helper->expects($this->once())
			->method("getCachedRequests")
			->will($this->returnValue(null));

		$link_helper->expects($this->never())
			->method("setCachedRequests");

		$this->assertEquals(array(), $link_helper->_getUsersDueRequests($usr));
	}
}