<?php
class Contact extends DataObject {
	
	//what are you putting into the database
    private static $db = array(
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Mobile' => 'Varchar'
    );

    public function validate() {
        $result = parent::validate();
        if(strlen($this->Mobile) < 6) {
            $result->error('Need 7 plus digits for mobiles');
        }
        return $result;
    }

    //Set up the relationship of where the data comes from.    
    //Adding extra fields to the DB info above, eg a row/column with ParentID(of ContactPage) and the ProfilePicID
    //Images/files are stored in File in the database, along with actual files and folders (everything then to assets/uploads...)

    //But this also adds the image adding field to the add contact tab
    private static $has_one = array(
        "Parent" => "ContactPage",
        "ProfilePic" => 'Image'    
    );

    //What fields do you want to display on the grid?
	private static $summary_fields = array(
		'Name' ,
		'Email',
		'Mobile'
	);

	public function getSummary(){
		return "this is a summary";
	}


}