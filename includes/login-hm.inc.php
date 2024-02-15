<?php

if (isset($_POST['login-submit'])) {

    require 'config.inc.php';

    $username = $_POST['username'];
    $password = $_POST['pwd'];

    if (empty($username) || empty($password)) {
        header("Location: ../login-hostel_manager.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM Hostel_Manager WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            // Compare plaintext password directly
            if ($password == $row['Pwd']) {
                // Passwords match, proceed with login
                session_start();
                $_SESSION['hostel_man_id'] = $row['Hostel_man_id'];
                $_SESSION['fname'] = $row['Fname'];
                $_SESSION['lname'] = $row['Lname'];
                $_SESSION['mob_no'] = $row['Mob_no'];
                $_SESSION['username'] = $row['Username'];
                $_SESSION['hostel_id'] = $row['Hostel_id'];
                $_SESSION['email'] = $row['Email'];
                $_SESSION['isadmin'] = $row['Isadmin'];
                $_SESSION['PSWD'] = $row['Pwd'];

                // Redirect based on user role
                if ($_SESSION['isadmin'] == 0) {
                    header("Location: ../home_manager.php?login=success");
                    exit();
                } else {
                    header("Location: ../admin/admin_home.php?login=success");
                    exit();
                }
            } else {
                // Passwords don't match
                header("Location: ../login-hostel_manager.php?error=wrongpwd");
                exit();
            }
        } else {
            // No user found with the provided username
            header("Location: ../login-hostel_manager.php?error=nouser");
            exit();
        }
    }
} else {
    // Redirect if the form was not submitted
    header("Location: ../login-hostel_manager.php");
    exit();
}
?>
