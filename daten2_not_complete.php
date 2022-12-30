<?php 		//require('wp-content/plugins/civicrm/civicrm/api/class.api.php');
		require('wp-content/plugins/civicrm/civicrm/civicrm.config.php');
		require_once 'wp-content/plugins/civicrm/civicrm/CRM/Core/Config.php';
				
		
		

		$contacts = \Civi\Api4\Contact::get()
  			->addSelect('first_name', 'last_name')
  			//->addWhere('first_name', '=', 'A')
  			->setLimit(15)
  			->execute();
		


		$relationships = \Civi\Api4\Relationship::get()
  			->addSelect('contact_id_a', 'contact_id_b', 'contact.id', 'contact.first_name', 'contact.last_name', 'contact_id_a.birth_date', 'contact_type.parent_id')
		  	->addJoin('Contact AS contact', 'LEFT', ['contact_id_a', '=', 'contact.id'])
  			->addJoin('Address AS address', 'LEFT', ['contact_id_a', '=', 'contact.id'])
  			->addWhere('relationship_type_id', '=', 1)
  			->setLimit(25)
  			->execute();


		

		$read_arr = [];
		$query = [];
		if(isset($_POST['submit'])) {
			if(isset($_POST['query'])) {
				if( $_POST['query'] == "kinder")
					$query = $relationships;
				else
					$query = $contacts;
		}}
		foreach ($query as $queer) {
			array_push($read_arr, $queer);
		}
		echo json_encode($read_arr);
?> 
