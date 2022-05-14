<?php

	/********************************************************
	*	EZ Results - Simple Table Listing
	*
	*
	*	BASIC SETTINGS
	*/
	
	$ezr->num_results_per_page  = 10;
	$ezr->num_browse_links      = 5;
	
	
	/********************************************************
	*	RESULT FORMATTING 
	*/

	// Alternating row color (you can have up to three alternating colors)
	$ezr->alt_color1a				= "ffffff"; // ALTCOLOR1 in results row
	$ezr->alt_color1b				= "dddddd";
	
	$ezr->alt_color2a				= "ffffff"; // ALTCOLOR2 in results row
	$ezr->alt_color2b				= "dddddd";

	$ezr->alt_color3a				= "ffffff"; // ALTCOLOR3 in results row
	$ezr->alt_color3b				= "dddddd";

	// Print something before main results (but after browse links)
	$ezr->results_prepend           = "";
	
	// Start results (in this case as a table)
	$ezr->results_open              = "<table style='font-family: verdana; font-size: 8pt; color: 000066;' cellpadding=5 cellspacing=1 bgcolor=CACAD2 width=600>";
	
	// Heading row (eg <tr><td>Heading 1</td><td>Heading 2</td></tr>
	$ezr->results_heading           = "<tr bgcolor=efefef><td><b>ID</b></td><td><b>Author</b></td><td><b>Title</b></td><td><b>Price</b></td></tr>";
	
	// Single result row
	$ezr->results_row               = "<tr bgcolor=ffffff><td bgcolor=efefef valign=top>COL1</td><td valign=top>COL5 COL6</td><td valign=top>COL2</td><td valign=top>COL3</td></tr>";
	
	// Close the results (in this case table)
	$ezr->results_close             = "</table>";
	
	// Print something after main results (but before lower browse links)
	$ezr->results_postpend          = "";
	
	// Message to display if there are no results
	$ezr->results_empty             = "No Results";
	
	
	/********************************************************
	*	NAVIGATION FORMATTING
	*/
	
	// navigation at top of results?
	$ezr->nav_top               = true;		
	
	// navigation at bottom of results?
	$ezr->nav_bottom            = true;		
	
	// Space between navigation links and results
	$ezr->height_below_top_nav      = 7;
	$ezr->height_above_bottom_nav   = 2;
	
	// Total Records: 20 ..
	$ezr->show_count                = true;
	$ezr->text_count                = "NUMBER Books";
	$ezr->style_count               = 'font-family: verdana; color: 660000; font-size: 8pt; font-weight: bold;';
	$ezr->class_count               = '';
	
	// .. Next 20 >> (NOTE: _na_ stands for not active)
	$ezr->text_next                 = "Next NUMBER &gt;&gt;";
	$ezr->text_na_next              = "Next NUMBER &gt;&gt;";
	$ezr->style_next                = 'font-family: verdana; color: 990000; font-size: 8pt; text-decoration: none;';
	$ezr->class_next                = '';
	$ezr->style_na_next             = 'font-family: verdana; color: 999999; font-size: 8pt; text-decoration: none;';
	$ezr->class_na_next             = '';
	
	// << 20 Back .. (NOTE: _na_ stands for not active)
	$ezr->text_back                 = "&lt;&lt; NUMBER Back";
	$ezr->text_na_back              = "&lt;&lt; NUMBER Back";
	$ezr->style_back                = 'font-family: verdana; color: 990000; font-size: 8pt; text-decoration: none;';
	$ezr->class_back                = '';
	$ezr->style_na_back             = 'font-family: verdana; color: 999999; font-size: 8pt; text-decoration: none;';
	$ezr->class_na_back             = '';

	// Turn on/off main nav links
	$ezr->show_links                = true;

	// .. 1 ..
	$ezr->style_nolink              = 'font-family: verdana; color: 990000; font-size: 10pt; font-weight: bold;';
	$ezr->class_nolink              = '';
	
	// .. 2 3 4 5 ..
	$ezr->style_link                = 'font-family: verdana; color: 000066; font-size: 9pt;';
	$ezr->class_link                = '';
	
	//  .. (6 Pages) ..
	$ezr->show_num_pages            = true;
	$ezr->text_num_pages            = "(NUMBER PAGES)";
	$ezr->style_num_pages           = 'font-family: verdana; color: 555555; font-size: 7pt;';
	$ezr->class_num_pages           = '';
	
	//  ..Pages) - ..
	$ezr->show_sep1                 = true;
	$ezr->text_sep1                 = "-";
	$ezr->style_sep1                = '';
	$ezr->class_sep1                = '';
	
	// .. - Next 20 >>
	$ezr->show_sep2                 = true;
	$ezr->text_sep2                 = "-";
	$ezr->style_sep2                = '';
	$ezr->class_sep2                = '';
	
	// .. Records: 20 - [start] .. (NOTE: _na_ stands for not active)
	$ezr->show_start_page           = true;	
	$ezr->text_start_page           = "[<u>start</u>]";
	$ezr->text_na_start_page        = "[<u>start</u>]";
	$ezr->style_start_page          = 'font-family: verdana; color: 555555; font-size: 7pt; text-decoration: none;';
	$ezr->class_start_page          = '';
	$ezr->style_na_start_page       = 'font-family: verdana; color: 999999; font-size: 7pt; text-decoration: none;';
	$ezr->class_na_start_page       = '';
	
	// .. [last of 6 pages] .. (NOTE: _na_ stands for not active)
	$ezr->show_last_page            = true;
	$ezr->text_last_page            = "[<u>end</u>]";
	$ezr->text_na_last_page         = "[<u>end</u>]";
	$ezr->style_last_page           = 'font-family: verdana; color: 555555; font-size: 7pt; text-decoration: none;';
	$ezr->class_last_page           = '';
	$ezr->style_na_last_page        = 'font-family: verdana; color: 999999; font-size: 7pt; text-decoration: none;';
	$ezr->class_na_last_page        = '';

	// Message(s) that are displayed when user hovers mouse over nav links
	$ezr->text_hover_msg_link     = 'Goto page NUMBER of results..';
	$ezr->text_hover_msg_next     = 'Goto next NUMBER results..';
	$ezr->text_hover_msg_back     = 'Goto previous NUMBER results..';
	$ezr->text_hover_msg_start    = 'Goto start of results..';
	$ezr->text_hover_msg_end      = 'Goto end of results..';
		
?>