<?php
//save poll submissions to database, can retrieve info
class BrowserPollSubmission extends DataObject{

	private static $db = array(
		'Name' => 'Text',
		'Browser' => 'Text'
	);
}