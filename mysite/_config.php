<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => 'MySQLDatabase',
	"server" => 'localhost',
	"username" => 'root',
	"password" => '',
	"database" => 'SS_master',
	"path" => '',
);

// Set the site locale
i18n::set_locale('en_US');
Project::add_extension('ProjectExtension');
Project_Controller::add_extension('ProjectControllerExtension');