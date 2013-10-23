<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>YouMIDItube</title>

	<script language="JavaScript" type="text/javascript" src="js/jquery.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/javascript.js"></script>
	<link rel="stylesheet" type="text/css" href="css/youtubewank.css">
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>

</head>
<body>

	<div id="searchBox"></div>
	<div id="essentials">
		<span>Insert Youtube key (http://www.youtube.com/<b>XYZ-ASD</b>)&nbsp; -> &nbsp;</span><input id="youtubekey" type="text" value="007VM8NZxkI">
		<button id="addVideo">add Video</button><br/>
		Or try a Search<input type="text" id="search" onkeypress="return focusOnEnter(event)" >
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


</body>



</html>