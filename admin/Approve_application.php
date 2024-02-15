<?php
// Include the database configuration file
require_once '../includes/config.inc.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "Approve" button was clicked
    if (isset($_POST["approve"])) {
        // Get data from the form
        $student_id = $_POST["student_id"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $mobile_no = $_POST["mobile_no"];
        $dept = $_POST["dept"];
        $year_of_study = $_POST["year_of_study"];
        
        // Generate a generic password for the user
        $password = generatePassword();
        
        // Insert the user's data into the students table
        // Assuming $password contains the password value
        insertStudent($student_id, $fname, $lname, $mobile_no, $dept, $year_of_study, $password);

        
        // Update the status of the application to approved
        // updateStatus($student_id, "approved");
        
        // Redirect back to the application page
        header("Location: Approve_application.php");
        exit();
    } elseif (isset($_POST["reject"])) {
        // Handle rejection if needed
        // Redirect back to the application page
        header("Location: Approve_application.php");
        exit();
    }
}

function generatePassword($length = 10) {
    // Define the characters that can be used in the password
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_';

    // Get the number of characters in the character set
    $charLength = strlen($chars);

    // Initialize the password variable
    $password = '';

    // Generate random bytes
    $bytes = openssl_random_pseudo_bytes($length);

    // Convert the bytes to hexadecimal representation
    $hex = bin2hex($bytes);

    // Loop through each byte and map it to a character in the character set
    for ($i = 0; $i < $length; $i++) {
        // Get the index of the character in the character set
        $index = hexdec(substr($hex, $i*2, 2)) % $charLength;

        // Append the character to the password
        $password .= $chars[$index];
    }

    // Return the generated password
    return $password;
}

function insertStudent($student_id, $fname, $lname, $mobile_no, $dept, $year_of_study, $password) {
    global $conn; // Access the global connection variable

    // SQL INSERT statement to insert data into the students table
    $sql = "INSERT INTO student (Student_id, Fname, Lname, Mob_no, Dept, Year_of_study, Pwd) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle the error if the SQL statement preparation fails
        die("SQL error: " . mysqli_error($conn));
    } else {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssss", $student_id, $fname, $lname, $mobile_no, $dept, $year_of_study, $password);
        
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        
        // Close the statement
        mysqli_stmt_close($stmt);
    }
}


function updateStatus($student_id, $status) {
    global $conn; // Access the global connection variable

    // SQL UPDATE statement to update the status column in the student_applications table
    $sql = "UPDATE student_applications SET status = ? WHERE student_id = ?";
    
    // Prepare the SQL statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle the error if the SQL statement preparation fails
        die("SQL error: " . mysqli_error($conn));
    } else {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $status, $student_id);
        
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        
        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection after finishing all operations
mysqli_close($conn);
?>
