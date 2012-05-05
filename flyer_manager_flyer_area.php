<?
  if ($_SERVER['REQUEST_METHOD'] == 'GET') { echo "<h1>We're sorry, you can only access this page by logging into your account's flyer manager!</h1>"; return;}
?>
<div id='middleContainer' class='ui-widget-content ui-corner-all middleContainer'>
<h3 class='ui-widget-header ui-corner-all middleContainerHead'>Flyer Area</h3>
<div id='area_edit_radio'>
<input type='radio' id='area_edit' 		name='area' /><label for='area_edit' 	id='larea_edit' style="width:50%">Edit</label>
<input type='radio' id='area_remove' 	name='area' /><label for='area_remove'	id='larea_remove'style="width:50%">Remove</label>
</div>
<div id='flyer_drop' class='ui-corner-all'>
<center><p id="p_drop" class='ui-widget-content fm_warn'>Drag flyer items here</p></center>
</div>
</div>