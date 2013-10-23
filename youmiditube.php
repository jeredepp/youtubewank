<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>YouMIDItube</title>
<script language="JavaScript" type="text/javascript" src="js/jquery.js"></script>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
google.load("swfobject", "2.2");
</script>    
<style>
.clear {clear:both;}
.videoElement {width:500px;background-color:red;}
.replay {display:none;}
.pause {display:none;}
#searchBox {display:none;margin-top:90px;}
.play, .replay, .pause {width:70px;}
#noAdded {font-size:30px;font-weight:bold;color:red;}
#essentials {position:fixed;top:0px;left:0px;width:100%;height:90px;background-color:white;}
#tubes {margin-top:90px;}
table {width:100%;}
button {height:30px;}
input {height:17px;}
</style>
<script>

</script>
</head>
<body>

<div id="searchBox"></div>
<div id="essentials">
<span>Insert Youtube key (http://www.youtube.com/<b>XYZ-ASD</b>)&nbsp; -> &nbsp;</span><input id="youtubekey" type="text" value="007VM8NZxkI">
<button id="addVideo">add Video</button><br/>
Or try a Search<input type="text" id="search"><button id="go">Go</button><br/>

<button id="playAll">Play All</button>
<button id="pauseAll">Pause All</button>
<button id="replayAll">Replay All</button>
</div>


<div id="tubes">
<span id="noAdded">No Videos added</span>
<table>
</table>
</div> 


</body>


<script>
$('#addVideo').click(addVideo);
$('#go').click(searchClicked);

function addVideo(){
	$('#noAdded').hide();
	var key = $('#youtubekey').val();
	if(key){addVideoProcedure(key);}
}





function onYouTubePlayerReady(playerId) { 
	handler = document.getElementById(playerId);
	
	window["onPlayerStateChange_"+playerId] = function(newState)
	{
		var currentVideo = $('#'+playerId).parent().parent();
		handler = document.getElementById(playerId);
		switch(newState){
			//not started
		case(-1):
			currentVideo.css('background-color','red');
			break;
			//playing
		case(1):
			console.log('playing');
			currentVideo.find('.play').hide();
			currentVideo.find('.pause').show();
			currentVideo.css('background-color','green');
			if(currentVideo.find('.repeatFromTo').is(':checked')){
				currentVideo.css('background-color','blue');
				i = 0;
				var start = currentVideo.find('.tFrom').val();
				var stop = currentVideo.find('.tTo').val();
				var interval = setInterval(function(){
						end=false;
						currentTime = handler.getCurrentTime();
						console.log(currentTime);
						currentVideo.css('background-color','blue');
						currentVideo.find('.pause').click(function(){
								currentVideo.css('background-color','yellow');
								clearInterval(interval);
						});
						if(currentTime > stop){handler.seekTo(start);}
						if(currentTime < start){handler.seekTo(start);}
				}, 500);
			};
			break;
			//paused
		case(2):
			console.log('paused');
			currentVideo.find('.pause').hide();
			currentVideo.find('.play').show();
			currentVideo.css('background-color','yellow');
			break;
			//buffering
		case(3):
			console.log('buffering');
			currentVideo.css('background-color','orange');
			break;
			//ended
		case(0):
			console.log('ended');
			currentVideo.find('.pause').hide();
			currentVideo.find('.play').show();
			if(currentVideo.find('.repeat').is(':checked')){handler.seekTo(0);};
			if(currentVideo.find('.autoremove').is(':checked')){currentVideo.remove();};
			currentVideo.css('background-color','black');
			break;
			default: console.log(newState);
		}
	};
	
	handler.addEventListener('onStateChange', 'onPlayerStateChange_'+playerId);
}    



function getVideoObject(that){
	var id = that.parent().parent().find('object').attr('id');
	var handler = document.getElementById(id);
	return handler;
}

function getAllVideosOnPage(){
	var allElements = $('#tubes object');
	return allElements;
}

function setVideoVolume(handler, volume){
	handler.setVolume(volume);
}

function checkForAutoFunction(playerId){
	var handler = document.getElementById(playerId);
	var theHolyRow = handler.parent();
	console.log(playerId);
}

function addVideoProcedure(key){
	$("#addVideo").attr("disabled", "disabled");
	window.timestamp = new Date().getTime();
	$('#tubes table').append("<tr class='videoElement'><td><div id='"+window.timestamp+"'></div></td>"+
		"<td><button class='play'>PLAY</button>"+
		"<button class='pause'>PAUSE</button>"+
		"<button class='replay'>REPLAY</button>"+
		"<input type='text' class='volume' size='2' max-lenght='3'><button class='vol'>Adjust Volume</button>"+
		//"<button class='percent'>DEBUG!</button>"+
		"</td><td>"+
		"<p><input type='checkbox' class='repeat'>Repeat</p>"+
		"<p><input type='checkbox' class='autoremove'>Autoremove</p>"+
		"<p><input type='checkbox' class='repeatFromTo'>Repeat from <input type='text' class='tFrom'>to <input type='text' class='tTo'></p>"+
		"</td>"+
		"<td><button class='delete'>DELETE</button></td>"+
		"</tr>");
	updateHandlers();
	var params = { allowScriptAccess: "always" };
	var atts = { id: window.timestamp };
	swfobject.embedSWF("http://www.youtube.com/apiplayer?&enablejsapi=1&playerapiid="+window.timestamp+"&video_id="+key+"&version=3",window.timestamp, "100", "100", "8", null, null, params, atts);
	setTimeout(function () { 
			$("#addVideo").removeAttr("disabled"); 
	}, 1000);
}

function searchClicked()
{
	$('#searchBox').show();
	document.getElementById("searchBox").innerHTML = 
	'Loading YouTube videos ...';
	
	//create a JavaScript element that returns our JSON data.
	var script = document.createElement('script');
	var searchTerm = $('#search').val();
	script.setAttribute('id', 'jsonScript');
	script.setAttribute('type', 'text/javascript');
	script.setAttribute('src', 'http://gdata.youtube.com/feeds/' + 
		'videos?vq='+searchTerm+'&max-results=18&' + 
		'alt=json-in-script&callback=showMyVideos&' + 
		'orderby=relevance&sortorder=descending&format=5&fmt=18');
	
	//attach script to current page -  this will submit asynchronous
	//search request, and when the results come back callback 
	//function showMyVideos(data) is called and the results passed to it
	document.documentElement.firstChild.appendChild(script);
}

function showMyVideos(data)
{
	var feed = data.feed;
	var entries = feed.entry || [];
	var html = ['<ul>'];
	for (var i = 0; i < entries.length; i++)
	{
		var entry = entries[i];
		var playCount = entry.yt$statistics.viewCount.valueOf() + ' views';
		var title = entry.title.$t;
		//ZC9S8-HMkAs&feature=youtube_gdata
		key = entry.link[0].href.replace("http://www.youtube.com/watch?v=", "");
		key = key.replace("&feature=youtube_gdata","");
        
		
		var element = '<span id="' + key + '">' + title + '</span>';
		html.push('<li class="addSearchedVideo">', element, '</li>');
	}
	html.push('</ul>');
	document.getElementById('searchBox').innerHTML = html.join('');
	
	updateHandlers();
}

function updateHandlers(){
	$('.videoElement').click(function(){
	});
	
	$('.play').click(function(){
			$(this).hide();
			$(this).parent().find('.replay').show();
			$(this).parent().find('.pause').show();
			handler = getVideoObject($(this));
			if($(this).parent().find('.volume').val())setVideoVolume(handler, $(this).parent().find('.volume').val());
			handler.playVideo();
	});
	
	$('.replay').click(function(){
			handler = getVideoObject($(this));
			handler.seekTo(0);
			handler.playVideo();
	});
	
	$('.pause').click(function(){
			$(this).parent().find('.pause').hide();
			$(this).parent().find('.play').show();
			handler = getVideoObject($(this));
			handler.pauseVideo();
	});
	
	$('.percent').click(function(){
			checkForAutoFunction($(this));
	});
	
	$('#playAll').click(function(){
			var videoArray = getAllVideosOnPage();
			$('.play').hide();
			$('.replay').show();
			$('.pause').show();
			$.each(videoArray, function(index, value) {
					handler = document.getElementById(value.id);
					handler.playVideo();
			});
	});
	
	$('#pauseAll').click(function(){
			var videoArray = getAllVideosOnPage();	
			$('.play').show();
			$('.replay').show();
			$('.pause').hide();
			$.each(videoArray, function(index, value) {
					handler = document.getElementById(value.id);
					handler.pauseVideo();
			});
	});
	
	$('#replayAll').click(function(){
			var videoArray = getAllVideosOnPage();	
			$.each(videoArray, function(index, value) {
					handler = document.getElementById(value.id);
					handler.seekTo(0);
					handler.playVideo();
			});
	});
	
	$('.delete').click(function(){
			handler = $(this).parent().parent();
			handler.remove();
	});
	
	$('.vol').click(function(){
			handler = getVideoObject($(this));
			var volumeVal = $(this).parent().find('.volume').val();
			if(volumeVal>100){
				volumeVal=100;
			}else if(volumeVal<0){
				volumeVal=0;
			}
			setVideoVolume(handler, volumeVal);
	});
	
	$('.addSearchedVideo').click(function(){
			addVideoProcedure($(this).find('span').attr('id'));
			$('#searchBox').hide();
			$('#noAdded').hide();
	});
}

</script>


</html>


