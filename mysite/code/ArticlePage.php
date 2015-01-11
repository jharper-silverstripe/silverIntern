<?php

class ArticlePage extends Page{
	// add some basics
	//change cms icon
	//private static $icon ="cms/images/etc";
	private static $description = 'Add an article using this option';
	private static $default_parent = 'ArticleHolder';
	private static $can_be_root = false;
	//create/add to database
	private static $db = array(
		'Date' => 'Date',
		'Author' => 'Text'
	);

	public function getCMSFields(){
		//get basic cms structure
		$fields = parent::getCMSFields();
		//create a date field with a calendar dropdown, add this to the basic parent, above the 'Content' html editor
		$dateField = new DateField('Date');
		//declared in order to change config of ate field
		$dateField->setConfig('showcalendar', true);
		//Still have to add $Date.Nice to .ss file
		$dateField->setConfig('dateformat', 'dd/MM/YYYY');
		$fields->addFieldToTab('Root.Main', $dateField, 'Content');
		//could be below, however we add lots of variables to $datefield and include them all in the add to datefield option
		//$fields->addFieldToTab('Root.Main', new DateField('Author'), 'Content');

		//add a text field, for the Author, to the same area
		$fields->addFieldToTab('Root.Main', new TextField('Author', 'Author Name:'), 'Content');
		return $fields;
	}
}

class ArticlePage_Controller extends Page_Controller{

}