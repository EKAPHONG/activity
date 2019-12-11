<html>
<head>
	<title>Realtime Calendar</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		function getRefresh() {
			$("#auto").show("slow");
			$("#auto").load("stime.php?token="+Math.random(), '', callback);
		}

		function callback() {
			$("#auto").fadeIn("slow");
			setTimeout("getRefresh();", 5000);
		}
		$(document).ready( 
			function(){ 
				getRefresh(); 
			}
			);
		</script>
	</head>

	<body>
		<div id="auto">
		</div>
	</body>
	</html>