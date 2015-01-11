<?php

class ProjectsHolder extends Page{

	private static $allowed_children = array(
		'Project'
	);

	// private static $has_many = array(
	// 	'Projects' => 'Project'
	// );
}

class ProjectsHolder_Controller extends Page_Controller{
	private static $allowed_actions = array(
		'SearchProjectForm',
		'ProjectResults',
		'getResult'
	);

	public function SearchProjectForm(){
		$fields = new FieldList(

			//DropdownField::create('ProjectID', 'Projects', Project::get()->map('ID', 'Title'))->setEmptyString('Please select')
			//new TextField('Search', 'Search')
			DropdownField::create('ProjectID', 'Projects', array('ASC' => 'Sort by Student name ASC', 'DESC' =>'Sort by Student name DESC'))
		);

		$actions = new FieldList(
			new FormAction('ProjectResults', 'Find')
		);

		$form = new Form($this, 'SearchProjectForm', $fields, $actions);

		return $form;		
	}

	public function ProjectResults($data, $form, $request){

		//$form->addErrorMessage('ProjectID', 'test', 'bad');
		return $this;

	}



//SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
//FROM Orders
//INNER JOIN Customers
//ON Orders.CustomerID=Customers.CustomerID; 

//SELECT column_name(s)
//FROM table1
//LEFT OUTER JOIN table2
//ON table1.column_name=table2.column_name;
	// $members = Member::get()
 //    ->leftJoin("Group_Members", "\"Group_Members\".\"MemberID\" = \"Member\".\"ID\"");



	public function getResult(){
		//Table join for project and student!

		/**
		 * BAD
		 */
		// $search = $this->request->postVar('ProjectID');	
		
		// $projects = Project::get()
  //   	->leftJoin("Student", "\"Student\".\"ID\" = \"Project\".\"StudentID\"")->Sort('Student.Name', 'ASC');
		// //Debug::show($projects);	
			
		// if($search == 'DESC'){
		// 	$projects = Project::get()
		// 	->leftJoin("Student", "\"Student\".\"ID\" = \"Project\".\"StudentID\"")->Sort('Student.Name', 'DESC');
		// }
		
		// return $projects;


		/**
		 * GOOD
		 */
		$search = $this->request->postVar('ProjectID');	
		
		$projects = Project::get()
    		->leftJoin("Student", "\"Student\".\"ID\" = \"Project\".\"StudentID\"");
		//Debug::show($projects);	
			
		if($search == 'DESC'){
			$projects = $projects->Sort('Student.Name', 'DESC');
		} else {
			$projects = $projects->Sort('Student.Name', 'ASC');
		}
		
		return $projects;




		////Seach by asc/desc
		// $search = $this->request->postVar('ProjectID');		
		// $get = Project::get()->Sort('Title', 'ASC');

		// if($search == 'DESC'){
		// 	$get = Project::get()->Sort('Title', 'DESC');
		// }
		// return $get;
		
		//search by dropdown
		// $search = $this->request->postVar('ProjectID');		
		// $get = Project::get()->Sort('Title', 'ASC');
		// //if there is a search then do it, otherwise its the set above which gets everything.
		// if($search){
		// 	$get = $get->filter(array('ID' => $search));
		// }
		// //Debug::show($search);
		// return $get;

	}
	
}