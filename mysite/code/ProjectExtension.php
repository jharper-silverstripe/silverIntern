<?php
class ProjectExtension extends DataExtension{
	private static $db = array(
		"EnableRegistrations" => "Boolean",
		'MaxParticipants' => 'Int',
		"Region" => "Enum('Northland, Auckland, Waikato, Bay of Plenty, Gisborne, Hawkes Bay, Taranaki,
		 Manawatu-Whanganui, Wellington, Tasman, Nelson, Marlborough, West Coast, Canterbury, Otago, Southland')"
	);

	private static $has_many = array(
		'Registrations' => 'Registration',
	);

	//couldnt position above 'Page type', like with 'Content'
	public function updateSettingsFields(FieldList $fields){
		$fields->addFieldToTab("Root.Settings",	CheckboxField::create('EnableRegistrations', 'Enable Registration'));	
		$fields->addFieldToTab("Root.Settings",	TextField::create('MaxParticipants'));	
	}

    public function updateCMSFields( FieldList $fields ){

        if( $this->owner->EnableRegistrations ){
            $fields->addFieldToTab( 'Root.Registrations',
                GridField::create(
                	'Registrations', 
                	'Registrations',
                    $this->owner->Registrations(),
                    GridFieldConfig_RecordEditor::create(4)

                )
            );

        }    
    }

 //    public static function getRegions() {
	// 	return singleton('Event')->dbObject('Region')->enumValues();
	// }



}