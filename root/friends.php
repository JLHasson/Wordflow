<?php
include_once "mysql_server/checkuserlog.php";


// DEAFAULT QUERY STRING
$queryString = "WHERE email_activated='1' ORDER BY lastname ASC";
// DEFAULT MESSAGE ON TOP OF RESULT DISPLAY
$queryMsg = "";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// SET UP FOR SEARCH CRITERIA QUERY /////////
if (isset($_POST['listByq']) && $_POST['listByq'] == "by_name") {

$search = $_POST['fullname'];

$queryString = "WHERE CONCAT(firstname, ' ', lastname) LIKE '%$search%'";

$queryMsg = "Showing Members with the name ".$search."";
	 
} 	
/////////////// END SET UP FOR SEARCH CRITERIA QUERY 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = mysql_query("SELECT * FROM myMembers $queryString"); 
//////////////////////////////////// Adam's Pagination Logic ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$nr = mysql_num_rows($sql); // Get total of Num rows from the database query
if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
} 
//This is where we set how many database items to show on each page 
$itemsPerPage = 50; 
// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
// This creates the numbers to click in between the next and back buttons
$centerPages = ""; // Initialize this variable
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 
// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
// $sql2 is what we will use to fuel our while loop statement below
$sql2 = mysql_query("SELECT * FROM myMembers $queryString $limit"); 
//////////////////////////////// END Adam's Pagination Logic ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Adam's Pagination Display Setup ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '<img src="images/spacer.png" width="48" height="1" alt="spacer" />';
	// If we are not on page 1 we can place the Back button
    if ($pn != 1) {
	    $previous = $pn - 1;
		$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '"> Back</a> ';
    } 
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
		$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '"> Next</a> ';
    } 
}
/////////////////////////////////// END PAGINATION ///////////////////////////////////////


// Build the Output Section Here
$outputList = '';
while($row = mysql_fetch_array($sql2)) { 

	$num_rows = mysql_num_rows($sql);
	$id = $row["id"];
	$lastname = $row["lastname"];
	$firstname = $row["firstname"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $profile_pic = "<img src=\"$check_pic\" width=\"50px\" border=\"0\" />"; // forces picture to be 120px wide and no more
	} else {
	$profile_pic = "<img src=\"$default_pic\" width=\"50px\" border=\"0\" />"; // forces default picture to be 120px wide and no more
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
$outputList .= '
<style type="text/css">
.friendsLink a {
	text-decoration: none;
	color:#06A1F1;
}
.friendsLink a:hover {
	text-decoration: underline;
}
.friendsLink a:active {
	text-decoration: underline;
	color:#000000;
}
</style>
<table width="100%">
                  <tr>
                    <td width="10%" rowspan="2">
                    	<div style=" height:50px; overflow:hidden;">
                    		<a href="profile.php?id=' . $id . '" target="_self">'. $profile_pic . '</a>
                    	</div>
                    </td>
                
            	<td width="73%"><div class="friendsLink"><a href="profile.php?id=' . $id . '" target="_self">'. $firstname .' '. $lastname .'</a></div></td>
                 	
                  
                  </tr>
                  </table>
				  <hr />
';
	
	
} // close while //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////// END QUERY THE MEMBER DATA & Build the Output Section ////////////////////////////

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta name="Description" content="" />
<meta name="Keywords" content="" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Word of Mouth | Friends</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<script src="jquery-1.4.2.js" type="text/javascript"></script>
<style type="text/css">
.pagNumActive {
	color: #000;
	border:#060 1px solid; background-color: #06A1F1; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
	color: #000;
	text-decoration: none;
	border:#060 1px solid; background-color: #06A1F1; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}

-->
</style>
</head>
<body>
<?php include_once 'templates/header_template.php'; ?>
<?php include_once 'templates/sidebar_template.php'; ?>


<div class="wrapOverall">

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	
   <td width="738" valign="top">
    
    <table width="98%" align="center" cellpadding="6">
		
		<tr>
	   		<td>
	   			
	   			<?php 
	   			
	   				//$facebook = (object) config::get_instance()->get('facebook'); 
	   			
	   			?>
	   			
	   			<!--
	   			
	   				FACEBOOK FacePile HERE
	   			
	   			<iframe src="http://www.facebook.com/plugins/facepile.php?app_id=<?php //echo $facebook->app_id; ?>" scrolling="no" frameborder="0" style=" 
overflow:hidden; width:200px;" allowTransparency="true"></iframe>-->
	   		
	   		</td>
	   		<td>
        		
        		<h2 style="margin-left:10px;">Surf Your Peeps Among the <?php print "$num_rows"; ?> Other Members!</h2>
        		
        		<form id="form3" name="form3" method="post" action="" style="margin-left:10px;">
          		
          		
                	<input type="text" name="fullname" size="25" id="fullname" value="Enter Name Here" onfocus="if(this.value==this.defaultValue) this.value='';" />
              		<input name="button3" type="submit" id="button3" value="Search" />
          			<input type="hidden" name="listByq" id="listByq" value="by_name" />
        		</form>
        		
        		<br />Begin by searching for their name!<br />
        
        	</td>
        	
		</tr>
		<tr>
     
      	</tr>
    </table>
      <br />

      <table width="70%" align="center" cellpadding="6" >
        <tr>
          
          <td><?php print "$queryMsg"; ?><br /><br /><?php print "$outputList"; ?></td>
        </tr>
        <td><div style="margin-left:58px; margin-right:58px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div></td>
      </table>
    <br />
    <br /></td>
  </tr>
</table>



<?php include_once 'templates/footer_template.php'; ?>
</div>
</body>
</html>