<?php

class Student extends DataObject{
	private static $db = array(
		'Name' => 'Varchar',
		'University' => 'Varchar'
	);

	// private static $has_one = array(
	// 	'Project' => 'Project'
	// );

	private static $summary_fields = array(
		'Name' => 'Name',
		'University' => 'University'
		//'Project.Title' => 'Project'
	);
}