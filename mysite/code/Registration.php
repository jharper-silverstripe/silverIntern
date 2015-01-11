<?php

class Registration extends DataObject{

	private static $db = array(
		'Name' => 'Varchar',
		'Organisation' => 'Varchar',
		'Email' => 'Varchar',
		'Status' => 'Enum("Applied, Confirmed", "Applied")'
	);

	private static $has_one = array(
		'Project' => 'Project'
	);

	private static $summary_fields = array(
		'Name', 
		'Organisation',
		'Email',
		'Status'
	);

	public function onBeforeWrite(){
		if(
			$this->Status == "Confirmed" && !Member::get()->filter('Email', 
			$this->Email)->Count()
		){
			$member = Member::create();
			$member->FirstName = $this->FirstName;
			$member->Surname = $this->Surname;
			$member->Email= $this->Email;
			$member->write();
		}

		parent::onBeforeWrite();
	}

	public function getFirstName(){
		return $this->splitName(0);
	}
	public function getSurname(){
		return $this->splitName(1);
	}
	private function splitName($id){
		$result = explode(' ', $this->Name);
		return $result[$id];
	}
}