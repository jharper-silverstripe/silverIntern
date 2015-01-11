<?php

class Project extends Page{
	
	private static $default_parent = 'ProjectHolder';
	private static $can_be_root = false;

	// private static $has_one = array(
	// 	'Parent' => 'ProjectHolder'
	// );
	private static $has_one = array(
		'Student' => 'Student'
	);

	private static $has_many = array(
		
		'ProjectComments' => 'ProjectComment',
	
	);
	private static $many_many = array(
		'Mentors' => 'Mentor'
	);

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		$studentField = new DropdownField('StudentID', 'Student', Student::get()->map('ID', 'Name'));
		$fields->addFieldToTab('Root.Main', $studentField, 'Content');	

		$regionDropDown = new DropdownField('Region', 'Region', $this->owner->dbObject('Region')->enumValues());
		$fields->addFieldToTab('Root.Main', $regionDropDown, 'Content');	

		//gridfield for mentors
		$mentorField = new GridField(
			'Mentors',
			'Mentor',
			$this->Mentors(),
			GridFieldConfig_RelationEditor::create()
		);

		$fields->addFieldToTab("Root.Mentors", $mentorField);
		if ($this->ID){
			$fields->addFieldToTab("Root.Comments",
				GridField::create(
					'ProjectComments',
					'ProjectComments',
					$this->ProjectComments(),
					GridFieldConfig_RecordEditor::create()

				)
			);
		} 

		
		return $fields;
	}
}

class Project_Controller extends Page_Controller{	

	private static $allowed_actions = array(
		'CommentForm',
	);

	public function CommentForm(){

		$fields = new FieldList(
			TextField::create('CommentBy', 'Your name'),
			TextareaField::create('Comments', 'Comment')
		);

		$actions = new FieldList(
			FormAction::create('addComment', 'Submit')
		);

		$validator = RequiredFields::create(array('CommentBy', 'Comments'));

		$form = new Form($this, 'CommentForm', $fields, $actions, $validator);
		return $form;
	}

	public function addComment($data, Form $form){
		$comment = new ProjectComment();
		$form->saveInto($comment);
		$comment->ParentID = $this->ID;
		$comment->write();
		$form->sessionMessage('Thanks');
		$this->redirectBack();		
	}

	// public function PagedComments(){
 //         $list = new PaginatedList(
 //             $this->ProjectComments()->Sort('Created DESC'),
 //             $this->request->getVars()
 //        );
 //        $list->setPageLength(1);
 //        return $list;
 //    }

	 // public function CreateProject(){


	 // }



}