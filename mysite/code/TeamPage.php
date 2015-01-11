<?php

class TeamPage extends Page{

	private static $default_parent = 'TeamHolder';
	private static $can_be_root = false;

	private static $db = array(
		//cant put image in here as it has own database table
	);

	//create PK/FK retlation to photo

	private static $has_one = array(
		'Photo' => 'Image'
	);

	public function getCMSFields(){
		//get basic cms structure
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Images', new UploadField('Photo'));
		return $fields;
	}
}
class TeamPage_Controller extends Page_Controller{}