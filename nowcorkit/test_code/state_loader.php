<!-- // <?
// 
// require_once('../includes/common.php');
// 
// class State
// {
// 	public $name = NULL;
// }
// 
// 		
// 		if (($fp = @fopen("us_states.csv", "r")) === false)
//             return NULL;
// 
// 		// download first line of CSV file
//         if (($data = fgetcsv($fp)) === false || count($data) == 1)
//             return NULL;
// 
//         fclose($fp);
// 
// 		$state = new State();
// 		for ($i = 1; $i<count($data);$i+=2)
// 		{
// 			$state->name = $data[$i];
// 			$sql 		 = "insert into state (state_desc) values ('$state->name')";
// 			$result 	 = mysql_query($sql) or die('Error');
// 			
// 			echo mysql_insert_id() . "\n";
// 			
// 		}
// 
// ?> -->