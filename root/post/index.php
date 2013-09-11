<!DOCTYPE html>
<html>
	<head>
		<title>Post a new something.</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		
		<a href="#bought" id="boughtLink">Bought It</a>
		
		<a href="#spread" id="spreadLink">Spread the Word</a>
		
		<div class="new-post">
		    <a href="#" class="post-close-button">X</a>
		    <div class="title">
		        <div class="title-border">
		            <h3>Post a New Bought It!</h3>
		        </div>
		    </div>
		    
		    
		    <div class="post-menu">
		        <ul>
		            <li><a href="#bought" class="clicked">Bought It!</a></li>
		            <li><a href="#spread">Spread the Word!</a></li>
		        </ul>
		    </div>
		    
		    
		    <div class="post-form">
		        
		        <div id="bought">
		        
		        	<form>
			            <ul>
			                <li><span class="post-info">Tell everyone what you purchased!</span></li>
			                <li><input type="text" name="title"></li>
			                <li><span class="post-info">Tell us about it!</span></li>
			                <li><textarea name="comments"></textarea></li>
			                <li><span class="post-info">Give it a rating</span></li>
			                <li>stars here</li>
			                <li><span class="post-info">Choose a Category</span></li>
			                <li>
	
		                        <select>
		                            <option>One</option>
		                        </select>
			                </li>
			                <li><span class="post-info">Add a Website <a href="#">[optional]</a></span></li>
			                <li><input type="text" value="http://"></li>
			                
			                <li><span class="post-info">Add an Image <a href="#">[optional]</a></span></li>
			                <li><input type="file"></li>
			            </ul>
			        </form>
		        
		        </div>
		        
		        <div id="spread">
		        
		        	<form>
			            <ul>
			                <li><span class="post-info">Name of Business of Service:</span></li>
			                <li><input type="text" name="title"></li>
			                <li><span class="post-info">Share Your Thoughts with Your Friends</span></li>
			                <li><textarea name="comments"></textarea></li>
			                <li><span class="post-info">Give it a rating</span></li>
			                <li>stars here</li>
			                <li><span class="post-info">Choose a Category</span></li>
			                <li>
	
		                        <select>
		                            <option>One</option>
		                        </select>
			                </li>
			                <li><span class="post-info">Add a Website <a href="#">[optional]</a></span></li>
			                <li><input type="text" value="http://"></li>
			                
			                <li><span class="post-info">Add an Image <a href="#">[optional]</a></span></li>
			                <li><input type="file"></li>
			            </ul>
			        </form>
		        
		        </div>
		        
		    </div>
		    <div class="post-bottom">
		    	<ul>
		    		<li><a href="#">Cancel</a></li>
		    		<li><a href="#">Post</a></li>
		    	</ul>
		    </div>
		</div>

		
		
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
		
			(function($){
			
				$('.new-post').newPost({
					boughtLink: '#boughtLink',
					spreadLink: '#spreadLink',
					spread: '#spread',
					bought: '#bought',
				});
			
			}(jQuery));
		
		</script>
	</body>
</html>
