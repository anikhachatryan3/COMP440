<?php
session_start();

include 'config.php';

if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}

if(!empty($_POST)) {
    // function initDB() {
    $server = "localhost";
    $user = "root";
    $pass = "root";
    $database = "userregistration";

    // Creating connection
    $conn = new mysqli($server, $user, $pass, $database, 8889);
    // Checking connection
    if ($conn->connect_error) {
        die("Connection failed!");
    }

    //Creating query to delete the user table if it exists
    $deleteTable = "DROP TABLE IF EXISTS `userregistration`.`user`";

    //If the query for deleting the table works:
    if($conn->query($deleteTable) == true) {
        // Create query to create the database again
        $createTable = "CREATE TABLE `userregistration`.`user` ( 
                        `username` VARCHAR(255) NOT NULL , 
                        `password` VARCHAR(255) NOT NULL , 
                        `firstName` VARCHAR(255) NOT NULL , 
                        `lastName` VARCHAR(255) NOT NULL , 
                        `email` VARCHAR(255) NOT NULL , 
                        PRIMARY KEY (`username`), 
                        UNIQUE (`email`)) 
                        ENGINE = InnoDB";



        
        // If the query for creating the table worked:
        if($conn->query($createTable) == true) {
            // Create another query to add the user back into the database
            $addUser = "INSERT INTO `userregistration`.`user`(`username`, `password`, `firstName`, `lastName`, `email`) 
                        VALUES ('comp440','pass1234','Ani','Khachatryan', 'ani@gmail.com')";
            // If the query for adding the user to the database worked:
            if($conn->query($addUser) == true) {
                // Let the user know that the database was successfully initialized
                echo "<script>alert('Successfully Initialized Database!')</script>";
            }
            //Otherwise:
            else {
                // Let the user know that initializing database was unsuccessful
                echo "<script>alert('ERROR: Could not initialize the database!')</script>";
            }
        }
        // Otherwise:
        else {
            // Let the user know that initializing database was unsuccessful
            echo "<script>alert('ERROR: Could not initialize database!')</script>";
        }
    }
    else {
        echo "<script>alert('ERROR: Was not able to initialize database!')</script>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Welcome</title>

    </head>
    <body>
        <?php echo "<h1> Welcome, " . $_SESSION['username']. "</h1>"; ?>
        <br>
        <form method="POST" action="welcome.php">
            <input class="button" type="submit" name="submit" value="Initialize Database">
        </form>
        <br>
        <br>
        <a href="logout.php">Logout</a>
    </body>
</html>