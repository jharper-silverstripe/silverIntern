<?php

class ProjectControllerExtension extends DataExtension{
	private static $allowed_actions = array('RegistrationForm');

	public function RegistrationForm(){

		$fields = FieldList::create(
			TextField::create('Name'),
			TextField::create('Organisation'),
			EmailField::create('Email')
		);

		$actions = FieldList::create(FormAction::create('doRegister', 'Send Registration'));

		$form = Form::create($this->owner, 'RegistrationForm', $fields, $actions);

		return $form;

	}

	public function doRegister($data, Form $form){
		if($this->spacesAvailable()){
		$registration = Registration::create();
		$form->saveInto($registration);
		$registration->ProjectID = $this->owner->ID;
		$registration->write();
		$form->sessionMessage('Thanks');
		} else {
			$form->sessionMessage('computer says no');
		}
		return $this->owner->redirectBack();

		// Debug::message('$registration');
		// Debug::dump($registration);
		// Debug::message('$form');
		// Debug::dump($form);
	}

	public function spacesAvailable(){
		$registrations = Registration::get()->filter('ProjectID', $this->owner->ID)->Count();
		$spacesleft = (int)($this->owner->MaxParticipants - $registrations);
		if($spacesleft <= 0){
			return 0;
		}
		return $spacesleft;
	}

	public function peopleAttending(){
		return Registration::get()->filter('ProjectID', $this->owner->ID)->exclude('Status', 'Applied');
	}




}