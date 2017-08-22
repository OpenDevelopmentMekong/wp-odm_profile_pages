
$(document).ready(function(){
	$(".ytplayer_title").click(function(event){
		var youtubeimg = $(this).find("img");
		var youtubeid = youtubeimg.attr("src").match(/[\w\-]{11,}/)[0];
		$("#vid_frame").attr({
				src: "https://www.youtube.com/embed/" + youtubeid+"?autoplay=1&rel=0&amp;showinfo=1&amp;autohide=0",
		});
	});

	// Hectares
	$(".selected_img_ha").show();
	$('.graph_options').each(function(column)
	{
		$(this).click(function(event)
		{
			if (this == event.target)
			{
				var selected_id = $(this).attr("id");
				$(".selected_option_ha").attr("src","https://opendevelopmentcambodia.net/wp-content/uploads/sites/2/2016/01/option.png");
				$("#"+selected_id).attr("src","https://opendevelopmentcambodia.net/wp-content/uploads/sites/2/2016/01/selected.png");
				$(".graph_options").removeClass("selected_option_ha")
				$("#"+selected_id).addClass("selected_option_ha");

				var g_year = selected_id.substr(14, 25);
				var graph_year = "fc_"+g_year;
				$(".fc_graph").fadeOut();
				$(".fc_graph").removeClass("selected_img_ha");
				$("."+graph_year).fadeIn();
				$("."+graph_year).addClass("selected_img_ha");
			}
		});
	});

	// Percentage
	$(".selected_img_per").show();
	$('.graph_options_per').each(function(column)
	{
		$(this).click(function(event)
		{
			if (this == event.target)
			{
				var selected_id = $(this).attr("id");
				$(".selected_option_per").attr("src","https://opendevelopmentcambodia.net/wp-content/uploads/sites/2/2016/01/option.png");
				$("#"+selected_id).attr("src","https://opendevelopmentcambodia.net/wp-content/uploads/sites/2/2016/01/selected.png");
				$(".graph_options_per").removeClass("selected_option_per")
				$("#"+selected_id).addClass("selected_option_per");

				var g_year = selected_id.substr(18, 28);

				var graph_year = "fc_per_"+g_year;
				$(".fc_graph_per").fadeOut();
				$(".fc_graph_per").removeClass("selected_img_per");
				$("."+graph_year).fadeIn();
				$("."+graph_year).addClass("selected_img_per");
			}
		});
	});
});
