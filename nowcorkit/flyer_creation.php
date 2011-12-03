<?
		require_once("includes/common.php");
		
		//  based on the passed in flyer type, execute the following procedures		
		switch ($_POST["flyer_type"])
		{
		   
		   /*
			* text only flyers
			*/
			case "text":
				// create new flyer object
				$flyer = new Flyer($_POST);
				
				// set flyer type so we pull the correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text flyer in the database
				$flyer->insert();
						
				// insert into the user_flyers table 
				$flyer->insert_into_users_flyers();
				
				// make sure we didn't die here
				echo "<p>$flyer->users_flyer_id</p>";
			break;
			
		   /*
			* text / image only flyers
			*/ 	
			case "text_image":	
				// create flyer object
				$flyer = new Flyer($_POST);
				// create and insert the image meta data
				$image = new Image($_POST);
				$image->insert();
				
				// populate the meta_data_id property for the flyer
				$flyer->image_meta_data_id = $image->id;
				
				// set the flyer type so we pull correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text/image in the database
				$flyer->insert();
				
				// insert into the user_flyers table 
				$flyer->insert_into_users_flyers();
				
				// make sure we didn't die here
				echo "<p>$flyer->users_flyer_id</p>";
			break;

		   /*
			* image only flyers
			*/ 
			case "image":
				// create flyer object
				$flyer = new Flyer($_POST);
				
				// create and insert the image meta data
				$image = new Image($_POST);
				$image->insert();
				
				// populate the meta_data_id property for the flyer
				$flyer->image_meta_data_id = $image->id;
				
				// set the flyer type so we pull correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text/image in the database
				$flyer->insert();
				
				// insert into the users_flyers table 
				$flyer->insert_into_users_flyers();				
				
				// make sure we didn't die here
				echo "<p>$flyer->users_flyer_id</p>";	
			break;
		}

		
?>