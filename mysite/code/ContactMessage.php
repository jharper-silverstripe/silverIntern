<?php


class ContactMessage extends DataObject{

	private static $db = array(
		'Name' => 'Varchar(100)',
		'Email' => 'Varchar(100)',
		'Message' => 'Text'
	);


	//A 1-to-1 relation creates a database-column called "<Parent>ID", 
	//in the example below this would be "ParentID" on the "Contact"-table.
	private static $has_one = array(

		"Parent" => "Contact",	
		"ContactPage" => "ContactPage",
		

	);
	//To record and display all email messages, we want to add a Gridfield to the CMS
	//Add columns that the CMS gridfield will display (same as db above)
	private static $summary_fields = array(
		'Parent.Name',
		'Parent.Email',
		'Name',
		'Email',
		'Message.FirstSentence' => 'Message',
		// 'Parent.getSummary'
	);



}