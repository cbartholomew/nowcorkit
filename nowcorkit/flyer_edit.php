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
				
				// associate flyer id
				$flyer->id = $_POST["flyer_id"];
				
				// set flyer type so we pull the correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text flyer in the database
				$flyer->update();
				
				// make sure we didn't die here
				echo "<p>$flyer->id</p>";
			break;
			
		   /*
			* text / image only flyers
			*/ 	
			case "text_image":	
				// create flyer object
				$flyer = new Flyer($_POST);
				
				// associate flyer id
				$flyer->id = $_POST["flyer_id"];
				
				// set the flyer type so we pull correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text/image in the database
				$flyer->update();
				
				// make sure we didn't die here
				echo "<p>where am i?</p>";
			break;

		   /*
			* image only flyers
			*/ 
			case "image":
				// create flyer object
				$flyer = new Flyer($_POST);
				
				// associate flyer id
				$flyer->id = $_POST["flyer_id"];
				
				// set the flyer type so we pull correct SQL
				$flyer->flyer_type = $_POST["flyer_type"];
				
				// insert the new text/image in the database
				$flyer->update();
							
				// make sure we didn't die here
				echo "<p>$flyer->id</p>";	
			break;
		}

		
?>