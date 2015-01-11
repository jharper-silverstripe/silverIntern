<?php

class StudentAdmin extends ModelAdmin{
	private static $managed_models = array( 'Student');

	private static $url_segment = 'students';

	private static $menu_title = "Students";

	public $showImportForm = true;
}