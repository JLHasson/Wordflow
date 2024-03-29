<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TinySlider - JavaScript Slideshow</title>
<link rel="stylesheet" type="text/css" href="tinyslider2/tiny.css" />
<script type="text/javascript" src="tinyslider2/script.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="container">
		<div class="sliderbutton" id="slideleft" onclick="slideshow.move(-1)"></div>
		<div id="slider">
			<ul>
				<li><img src="tinyslider2/photos/1.jpg" width="435" height="350" alt="Image One" /></li>
				<li><img src="tinyslider2/photos/2.jpg" width="435" height="350" alt="Image Two" /></li>
				<li><img src="tinyslider2/photos/3.jpg" width="435" height="350" alt="Image Three" /></li>
				<li><img src="tinyslider2/photos/4.jpg" width="435" height="350" alt="Image Four" /></li>
			</ul>
		</div>
		<div class="sliderbutton" id="slideright" onclick="slideshow.move(1)"></div>
		<ul id="pagination" class="pagination">
			<li onclick="slideshow.pos(0)"></li>
			<li onclick="slideshow.pos(1)"></li>
			<li onclick="slideshow.pos(2)"></li>
			<li onclick="slideshow.pos(3)"></li>
		</ul>
	</div>
</div>
<script type="text/javascript">
var slideshow=new TINY.slider.slide('slideshow',{
	id:'slider',
	auto:4,
	resume:false,
	vertical:false,
	navid:'pagination',
	activeclass:'current',
	position:0,
	rewind:false,
	elastic:true,
	left:'slideleft',
	right:'slideright'
});
</script>
</body>
</html>