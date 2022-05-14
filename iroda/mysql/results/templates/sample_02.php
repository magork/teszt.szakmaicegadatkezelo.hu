<?php

	/********************************************************
	*	EZ Results - Simple Picture Listing
	*
	*
	*	BASIC SETTINGS
	*/
	
	$ezr->num_results_per_page  = 5;
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
	$ezr->results_open              = "";
	
	// Heading row (eg <tr><td>Heading 1</td><td>Heading 2</td></tr>
	$ezr->results_heading           = "";
	
	// Single result row
	$ezr->results_row               = "<table cellpadding=5><tr><td valign=top><table height=100 width=100 bgcolor=555555 cellspacing=1 cellpadding=5><tr bgcolor=efefef><td align=middle valign=middle><font size=1><b>COL2</b><br><br>by<br><br>COL5 COL6</font></td></tr></table></td><td valign=top width=400><font size=2><b>COL2</b><br>COL4</font></td></tr></table><p>";
	
	// Close the results (in this case table)
	$ezr->results_close             = "";
	
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
	$ezr->nav_bottom            = false;		
	
	// Space between navigation links and results
	$ezr->height_below_top_nav      = 20;
	$ezr->height_above_bottom_nav   = 2;
	
	// Total Records: 20 ..
	$ezr->show_count                = true;
	$ezr->text_count                = "Browsing NUMBER Books";
	$ezr->style_count               = 'font-family: verdana; color: 660000; font-size: 10pt; font-weight: bold;';
	$ezr->class_count               = '';
	
	// .. Next 20 >> (NOTE: _na_ stands for not active)
	$ezr->text_next                 = "<font face=webdings size=4>8</font>";
	$ezr->text_na_next              = "<font face=webdings size=4>8</font>";
	$ezr->style_next                = 'font-family: verdana; color: 990000; font-size: 8pt; text-decoration: none;';
	$ezr->class_next                = '';
	$ezr->style_na_next             = 'font-family: verdana; color: aaaaaa; font-size: 8pt; text-decoration: none;';
	$ezr->class_na_next             = '';
	
	// << 20 Back .. (NOTE: _na_ stands for not active)
	$ezr->text_back                 = "<font face=webdings size=4>7</font>";
	$ezr->text_na_back              = "<font face=webdings size=4>7</font>";
	$ezr->style_back                = 'font-family: verdana; color: 990000; font-size: 8pt; text-decoration: none;';
	$ezr->class_back                = '';
	$ezr->style_na_back             = 'font-family: verdana; color: aaaaaa; font-size: 8pt; text-decoration: none;';
	$ezr->class_na_back             = '';

	// Turn on/off main nav links
	$ezr->show_links                = true;

	// .. 1 ..
	$ezr->style_nolink              = 'font-family: verdana; color: 990000; font-size: 12pt; font-weight: bold;';
	$ezr->class_nolink              = '';
	
	// .. 2 3 4 5 ..
	$ezr->style_link                = 'font-family: verdana; color: 000000; font-size: 11pt;';
	$ezr->class_link                = '';
	
	//  .. (6 Pages) ..
	$ezr->show_num_pages            = true;
	$ezr->text_num_pages            = "<font face=webdings size=4>¨</font>";
	$ezr->style_num_pages           = 'font-family: verdana; color: 555555; font-size: 7pt;';
	$ezr->class_num_pages           = '';
	
	//  ..Pages) - ..
	$ezr->show_sep1                 = true;
	$ezr->text_sep1                 = "";
	$ezr->style_sep1                = '';
	$ezr->class_sep1                = '';
	
	// .. - Next 20 >>
	$ezr->show_sep2                 = true;
	$ezr->text_sep2                 = "";
	$ezr->style_sep2                = '';
	$ezr->class_sep2                = '';
	
	// .. Records: 20 - [start] .. (NOTE: _na_ stands for not active)
	$ezr->show_start_page           = true;	
	$ezr->text_start_page           = "<font face=webdings size=4>9</font>";
	$ezr->text_na_start_page        = "<font face=webdings size=4>9</font>";
	$ezr->style_start_page          = 'color: 555555; text-decoration: none;';
	$ezr->class_start_page          = '';
	$ezr->style_na_start_page       = 'color: aaaaaa; text-decoration: none;';
	$ezr->class_na_start_page       = '';
	
	// .. [last of 6 pages] .. (NOTE: _na_ stands for not active)
	$ezr->show_last_page            = true;
	$ezr->text_last_page            = "<font face=webdings size=4>:</font>";
	$ezr->text_na_last_page         = "<font face=webdings size=4>:</font>";
	$ezr->style_last_page           = 'color: 555555; text-decoration: none;';
	$ezr->class_last_page           = '';
	$ezr->style_na_last_page        = 'color: aaaaaa; text-decoration: none;';
	$ezr->class_na_last_page        = '';

	// Message(s) that are displayed when user hovers mouse over nav links
	$ezr->text_hover_msg_link     = 'Goto page NUMBER of results..';
	$ezr->text_hover_msg_next     = 'Goto next NUMBER results..';
	$ezr->text_hover_msg_back     = 'Goto previous NUMBER results..';
	$ezr->text_hover_msg_start    = 'Goto start of results..';
	$ezr->text_hover_msg_end      = 'Goto end of results..';
	
?>