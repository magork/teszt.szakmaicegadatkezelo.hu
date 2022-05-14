// ==================================================================
//  Author:    Justin Vincent (justin@visunet.ie)
//	Web:       http://php.justinvincent.com
//	Name:      EZ Results
//  Desc:      Demonstration of EZ Results
//  Licence:   LGPL (No Restrictions)
//

!! IMPORTANT !!

Please send me a mail telling me what you think of EZ Results
and what your using it for. Cheers. [ justin@visunet.ie ]

	If EZ Results has been helpful to you why not make a donation!?
	
		Link -> https://www.paypal.com/xclick/business=justin%40justinvincent.com&item_name=EZ+Results&no_note=1&tax=0

Also, you should check http://php.justinvincent.com from time 
to time as I will be adding new PHP widgets and also a forum 
to support those widgets.

=======================================================================

Change Log:

2.00

  Before you update to 2.00 please read the following 
  VERY carefully or you could BREAK your site.

  - Added four new paging format variables..

    $ezr->text_na_next              = "Next";
    $ezr->text_na_back              = "Back";
    $ezr->text_na_start_page        = "Start";
    $ezr->text_na_last_page         = "End";

    NOTE: _na_ stands for not active
   
    I.E. When a link is not active this text is displayed instead
    of the std text. (eg $ezr->text_next, $ezr->text_back etc.)
   
    The practical use for this is when working with images like so..
   
      $ezr->text_next    = '<img src=forward.gif>';
      $ezr->text_na_next = '<img src=forward_grey.gif>';
   
    If you update to 2.00 from a lower version you must add the above 
    four variables to any existing templates that you have created.
    If you want the text to be the same for not active as active then 
    do this.. (i.e. this keeps things the same as they are now)
   
      $ezr->text_next    = 'Next';
      $ezr->text_na_next = 'Next';
   
    If you want EZ Results to hide an un-active link then do 
    the following..

      $ezr->text_next    = 'Next';
      $ezr->text_na_next = '';

    Note: This is the default behavior until you add the four 
          new variables to your templates.

1.16

  - Added new feature that hides the ugly query string the user sees when
    they hovers their mouse over any of the navigation links.
    
    So now the user sees:
    
         Goto page 5 of results..
    
    Instead of:

         http://etc/my_page.php?BRSR=40&etc=etc
      
    This change is javascript based and affects the lower left hand 
    browser status area. To facilitate this change five new template 
    variables have been added:
    
        $ezr->text_hover_msg_link     = 'Goto page NUMBER of results..';
        $ezr->text_hover_msg_next     = 'Goto next NUMBER results..';
        $ezr->text_hover_msg_back     = 'Goto previous NUMBER results..';
        $ezr->text_hover_msg_start    = 'Goto start of results..';
        $ezr->text_hover_msg_end      = 'Goto end of results..';

1.15

  - Un-logged

1.14

  - Bug fixed. If user formatted a mySQL query with multiple lines 
    (in the code) it would break EZ Results functionality. Now 
    that is fixed and you can format a query on as many lines as you like.

    Thx: Will Macdonald and Morten Bjønness

1.13

  - Bug fixed. If EZ Results was called twice on the same page there 
    were errors with the alt color tag. Recommended update for everyone.
    (Thx Matthew Fass)

1.12

  - Now includes code and tutorial for using EZ Results with Smarty 
    templating engine - thx Steve Warwick

1.11

  - Fixed bug when replaceing COL1, COL2 it was maxing out at COL9 and 
    going back to COL1 rather than COL10. Thx James Ringrose, Colin Mitchell
  
1.10

  - Fixed "<< 20 Back" link bug - thanks Jeff

  - Fixed cannot display more than 10 rows on a page bug - thanks nico

  - Added following to constructor function to Stop annoying warning 
    message that comes up in new versions of PHP

    ini_set('allow_call_time_pass_reference', true);

  - Now declaring $altswitchN variables, once again to stop picky PHP warnings

1.09

  - Added alternating color to $ezr->results_row - you may have up to 
    three alternating colors expressed as:
    
    $ezr->results_row = "<tr bgcolor=ALTCOLOR1><td bgcolor=ALTCOLOR2>COL1</td><td>COL2</td><td>COL3</td></tr>";

    the colors are set with:

    $ezr->alt_color1a = "ffffff"; // ALTCOLOR1 in $ezr->results_row
    $ezr->alt_color1b = "dddddd";
		
    $ezr->alt_color2a = "ffffff"; // ALTCOLOR2 in $ezr->results_row
    $ezr->alt_color2b = "dddddd";

    $ezr->alt_color3a = "ffffff"; // ALTCOLOR3 in $ezr->results_row
    $ezr->alt_color3b = "dddddd";


