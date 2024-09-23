<?php

$conn = mysqli_connect('localhost','root', '' ,'dwos');

@include 'dwos.php';

session_start();

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    // Check if the user already exists
    $select = " SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Passwords do not match!';
        } else {
            // Insert the user with the correct user_type ('O' for Owner)
            $insert = "INSERT INTO users(user_name, email, password, phone_number, address, user_type) 
                       VALUES('$name','$email','$pass','$phone_number','$address', 'C')";
            mysqli_query($conn, $insert);
            header('location: Login/login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="customerregister.css">
</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>Register</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
            <input type="text" name="user_name" required placeholder="Name">
            <input type="email" name="email" required placeholder="E-mail Address">
            <input type="password" name="password" required placeholder="Password">
            <input type="password" name="cpassword" required placeholder="Repeat Password">
            
            <div class="button-container">
                <input type="submit" name="submit" value="Register" class="form-btn">
            </div>

            <p>Already have an account? <a href="login.php">Login here.</a></p>
        </form>
    </div>

</body>

</html>
