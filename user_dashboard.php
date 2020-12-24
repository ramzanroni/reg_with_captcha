<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Dash Board</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
	<div class="col-md-12 bg-success">
		<?php
		error_reporting(0);
		if ($_SESSION['user_id']) 
		{
			?>

			<p>Welcome to <?php echo $_SESSION["user_id"];?></p>
		
		
		<a class="float-right text-white btn btn-danger" href="logout.php?logout">Logout</a>
				<?php
				}
				?>
	</div>
</body>
</html>