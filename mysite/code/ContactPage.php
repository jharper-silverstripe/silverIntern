<?php
class ContactPage extends Page {

	private static $description = 'Page containing contact details and contact form';


    private static $has_many = array(
        //a contact page has many contacts and many contact messages, all stored in their own tabs/grids
        //Contact is said to have 1 parent, so contact page needs to be able to have many contacts.
        'Contact' => 'Contact',
        'ContactMessages' => 'ContactMessage'
    );

   public function getCMSFields() {
        //get the basic CMS set up
        $fields = parent::getCMSFields();

//THIS IS THE LONG WAY OF DOING IT

        // //indside the the Contact tab this is a grid setup. You can add contacts
        // $config = GridFieldConfig_RelationEditor::create();

        // //Create the components/columns of this grid, relating to the Contact.php DataObject and where the DB info will go
        // $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
        //     //DB name  => Display name
        //     'Name' => 'Name',
        //     'Email' => 'Email',
        //     'Mobile' => 'Mobile'
        // )); 


        // $contactField = new GridField(
        //     'Contact', // Refer to where in the database
        //     'Contacts', // What name do you want to put on the grid
        //     $this->Contact(), // List of all related contacts, Get everything
        //     $config // include all the grid stuff so there is somehere to put it
        // ); 

        //$fields->addFieldsToTab("Root.Contact", $contactField); 

//THIS IS THE SHORT WAY OF DOING IT
        $fields->addFieldToTab( "Root.Contacts",
            GridField::create(
                'Contact',
                'Contact',
                $this->Contact(),
                GridFieldConfig_RecordEditor::create()
            )
        ); 
        
        $fields->addFieldToTab( "Root.Messages",
            GridField::create(
                'ContactMessage',
                'ContactMessage',
                $this->ContactMessages(),
                GridFieldConfig_RecordViewer::create()
            )
        );        
        return $fields;
    }
}


//ALL THE FORM STUFF GOES IN THE CONTROLLER

//page controller or content_controller
class ContactPage_Controller extends Page_Controller {

    //form function is called when the form is submitted
    private static $allowed_actions = array(
        'ContactForm',
        'SearchContactForm',   
      
    );

    //THE FORM
    public function ContactForm(){

        $fields = new FieldList(
            DropdownField::create('ContactID', 'Contacts', Contact::get()->map('ID', 'Name')) 
            ->setEmptyString('(Select one)'),

            TextField::create('Name', 'Your name:'),
            EmailField::create('Email', 'Your email address:'),
            TextareaField::create('Message', ' Please leave a message:')
        );

        //call allowed_action when button pressed
        $actions = new FieldList(
            FormAction::create('addMessage', 'Send Email')
        );


        $validator = RequiredFields::create(array('ContactID', 'Name', 'Email', 'Message'));

        $form = new Form($this, 'ContactForm', $fields, $actions, $validator);

        return $form;

        //return new Form($this, 'ContactForm', $fields, $actions, $validator);

    }

    public function addMessage($data, Form $form){

        //get the contact id from the form dropdown box eg 1
        $contactID = $data['ContactID'];
        //get all the information regarding this contact. Use debug to see
        $contact = Contact::get()->byID($contactID);
        //Debug::dump($contact);

        //send email to contact
        $from = $data['Email'];
        $to = $contact->Email;
        $subject = "Website Contact message";
        $body = $data['Message'];
        $email = new Email($from, $to, $subject, $body);
        $email->send();


        $message = new ContactMessage();

        //save all the form data into $message
        $form->saveInto ($message);

        //What contact ID (parent ID) do we need to assign the message to?
        $message->ParentID = $contact->ID;
       
        //All the messages can be found on the contact page. So we have to link/identify that page
        //Use of this because we are on that page
        $message->ContactPageID = $this->ID;
       
        //keep all this data
        $message->write();

        $form->sessionMessage ('Thanks, we will get back to you as soon as possible ' );

        $this->redirectBack();

    }

    public function SearchContactForm(){

        $fields = new FieldList(
            new TextField('Search', 'Seach')
        );
        
        $actions = new FieldList(
            new FormAction('SearchContactResults','result' )
        ); 

        $form = new Form($this, 'SearchContactForm', $fields, $actions);      
        return $form;

    }

     public function SearchContactResults($data, $form, $request) {
       
        // $contact = Contact::get();
        //Debug::show($contact);

        //get the contact id from the form dropdown box eg 1
        // $contacts= $data['Search'];
        //Debug::show($contacts);

        // $contact = $contact->filter(array('Name:PartialMatch' => $contacts));
        //Debug::show($contact);

        //$contact = $contact->sort('Name', 'DESC');
        //Debug::show($contact);

        // foreach($contact as $contact) {
        //     echo "<p>$contact->Name $contact->Email</p>";
        // }    

        return $this;


    }

    public function getFilteredContacts(){

        $search = $this->request->postVar('Search');
        // var_dump($search);

        //$contacts = $this->Contact();
        $contacts = $this->Contact()->Sort('Name', 'ASC');

        // $contacts = $contacts->Sort('Name');
        $contacts = $contacts->filter(array('Name:PartialMatch' => $search));
        // var_dump($contacts);
        
        return $contacts;    
    }

}