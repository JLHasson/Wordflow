<script type="text/javascript">
var MYAPP = {};
		MYAPP.flag = true;
		MYAPP.filterFlag = false;
		 $(window).scroll(function() {
			if (MYAPP.filterFlag === false) {
				if($(window).scrollTop() == $(document).height() - $(window).height()) {
					MYAPP.filterFlag = true;
					$("div#text").hide();
					$("div#load_more_posts").show();
					$("div#load_more_posts").text("hello world");
						$.ajax( {
							url: "../../include/load_more_filter.php?lastPost=" + $(".filterBy:last").attr("id") + "&filter="+ <?php echo $_GET['select'];?>,
							success: function(html) {
								if(html) {
									$("#append").append(html);
									$("div#load_more_posts").hide();
									MYAPP.filterFlag = false;
									$("div#text").hide();
								} else {
									$("div#box").replaceWith("<div class="box"><div id="finished"><center>Finished loading all Posts!</center></div></div>");
								}
							}
					});
				
			}
			}
		 });
			$("div#text").click(function(){
			MYAPP.filterFlag = true;
			MYAPP.flag = true;
					$("div#text").hide();
					$("div#load_more_posts").show();
						$.ajax( {
							url: "../../include/load_more_posts.php?lastPost=" + $(".filterBy:last").attr("id"),
							success: function(html) {
								if(html) {
									$("#append").append(html);
									$("div#load_more_posts").hide();
									MYAPP.filterFlag = false;
									$("div#text").show();
								} else {
									$("div#box").replaceWith("<div class="box"><div id="finished"><center>Finished loading all Posts!</center></div></div>");
								}
							}
					});
			});
</script>