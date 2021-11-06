<?php 

//Database Connection
include 'config.php';

session_start();

error_reporting(0);

if(isset($_SESSION['username'])) {
    header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
	$server = "p:localhost";
    $user = "root";
    $pass = "root";
    $database = "userregistration";

	$conn = new mysqli($server, $user, $pass, $database, 8889);
	if($conn->connect_error) {
		echo "<script>alert('Unable to connect to database.')</script>";
	}

	$username = $_POST['username'];
	$password = $_POST['password'];

	$stmt = "SELECT * FROM user WHERE username='$username'";
	if($result = $conn->query($stmt)) {
		$objs = $result->fetch_all();
		if(count($objs) > 0) {
			// var_dump($objs[0]);
			if(password_verify($password, $objs[0][1])) {
				$row = $objs[0];
				$_SESSION['username'] = $row[0];
				header("Location: welcome.php");
			} else {
				echo "<script>alert('Username or Password is Incorrect.')</script>";
			}
		} else {
			die('failure');
			echo "<script>alert('Username or Password is Incorrect.')</script>";
		}
	} else {
		echo "<script>alert('SQL Error when querying.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href=https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-register">
			<p class="title-text">Login</p>
			<div class="input-group">
				<input type="username" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn btn-primary">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
		</form>
	</div>
</body>
</html>