1.08

  - Added $ezr->hide_results
  
    If this is set to true then EZ Results will display navigation links only. 
    This is useful if you want to do EVERYTHING outside of EZ Results - but 
    still want to make use of it's excellent PAGINATION FEATURES.
    
    I.E. Only print this: << 1 2 3 4 5 >>
    
    Usage:

        // Your custom query stuff
        include_once "ez_sql.php";
        
        $results = $db->get_results("some custom query to get this pages results");
        
        include_once "ez_results.php";
        
        $ezr->hide_results         = true;
        $ezr->set_num_results      = $db->get_var("some custom query to count TOTAL results");
        $ezr->cur_num_results      = count($results); // CURRENT num results
        $ezr->num_results_per_page = 10
        $ezr->num_browse_links     = 6;
        
        print $ezr->get();

        // Your custom code to display main results
		foreach ($results as $result)
		{
			print "$result->user $result->name<br>";
		}

        Note: In your custom sql query use the variable $_REQUEST['BRSR'] as 
              the start row.

1.07

  - Fixed $ezr->register_function again. To put it simply 'it was not working'
    it is now.

1.06

  - Fixed silly bug in init_start_row that was causing crashes for people.
    (thanks Eugen Mihai)

1.05

   - Fixed silly bug that meant it was not registering custom functions 
     correctly (thanks Nico)

  - Added variable $ezr->set_num_results thus allowing the user to do..

      $ezr->set_num_results = $db->get_var("some very complex query");
      $ezr->query_mysql('SELECT email, login FROM users');
      $ezr->display();

    This is to get around a problem where ez_results is not clever enough 
    to deal with complex queries that may have 'select distinct from etc'..
    
    So the user can now set the number of total result manually.

1.04

	- Fixed BIG bug where it wasn't showing links if you had less
	  than $num_browse_links * $num_results_per_page!
	  
	- Fixed bug where it wasn't showing seperator 2 in some instances

	- Fixed bug where itwas calculating the CUR_END incorrectly in freeform navigation

	- Added ability to hide results
	  $ezr->hide_results = true;
	  
	  This is so that you can use EZ Results to query and output
	  paging links and then create your own result output by doing this...
	  
	  $ezr->query_mysql("SELECT email, login FROM users",OBJECT); 
	  $ezr->hide_results = true;
	  $ezr->nav_bottom  = false;
	  $ezr->display(); // Only outputs one set of nav links
	  
	  // Total freedom to do as you wish
	  foreach ( $ezr->results as $user )
	  {
	     echo $user->email;
	     echo $user->login;
	  }

	- With the above in mind I tweaked the $ezr->query_mysql() function
	  to be work liek so:
	  
	  $ezr->query_mysql($query,OBJECT);
	  $ezr->query_mysql($query,ARRAY_A);
	  $ezr->query_mysql($query,ARRAY_N);
	  (Defaults to ARRAY_N)
	  
1.03

	- Added freeform navigation formatting variables

	  $ezr->mixed_nav_left
	  $ezr->mixed_nav_right
	  
	  Thus allowing you to write something like this:
	  $ezr->mixed_nav_left =  "Browsing CUR_START-CUR_END of TOTAL_RESULTS results (page CUR_PAGE of NUM_PAGES pages)";

	  Which outputs this:
	  Browsing 1-5 of 256 results (page 1 of 25 pages)

1.02

	- Added ability to change the ez_sql object from $db-> to whatever.
	  (N.B. Still defaults to $db) thx Adam Goossens.

1.01

	- Last page calculation bug was fixed
	- 3 sample templates added

1.00 - Initial Release

	Functions..
	
	- $ezr = new ez_results - initialise class
	- $ezr->query_mysql()- Submit query (if using mySQL database)
	- $ezr->query_oracle() - Submit query (if using Oracle database)
	- $ezr->get() - Gets the final output (as returned value)
	- $ezr->display() - Prints the final output to screen
	- $ezr->set_qs_val() - Set a value to be carried over from click to click (during navigation)
	- $ezr->register_function() - Manipulate results (register a result manipulation function)
	- $ezr->debug() - Print a screen dump of the main object (and all it's contents)
	- $ezr->build_navigation() - main function to create nav links
	- $ezr->get_num_results() - get total results for query
	- $ezr->init_start_row() - make sure start row is set to numeric zero
	- $ezr->get_style() - build style='etc' or class='etc'
	- $ezr->get_style_na() - build style='etc' or class='etc' for non active links
	- $ezr->merge_num() - merge descriptive text with number insert

=======================================================================


