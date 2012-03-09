#!/usr/bin/php/
<?
/***********************************************************************
* Post.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: maintence jobs to expire sql
**********************************************************************/
require_once("helpers.php")

	$did_expire = get_set_expire();
	
	if ($did_expire == true)
	{
		$job_id    = 0;
		$status_id = 0;
		$notes	   = "Completed Successfully";
		insert_maintenance_entry($job_id, $status_id, $notes)
	}
	else
	{
		$job_id    = 0;
		$status_id = 9;
		$notes	   = "Not Successful";
		insert_maintenance_entry($job_id, $status_id, $notes)
	}
?>