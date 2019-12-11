<?php
session_start();

if ($_SESSION["account_username"]) {
	session_destroy();
	header("Location: http://service.eng.rmuti.ac.th/eng-login/logout/?id=6&secret=SAMS");
}

else{
	?>

	<p>ออกจากระบบเรียบร้อยแล้ว โปรดรอ <span id="counter">5</span> วินาที</p>
	<!-- <script type="text/javascript">
		function countdown() {
			var i = document.getElementById('counter');
			if (parseInt(i.innerHTML)<=0) {
				location.href = '../';
			}
			i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },1000);
	</script> -->
	<?php
	header("Location: ../index.php");
}
?>