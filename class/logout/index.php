<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- sweetalert -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<title>Đăng xuất</title>
</head>
<body>
	<?php
		session_start();
		session_destroy();
		echo '<script>
					swal("Thành công", "Đăng xuất thành công", "success").then(function(){
					window.location="../../index.php";
					});
					setTimeout(function() {
						window.location = "../../index.php";
					}, 1500);
		  	</script>';
	?>
</body>
</html>


