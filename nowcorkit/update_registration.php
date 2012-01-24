<?
require_once("includes/common.php");

$u = new User(null);
$u->state_id = get_users_state($_SESSION["users_cork_id"]);

$html = "";
$html .=  "<div id='login' title='login' class='ui-widget-content ui-corner-all' style='padding:10px'>";
$html .=  "<form id='login_form' method='POST' action='update_registration_info.php'>";
$html .=  "<h1>Update Preferences</h1>";
$html .=  "<fieldset>";
$html .=  "<table>";
$html .=  "<tr>";
$html .=  "<td><label id='lpassword'  name='lpassword' style='color:white'>Password</label></td>";
$html .=  "<td><input type='password' name='password' id='password' class='ui-widget-content ui-corner-all' /><td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label id='lpasswordconfirm'  name='lpasswordconfirm' style='color:white'>Confirm Password</label></td>";
$html .=  "<td><input type='password' name='password_confirm' id='password_confirm' class='ui-widget-content ui-corner-all'/></td>";
$html .=  "</tr><tr>"; 
$html .=  "<tr><td colspan='2'>Or</td></tr>";
$html .=  "<td><label id='lstate' name='lstate' style='color:white'>Choose State</label></td>";

echo $html;
?>
<td>
<select id="state" name="state" class="ui-widget-content">
<option value="0" >Please Choose...</option>
<?
$html = "";

// load the state to id select box
$state_array = GetStates();
for ($i=0; $i<50;$i++)
{
	$state = new State();
	$state = array_pop($state_array);
	if ($state->id == $u->state_id)
	{
		$html .=  "<option value='" . $state->id . "' selected='selected'>" . $state->name . "</option>";
	}
	else
	{
		$html .=  "<option value='" . $state->id . "'>" . $state->name . "</option>";
	}
}		

echo $html;						
?>		 
</select>
</td>
</table>
<button type="submit" style="float:right"class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" value="submit">
<span class="ui-button-text" >Update Account</span>
</button>
</fieldset>
<br>
</form>
</div>