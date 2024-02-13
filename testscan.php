<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<style type="text/css">
		.copyr{text-align: center; font-family: Vernada, Geneva, sans-serif; font-size: 11px}
		#mycanvas{width: 500px; height: 500px; border: solid 2px #ccc; padding: 10px;}
	
	
	</style>
</head>

<body>
	<canvas id="mycanvas"></canvas><br>
	<button id="btnScan">Scan Now!</button>
	
 
	<script src="http://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	
	<script type="text/javascript" src="qr-js/dw-qrscan.js"></script>
<script type="text/javascript" src="qr-js/jsQR.js"></script>

	<script>
	
	
	DWTQR("mycanvas");
		$("#btnScan").click(function(){
			dwStartScan();
					
		});
		function dwQRReader(data){
			alert(data);
		}
	
	</script>
	
</body>
</html>
