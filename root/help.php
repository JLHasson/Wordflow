<?php

 include_once "mysql_server/checkuserlog.php";
 
 $id = $_SESSION['id'];
	$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");

	while($row = mysql_fetch_assoc($sql)){ 
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$email = $row["email"];
	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word of Mouth Help Page" />
<meta name="Keywords" content="word, flow, wordofmouth, word, of, mouth, help, page, social, review" />
<meta name="rating" content="General" />
<title>Word of Mouth | Help</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
</head>
<body>
	
		<?php include_once 'templates/header_template.php'; ?>
		<?php include_once 'templates/sidebar_template.php'; ?>
    <div class="wrapOverall">
	<div class="black_text">
        <table class="contentMain" width="710" align="center" cellpadding="8" cellspacing="0">
    	<tr valign="top" height="50px">
        	<td><h2>Need Help?</h2></td>
        </tr>
        <tr valign="top">
        <td>Well that's alright. That's what this page is for! To help and direct you as you navigate through the
        surprisingly simple and sophisticated features Word of Mouth has to offer!<br /><br/>
              
        <h4>What is a Bought It!?</h4>
        A Bought It is the newest way to show your friends what you think about what you've bought.
        <br />
        <br />
        * Disclaimer: "Bought It!" is a phrase used by Word of Mouth<sub>&copy;</sub>. It simply means "a product review". 
        Please review any products you have recently purchased, recieved as a gift, or have had in your 
        possesion for a long time. Whether you love a product or hate it, post a review here, it could help one of your friends
        make a decision on a purchase later.
        <br /><br/>
         
        <h4>What is Spread the Word!?</h4>
		Spread the Word is a new way to easily share referrals with your friends. Instead of having to take the time to
		write a single referral over and over in order to share with each of your friends, Word of Mouth makes it easier 
		than ever. With Spread the Word, your referrals will all be one place! Your profile will display your referrals
		for your friends to see as well as the information they need to contact that business or service.
		
		
		<h4>Categories Explained</h4>
		If you are confused, or just wanting some advice on how the category system for reviews and referrals works within
		Word of Mouth<sub style="font-size:10px;">&#169;</sub>, don't worry! This guide below will help you figure out
		what to post within each category:
		
		</td>
        </tr>
        
        </table>
        <table class="contentMain" width="710" height="1000px" align="center" cellpadding="8" cellspacing="0">
        	<tr valign="top" height="50px">
        		<td width="50%">
				
					<h4 style="color:#0099ff">Review Categories:</h4>
					<b>1. Appliances</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Parts<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tools<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Equipment<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Accessories<br />
					<br />

					<b>2. Apps</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Apple<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Android<br />
					<br />

					<b>3. Automotive</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Parts<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tools<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Equipment<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Accessories<br />
					<br />

					<b>4. Baby</b><br /> 
&nbsp &nbsp &nbsp &nbsp &nbsp - Nursery<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Feeding<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Gear<br />
					<br />

					<b>5. Beauty</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Fragrance Bath<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Skin & Hair Care<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bath<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Make-Up<br />
					<br />

					<b>6. Books & Art</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Books<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Calendars<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Card Decks<br />
					<br />

					<b>7. Clothing and Accessories</b><br /> 
&nbsp &nbsp &nbsp &nbsp &nbsp - Outerwear<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Althetic Wear<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Inner Wear<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Belts<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Handbags<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Wallets<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Sunglasses<br />
					<br />

					<b>8. Electronics</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Cameras<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - TVs<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Cell Phones<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - CD Players<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Computers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - GPS<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Handheld Devices<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Video Games<br />

					<br />

					<b>9. Food</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Beverages<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Breakfast<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Canned Goods<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Snacka<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Grocery Items<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - GPS<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Handheld Devices<br />
					<br />

					<b>10. Home and Furniture</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Furniture<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bedding<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Vacuums<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Home Furnishings<br />
					<br />

					<b>11. Music </b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - CDs<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Cassettes<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Vinyl<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Guitars<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Instruments<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Recording Equipment<br />
					<br />

					<b>12. Lawn & Garden</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Landscaping Tools<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Pottery<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Outdoor Furniture<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Plants<br />
					<br />

					<b>13. Pet Supplies</b><br />
					<br />

					<b>14. Sports and Outdoor</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Sports Equipment<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bikes<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tents<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Fan Gear<br />
					<br />

					<b>15. Tools & Home Improvement</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Hand & Power Tools<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Plumbing<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Electrical<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Appliance Parts<br />
					<br />

					<b>16. Toys & Games</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Infant & Preschool<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Learning & Exploration Toys<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Action Figures<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Dolls<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Board Games<br />
					<br />

					<b>17. Miscellaneous</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Everything else belongs here!<br />

				</td>
				<td width="50%">
				
					<h4 style="color:#0099ff">Referral Categories:</h4>
					
					<b>1. Automotive</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Auctions<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Consultions<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Dealers<br />
					<br />	
					
					<b>2. Business & Professional Services</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Advertising<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Business Services<br />
						<br />
						
					<b>3. Clothing & Accessories</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Cleaning & Repair<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Wholesale<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Rental<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Stores<br />
						<br />
					
					<b>4. Computers & Electronics</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Consultants<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Graphics & Imaging<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Consumer Electronics<br />
						<br />
					
					<b>5. Construction & Contractors</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Building & Home Construction<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Contractors<br />
						<br />
						
					<b>6. Education</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Early Childhood<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Educational Services<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Elementary & Secondary<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Adult & Continuing Education<br />
						<br />
						
					<b>7. Entertainment</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Arcades & Amusements<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Carnivals, Fairs, & Festivals<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Children's & Family Entertainment<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Clubs & Nightlife<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Movie Theaters<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Performing Arts<br />
						<br />
						
					<b>8. Food & Dining</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bakeries<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bars & Pubs<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Caterers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Fast Food<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Grocery Stores<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Restaurants<br />
						<br />
					
					<b>9. Health & Medicine</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Animal Health<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Clinics & Medical Centers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Dentistry<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Nutrition<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Pharmacies<br />
						<br />
						
					<b>10. Home & Garden</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Cleaning Services<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Domestic Services<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Home Improvement<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Pets & Animals<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Security Systems & Services<br />
						<br />
						
					<b>11. Legal & Financial</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Accountants<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Attorneys<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Insurance<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Investments<br />
						<br />
						
					<b>12. Media & Communications</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Advertising<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Telecommunications<br />
						<br />
						
					<b>13. Online Shopping</b><br />
						<br />
						
					<b>14. Personal Care & Services</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Barbers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Beauty Salons<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Exercise<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Massage & Bodywork<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tanning Salons<br />
						<br />
												
					<b>15. Real Estate</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Agencies<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Apartment & Home Rental<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Rental & Leasing<br />
						<br />
						
					<b>16. Shopping</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Shopping Venues<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Antiques<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Book Stores<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Hobbies<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Flowers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Jewelers<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Malls<br />
						<br />
			
					<b>17. Sports & Recreation</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Parks & Playgrounds<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Sporting Goods<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bowling Alleys<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Campsites<br />
						<br />
					
					<b>18. Travel & Transportation</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Hotels (or Motels :p)<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Air Transportation<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Bus Services<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tours<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Moving and Storage<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Taxi Services<br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Tourist Attractions<br />
						<br />
						
					<b>19. Miscellaneous</b><br />
&nbsp &nbsp &nbsp &nbsp &nbsp - Everything else belongs here!<br />
 						<br />
 						<br />
				</td>
			</tr>
        </table>
       
		</div>
				
			
       

		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>