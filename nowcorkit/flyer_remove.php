<?
		require_once("includes/common.php");
		
		
		/*
		 * Prepare a json object to return to the client,
		 * this will hold the values needed for removal
		 */
		if ($_POST["is_purge"] == 'false')
		{
			// create new null object
			$flyer = new Flyer(null);
			
			// populate the object with the flyer contents
			$flyer = GetFullFlyer($_POST["users_flyer_id"]);
			
			// associate the correct flyer id	
			$flyer->users_flyer_id = $_POST["users_flyer_id"];
			
			//associate the correct flyer type
			$flyer->flyer_type = $_POST["flyer_type"];
			
			// return the object back as a json request
			header('Content-Type: application/json');
			echo json_encode($flyer);
		}
		else
		{
		
		//  based on the passed in flyer type, execute the following procedures		
		switch ($_POST["template"])
		{
		   
		   /*
			* text only flyers
			*/
			case "text":
				// create new flyer object and assoicate properties which are left out by constructor
				$flyer = new Flyer($_POST['flyer']);
				$flyer->id				   = $_POST['flyer']['id'];
				$flyer->users_flyer_id 	   = $_POST['flyer']['users_flyer_id'];
				$flyer->type			   = $_POST['flyer']['type'];
			
				// remove flyer
				$flyer->delete();
			
				echo "done text";
				break;
			
		   /*
			* text / image only flyers
			*/ 	
			case "text_image":	
				
				// create new flyer object and assoicate properties which are left out by constructor
				$flyer = new Flyer($_POST['flyer']);
				$flyer->id				   = $_POST['flyer']['id'];
				$flyer->users_flyer_id 	   = $_POST['flyer']['users_flyer_id'];
				$flyer->image_meta_data_id = $_POST['flyer']['image_meta_data_id'];
				$flyer->type			   = $_POST['flyer']['type'];
				
				// create new image object to delete meta data first
				$image = new Image(null);
				
				// remove images assoicated to this flyer from database only
				$image->delete($flyer->image_meta_data_id);
				
				// remove flyer
				$flyer->delete();
				
				echo "done txt/image";
			break;

		   /*
			* image only flyers
			*/ 
			case "image":
				// create new flyer object and assoicate properties which are left out by constructor
				$flyer = new Flyer($_POST['flyer']);
				$flyer->id				   = $_POST['flyer']['id'];
				$flyer->users_flyer_id 	   = $_POST['flyer']['users_flyer_id'];
				$flyer->image_meta_data_id = $_POST['flyer']['image_meta_data_id'];
				$flyer->type			   = $_POST['flyer']['type'];
			
				// create new image object to delete meta data first
				$image = new Image(null);
			
				// remove images assoicated to this flyer from database only
				$image->delete($flyer->image_meta_data_id);
			
				// remove flyer
				$flyer->delete();
			
				echo "done txt/image";
			break;
		}
	}
		
?>