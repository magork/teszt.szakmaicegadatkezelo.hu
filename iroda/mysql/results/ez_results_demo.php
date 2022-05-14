<?php

	// ==================================================================
	//  Author:    Justin Vincent (justin@visunet.ie)
	//	Web:       http://php.justinvincent.com
	//	Name:      EZ Results Demo
	// 	Desc:      Demonstration of EZ Results
	//  Licence:   LGPL (No Restrictions)
	//

	// Include ezSQL core
	include_once "ez_sql_core.php";

	// Include ezSQL database specific component
	include_once "ez_sql_mysql.php";

	// Initialise database object and establish a connection
	// at the same time - db_user / db_password / db_name / db_host
	$db = new ezSQL_mysql('root','','ct_plumb','localhost');

	// Include the EZ Results Class
	include_once "ez_results.php";

	// ********************************************************************
	//
	// !!! IMPORTANT !!!!!! IMPORTANT !!!!!! IMPORTANT !!!!!! IMPORTANT !!!
	//
	// Do not simply copy and paste code from this demo into your project.
	// If you do it will OVER COMPLICATE you project.
	// This demo is an ADVANCED example of EZ Results.
	// When starting your project make sure you get your examples
	// from ez_results_help.htm - NOT THIS FILE
	//
	// !!! IMPORTANT !!!!!! IMPORTANT !!!!!! IMPORTANT !!!!!! IMPORTANT !!!
	//
	// ********************************************************************

	// ********************************************************************
	// Configure EZ Results demo

	$db->select("ct_plumb");	            // <-- The databse your results are in
	$db_type         = "mysql";             // <-- can be 'mysql' or 'oracle'
	$db_table_name   = "arucikkek";          // <-- table must have more than 10 records
	$db_table_fields = "kod, cikk, ar"; // <-- must be comma delimeted (can't just use *)
	                                        // <-- must be at aleast 3 field names!
	//
	// ********************************************************************

	// ********************************************************************
	// Perform EZ Results query (mysql/oracle)

	if ( $db_type == 'mysql' )
	{
		$ezr->query_mysql("SELECT $db_table_fields FROM $db_table_name");
	}
	else
	{
		$ezr->query_oracle($db_table,$db_table_name);
	}

	//
	// ********************************************************************

	// ********************************************************************
	// Special stuff that is required for this demo only (due to the dynamic nature)
	// (normally don't need to get this complicated)

	// Extract fields into an array (for dynamically building number of columns)
	$fields = preg_split("/\s*,\s*/",$db_table_fields);

	// dynamically build columns (and column titles)
	$results_heading      = "";
	$results_row          = "";
	$i=0;
	foreach ( $fields as $field )
	{
		$i++;
		$results_heading  .= "<td><b>$field</b></td>"; // dynamically build column names
		$results_row      .= "<td>COL$i</td>";         // dynamically build columns
	}

	//
	// ********************************************************************

	// ********************************************************************
	// EZ Results Formatting - SAMPLE 1

	echo "<h4><font face=arial color=000066>Sample 1</font></h4>";

	$ezr->results_open	  = "<table style='font-family: verdana; font-size: 8pt; color: 000066;' cellpadding=5 cellspacing=1 bgcolor=CACAD2 width=500>";
	$ezr->results_heading = "<tr bgcolor=EFEFEF>$results_heading</tr>";
	$ezr->results_row     = "<tr bgcolor=FFFFFF>$results_row</tr>";
	$ezr->show_num_pages  = false;
    $ezr->display();

    echo "<p><hr size=1 noshade>";

	//
	// ********************************************************************

	// ********************************************************************
	// EZ Results Formatting - SAMPLE 2

	echo "<h4><font face=arial color=000066>Sample 2</font></h4>";

	$ezr->nav_top            = false;
	$ezr->results_open       = "<table style='font-family: verdana; font-size: 8pt; color: ffffff;' cellpadding=3 cellspacing=1 bgcolor=FFFFFF width=500>";
	$ezr->results_heading    = "<tr bgcolor=555555><td colspan=".count($fields)."><b>THESE ARE MY RESULTS</b></td></tr>";
	$ezr->results_row        = "<tr bgcolor=BBBBBB>$results_row</tr>";
	$ezr->show_num_pages     = true;
	$ezr->style_count        = 'font-family: verdana; color: 555555; font-size: 7pt;';
	$ezr->text_count         = 'NUMBER RECORDS';
	$ezr->text_start_page    = 'START |';
	$ezr->text_na_start_page = 'START |';
	$ezr->text_last_page     = '| END';
	$ezr->text_na_last_page  = '| END';
	$ezr->text_next          = "Up &gt;&gt;";
	$ezr->text_na_next       = "Up &gt;&gt;";
	$ezr->text_back          = "&lt;&lt; Down";
	$ezr->text_na_back       = "&lt;&lt; Down";
    $ezr->display();

    echo "<p><hr size=1 noshade>";

	//
	// ********************************************************************

    // ********************************************************************
	// EZ Results Formatting - SAMPLE 3
	//
	// Note: This sample is a very simple listing without a table

	echo "<h4><font face=arial color=000066>Sample 3</font></h4>";

	$ezr->num_results_per_page = 5;
	$ezr->nav_top          = true;
	$ezr->nav_bottom       = false;
	$ezr->text_count       = '<b>Browsing NUMBER Listings:</b>';
	$ezr->style_count      = '';
	$ezr->style_link       = 'color: 0000FF;';
	$ezr->style_nolink     = 'font-weight: bold;';
	$ezr->text_next        = 'Next NUMBER &gt;&gt;';
	$ezr->text_na_next     = 'Next NUMBER &gt;&gt;';
	$ezr->style_next       = 'text-decoration: none; color: 0000FF;';
	$ezr->style_na_next    = 'color: AAAAAA;';
	$ezr->text_back        = '&lt;&lt; NUMBER Back';
	$ezr->text_na_back     = '&lt;&lt; NUMBER Back';
	$ezr->style_back       = 'text-decoration: none; color: 0000FF;';
	$ezr->style_na_back    = 'color: AAAAAA;';
	$ezr->show_num_pages   = false;
	$ezr->show_start_page  = false;
	$ezr->show_last_page   = false;
	$ezr->results_prepend  = '<hr noshade size=1 width=400 align=left>';
	$ezr->results_open     = '';
	$ezr->results_heading  = '';
	$ezr->results_row      = '';
	$ezr->results_row      = "<b>$fields[0]:</b> \$C1<br><b>$fields[1]:</b> \$C2<br><b>$fields[2]:</b> \$C3<p>";
	$ezr->results_close    = '';
	$ezr->results_postpend = '<hr noshade size=1 width=400 align=left>';
    $ezr->display();

    echo "<p><hr size=1 noshade>";

	//
	// ********************************************************************

?>