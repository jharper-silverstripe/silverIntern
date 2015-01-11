<?php

class ProjectComment extends DataObject{

	private static $db = array(
		'CommentBy' => 'Varchar',
		'Comments' => 'Text'
	);

	private static $has_one = array(
		"Parent" => "Project"
	);

	private static $summary_fields = array(
		'CommentBy',
		'Comments'
	);

}