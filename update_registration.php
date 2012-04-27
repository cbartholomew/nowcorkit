<?
require_once("includes/common.php");
$u = new User(null);
$u->state_id = get_users_state($_SESSION["users_cork_id"]);
?>
<script>
	// clean
	Menu.prototype.clean;
	
	$(function() {
		var div = ["update"];
		// run the currently selected effect
		function runEffect() {
			// run the effect
			$( "#" + div[0] ).removeAttr( "style" ).hide().fadeIn("slow");    
		};  
		runEffect();
		
		$("#btnUpdate").click(function(){ 			
				$.ajax({
			      	url:  "update_registration_info.php",
				   	type: 'post',
				   	data: {
							stateid: $("#state option:selected").val()
				   	},
			        success: function(data) {
						$("#updates").html(data)
					},
					error:   function(data) {
						
					}
				});
		});
	});		
</script>
<div id='updates' class='ui-widget-content ui-corner-all leftContainer' style='padding:10px'>
<h3 class="ui-widget-header ui-corner-all leftContainerHead">Location Update</h3>
<div class='ui-widget-content ui-corner-all' style='padding:10px'>
You may not always be in the location that your G+ has set you to. If you'd like to update your	location, you may do so below.	
</div>
<br>
<form id='update_form' method='POST' action='' >
<table>
<tr>
<td><label id='lstate' name='lstate' style='color:white'>Choose State: </label></td>    
</tr>
<td>
<select id="state" name="state" style='width:240px' class="ui-widget-content" >
<option value="0" >Please Choose...</option>
<?
// load the state to id select box
$states = GetStates();
for ($i=0; $i<50;$i++)
{
	$state = new State();
	$state = array_pop($states);
	if ($state->id == $u->state_id) {
		$html .=  "<option value='" . $state->id . "' selected='selected'>" . $state->name . "</option>";
	} else {
		$html .=  "<option value='" . $state->id . "'>" . $state->name . "</option>";
	}
}		
echo $html;						
?>		 
</select>
</td>
<td>
<button type="button" id="btnUpdate" style="float:right"class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all template_button" value="submit">
<span class="ui-button-text">Update</span>
</button>
</td>
</tr>
</table>
</form>
</div>