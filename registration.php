
<?php
session_start();
error_reporting(0);
$mysqli = new mysqli('localhost', 'root', '', 'reg_with_cap' );
$message="";
if (isset($_POST['submit'])) 
{
$username=strip_tags($_POST['username']);
$phone=strip_tags($_POST['phone']);
$email=$_POST['email'];
$password=$_POST['password'];

//$username=$mysqli->real_escape_string($username);
//$email=$mysqli->real_escape_string($email);
//$password=$mysqli->real_escape_string($password);

$password=password_hash($password, PASSWORD_DEFAULT);

$captcha_code=$_POST['captcha_code'];
if (  ($_POST['captcha_code'] != $_SESSION['captcha_code']))
 
{
	$message="Enter the correct captcha_code";
}


 	

else
{
	$mysqli->query("INSERT INTO user (username, phone, email, password) VALUES ('$username', '$phone', '$email', '$password')");
 	header("Location: index.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registation</title>
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
						?>
						<div>
							<script type="text/javascript">
								alert("Enter correct captcha_code!");
							</script>
						</div>
					<?php	
					}
				?>
				<form method="post">
					<h2 class="text-center bg-warning mt-2 p-2">Registation</h2>
					<div class="form-group">
						<label>User Name</label>
						<input type="text" name="username" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Phone Number</label>
						<input type="number" name="phone" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email Address</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<img src="captcha.php">
					<div class=" form-group">
						<label>Enter The Code</label>
						<input type="text" name="captcha_code" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="form-control btn btn-success" value="Submit">
					</div>
				</form>
			</div>
			<div class="col-md-3">
				
			</div>
		</div>
	</div>
</body>
</html>
