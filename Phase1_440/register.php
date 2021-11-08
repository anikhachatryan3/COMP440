<?php 

include 'con_db.php';

error_reporting(0);

session_start();

if(isset($_SESSION['username'])){
    header("Location: register.php");
}

if(isset($_POST['submit'])) {
    $server = "p:localhost";
    $user = "root";
    $pass = "root";
    $database = "userregistration";

    $firstName= $_POST['firstName'];
    $lastName= $_POST['lastName'];
    $username= $_POST['username'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $cpassword= $_POST['cpassword'];
    
    if($password == $cpassword){
        $conn = new mysqli($server, $user, $pass, $database, 8889);
        if($conn->connect_error) {
            echo "<script>alert('Unable to connect to database.')</script>";
        }

        $stmt = "SELECT * FROM user WHERE email = '$email' OR username = '$username'";
        if($result = $conn->query($stmt)) {
            $objs = $result->fetch_all();

            // no records found
            if(count($objs) == 0) {
                // Encrypt password
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt = "INSERT INTO user (firstName, lastName, username, email, password)
                        VALUES ('$firstName', '$lastName', '$username', '$email', '$password')";
                if($conn->query($stmt)) {
                    echo "<script>alert('User Successfully Registered.')</script>";
                    $username= "";
                    $email = "";
                    $_POST['password'] = "";
                    $_POST['cpassword'] = "";
                } else {
                    echo "<script>alert('Something went wrong.')</script>";
                }
            } else{
                echo "<script>alert('Email or Username Already Exists.')</script>";
            }
            $result->close(); // free result set          
        } else {
            echo "<script>alert('Something went wrong.')</script>";
        }
    } else{
        echo "<script>alert('Password Does Not Match.')</script>";
    }
}
    
?>
    
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href=https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-register">
            <p class="title-text">Register</p>
            <div class="input-group">
				<input type="text" placeholder="First name" name="firstName" value="<?php echo $firstName; ?>" required>
			</div>
            <div class="input-group">
				<input type="text" placeholder="Last name" name="lastName" value="<?php echo $lastName; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
             <div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn btn-primary">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html> 