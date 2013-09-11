<link rel="stylesheet" href="http://word-flow.com/test/styles/960.css">
<link rel="stylesheet" href="http://word-flow.com/test/styles/reset.css">
<link rel="stylesheet" href="http://word-flow.com/test/styles/style3.css">
<link href="http://word-flow.com/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if (isset($_SESSION['id'])) { ?>
		<!--[if IE 6]>
			<div class="warning-error">
				<p>You are running on internet 6. We recommend using a newer browser for a greater browsing experience.</p>
			</div>
		<![endif]-->
		<?php
			include_once ("mysql_server/checkuserlog.php");
			$friendAlert = 0;
			$sql = mysql_query("SELECT * FROM `friends_requests` WHERE `mem2` = ".$_SESSION['id']) or die(mysql_error());
			$friendAlert = mysql_num_rows($sql);
			
			$messageAlert = 0;
			$sql2 = mysql_query("SELECT * FROM `messaging` WHERE `to_id` = ".$_SESSION['id']." AND `opened` = '0'") or die(mysql_error());
			$messageAlert = mysql_num_rows($sql2);
		?>
		<div id="header">
			<div class="container_12">
				
				<div class="grid_2">
					<a title="Home" href="http://word-flow.com/home.php">
						<div class="logo"><img src="images/WordofMouthLogo.png"></div>
					</a>
				</div>
				<div class="grid_3">
					<div class="menu">
						<?php if($messageAlert > 0) { ?>
							<span class="message-alert"><?php echo $messageAlert; ?></span>
						<?php } ?>
						<ul>
							<li><a href="http://word-flow.com/friends.php">Members</a></li>
							<li><a href="http://word-flow.com/browse.php">Browse</a></li>
							<!-- NEED LINK TO INBOX PAGE -->
							<li><a href="http://word-flow.com/inbox.php" class="menu-last">Messages</a></li>
						</ul>
					</div>
				</div>
				<div class="grid_4">
					<div class="search">
						<form action="http://word-flow.com/search.php" method="post" enctype="multipart/form-data">
							<ul>
								<li><input type="text" class="search-text" name="search_for" id="search_for" title="Enter Your Search.." placeholder="Enter Your Search.." onkeyup="sz(this);"></li>
								<li>
									<label class="search-label"></label>
								</li>
								<li>
									<select class="search-select" name="search_value" id="search_value">
										<option value="2">All</option>
										<option value="0">Reviews</option>
										<option value="1">Referrals</option>
									</select>
								</li>
								<li><input type="submit" class="search-button" value="Search"></li>
							</ul>
						</form>
					</div>
				</div>
				<div class="grid_3">
					<div class="menu">
						<?php if ($friendAlert > 0) {
						?>
						<span class="friend-alert"><?php echo $friendAlert; ?></span>
						<?php } ?>
						<ul>
							<li><a href="http://word-flow.com/home.php">Home</a></li>
							<li><a href="http://word-flow.com/profile.php">Profile</a></li>
							<li class="last">
								<a href="#" class="menu-last">Account<span class="down-arrow">&#9660;</span></a>
								<ul class="dropdown">
									<li><a href="http://word-flow.com/edit_profile.php">Account Options</a></li>
									<li><a href="http://word-flow.com/redeem.php">Redeem Points</a></li>
									<li><a href="http://word-flow.com/help.php">Help</a></li>
									<li class="last"><a href="http://word-flow.com/logout.php">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php } else { ?>
		<!--[if IE 6]>
			<div class="warning-error">
				<p>You are running on internet 6. We recommend using a newer browser for a greater browsing experience.</p>
			</div>
		<![endif]-->
		<div id="header">
			<div class="container_12">
				
				<div class="grid_2">
					<a title="Home" href="http://word-flow.com/home.php">
						<div class="logo"><img src="images/WordofMouthLogo.png"></div>
					</a>
				</div>

				<div class="grid_3">
					<div class="menu" style=" opacity:0; ">
						<?php if ($friendAlert > 0) {
						?>
						<span class="friend-alert"><?php echo $friendAlert; ?></span>
						<?php } else if ($messageAlert > 0) {
						?>
						<span class="message-alert"><?php echo $messageAlert; ?></span>
						<?php } ?>
						<ul>
							<li><a href="friends.php">Members</a></li>
							<li><a href="browse.php">Browse</a></li>
							<li><a href="inbox.php" class="menu-last">Messages</a></li>
						</ul>
					</div>

				</div>

				<div class="grid_4">
					<div class="search">
						<form action="search.php" method="post" enctype="multipart/form-data">
							<ul>
								<li><input type="text" class="search-text" name="search_for" id="search_for" title="Enter Your Search.." placeholder="Enter Your Search.." onkeyup="sz(this);"></li>
								<li>
									<label class="search-label"></label>
								</li>
								<li>
									<select class="search-select" name="search_value" id="search_value">
										<option value="2">All</option>
										<option value="0">Reviews</option>
										<option value="1">Referrals</option>
									</select>
								</li>
								<li><input type="submit" class="search-button" value="Search"></li>
							</ul>
						</form>
					</div>
				</div>
				<div class="grid_3">
					<div class="menu">
						<ul>
							<li><a href="register.php">Sign Up!</a></li>
							<li><a href="login.php">Login</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>