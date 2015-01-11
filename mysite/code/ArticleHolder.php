<?php

class ArticleHolder extends Page{

	private static $allowed_children = array('ArticlePage');

}

class ArticleHolder_Controller extends Page_Controller{
	// all allowed functions
	private static $allowed_actions = array(
	    'rss'
	);

	public function rss() {
		//children of this are all the articles, this link (article holder?)
	    $rss = new RSSFeed($this->Children(), $this->Link(), "The coolest news around");
	    //interesting as you can now add news/rss and get a new rss page, without actually creating the page..
	    return $rss->outputToBrowser();
	}

	//not sure what this does, links seemed to work
	public function init() {
	    RSSFeed::linkToFeed($this->Link() . "rss");   
	    parent::init();
	}
	
}

//Notes
//return $rss->outputToBrowser();