<html>
<head>
	<meta charset="utf-8">
	<title>YouMIDItube</title>
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script language="JavaScript" type="text/javascript" src="js/javascript.js"></script>
	<link rel="stylesheet" type="text/css" href="css/youtubewank.css">


</head>
<body>

	<div id="searchBox"></div>
	<div id="essentials">

		<span>Insert Youtube key (http://www.youtube.com/<b>XYZ-ASD</b>)&nbsp; -> &nbsp;</span><input id="youtubekey" type="text" value="007VM8NZxkI">
		<button id="addVideo">add Video</button><br/>
		Or try a Search<input type="text" id="search" >
		<button id="go">Go</button>
		<br/>

		<button id="playAll">Play All</button>
		<button id="pauseAll">Pause All</button>
		<button id="replayAll">Replay All</button>
	</div>


	<div id="tubes">
	<span id="noAdded">No Videos added</span>
	<table>
	</table>
	</div>
	
	<script>
	google.load("swfobject", "2.2");

	// Because we are using jQuery, the elements can be accessed differently? [TIH]
	$('#addVideo').click(addVideo);
	alert
	$('#go').click(searchClicked);
	
	//Submit on "Return"
	$("#search").keyup(function(event){
    if(event.keyCode == 13){
        $("#go").click();
    }
});
	</script>

</body>



</html>