<?php
class HomePage extends Page {



}
class HomePage_Controller extends Page_Controller {
	//Tut 2
	// //this would get all the article pages, and with the article teaser in the .ss would only display first paragraph
	// public function LatestNews() {
	//     $holder = ArticlePage::get();
	//     return ($holder);
	// } 	

	public function LatestNews($num=5) {
		//get holder, we know its the first and only one, so its easy..
	    $holder = ArticleHolder::get()->First();
	    //Ask Ben about ? : false
	    //also parent Id and $holderID
	    return ($holder) ? ArticlePage::get()->filter('ParentID', $holder->ID)->sort('Date DESC')->limit($num) : false;
	}

	//////////////////////////////////////////Tut 3
	private static $allowed_actions = array('BrowserPollForm');

	//creating form in controller
	//OptionsetField. 
	//This is a dropdown, and takes a third argument - an array mapping the values to the options listed in the dropdown
	public function BrowserPollForm() {

		//if there us no sessionvoted set (form submitted then show form, otherwise show results)
		if(Session::get('BrowserPollVoted')) return false;
        // Create fields
        $fields = new FieldList(
            new TextField('Name'),
            new OptionsetField('Browser', 'Your Favourite Browser', array(
                'Firefox' => 'Firefox',
                'Chrome' => 'Chrome',
                'Internet Explorer' => 'Internet Explorer',
                'Safari' => 'Safari',
                'Opera' => 'Opera',
                'Lynx' => 'Lynx'
            ))
        );
        // Create actions
        $actions = new FieldList(new FormAction('doBrowserPoll', 'Submit'));
        $validator = new RequiredFields('Name', 'Browser');
        //return form object
        return new Form($this, 'BrowserPollForm', $fields, $actions, $validator);
    }

    //Create the doBrowserPoll action

    public function doBrowserPoll($data, $form){
    	//refers to dataobject created
    	$submission = new BrowserPollSubmission();
    	//save all the form data into this dataobject
    	$form->saveInto($submission);

    	//set session variable for when user votes, if this function is called, then the user must have voted, so its true
    	Session::set('BrowserPollVoted', true);

    	//make sure its written/saved into the database
    	$submission->write();

       	return $this->redirectBack();
    }

    //create a function to display the results
    public function BrowserPollResults(){
    	//get dataobjects, group list adds ability to group records
    	$submissions = new GroupedList(BrowserPollSubmission::get());

    	//count them
    	$total = $submissions->Count();
    	//put them in an array
    	$list = new ArrayList();

    	//get all the results, group them by browser and display in array as key Browsername and value browsersubmission
    	foreach($submissions->groupBy('Browser') as $browserName => $browserSubmissions){
    		//get all results, count them, find recentage
    		$percentage = (int) ($browserSubmissions->Count() / $total * 100);
    		//give the list the new data, displayed under name with percentage
    		$list->push(new ArrayData(array(
    			'Browser' => $browserName,
    			'Percentage' => $percentage
    		)));

    	}
    	return $list;
    }

}
