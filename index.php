<?php
session_start();
$message="";
$captcha=true;
if(count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"])
{
	$captcha = false;
	$message = "Enter Correct Captcha Code";
}

error_reporting(0);
$mysqli = new mysqli('localhost','root','','reg_with_cap');

	$ip=$_SERVER['REMOTE_ADDR'];

	$result = $mysqli->query("SELECT count(ip_address) AS failed_login_attempt FROM failed_login WHERE ip_address = '$ip'  AND date BETWEEN DATE_SUB( NOW() , INTERVAL 1 DAY ) AND NOW()");

	$row  = $result->fetch_array();

	$failed_login_attempt = $row['failed_login_attempt'];
	if(count($_POST)>0 && $captcha== true){
if (isset($_POST['submit'])) 
{
	$email= $_POST['email'];
	$password=$_POST['password'];
	//$email=$mysqli->real_escape_string($email);
	//$password=$mysqli->real_escape_string($password);


	//$result->free();
	
		$result = $mysqli->query("SELECT * FROM user WHERE email='$email'");
		$row = $result->fetch_array();
		$count=$result->num_rows;
		echo $row['password'];
		$result->free();
		//$reshas=password_needs_rehash($row['password'], PASSWORD_DEFAULT);//Problem
		if (password_verify($password, $row['password']) && $count==1) //problem
		{
			$_SESSION['user_id']=$row['id'];
			$mysqli->query("DELETE FROM failed_login WHERE ip_address='$ip'");
			header("Location: user_dashboard.php");
		}
		else
		{
			$message = "Invalid Username or Password!";
			if ($failed_login_attempt < 3) 
			{
				$mysqli->query("INSERT INTO failed_login (ip_address,date) VALUES ('$ip', NOW())");
			} 
			else
			{
				$message = "You have tried more than 3 invalid attempts. ";
			}
		}
	
}	
}


	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>
			Login
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-3">

				</div>
				<div class="col-md-6">
					<?php 
					if ($message !="") 
					{
						echo $message;
					}
					?>
					<form method="post">
						<h2 class="text-center bg-warning mt-2 p-2">Login</h2>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required>
						</div>

						<?php
						if (isset($failed_login_attempt) && $failed_login_attempt>= 3)
						{
							?>
							<div class="d-none">
								<img src="captcha.php">
								<input type="text" name="captcha_code" class="form-control" placeholder="Please Enter the Captcha code">
							</div>

							<?php					
						}
						?>
						<div class="form-group">
							<input type="submit" name="submit" class="form-control btn btn-success">
						</div>
						<a href="registration.php">Create an Account</a>
					</form>
				</div>
				<div class="col-md-3">



				</div>
			</div>
		</div>
	</body>
	</html>