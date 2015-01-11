<?php

class CommentAdmin extends ModelAdmin{
	private static $managed_models = array( 'ProjectComment');
	//url value
	private static $url_segment = 'comments';
	//button lable value
	private static $menu_title = 'Comments';
	
	public $showImportForm = true;

}