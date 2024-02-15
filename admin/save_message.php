<?php

session_start(); 

function getAdminIdByUsername($username) {
    // Include the database connection file
    require_once '../includes/config.inc.php';


    // Escape the username to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Query to retrieve admin ID based on username
    $query = "SELECT Hostel_man_id FROM hostel_manager WHERE username = '$username'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the admin ID from the result set
        $row = mysqli_fetch_assoc($result);
        $admin_id = $row['Hostel_man_id'];

        // Free the result set
        mysqli_free_result($result);

        // Close the database connection
        mysqli_close($conn);

        // Return the admin ID
        return $admin_id;
    } else {
        // If query fails or no matching record found, return false or handle error as needed
        return false;
    }
}
// Assuming you have a function to retrieve admin ID from the database based on admin username
// Replace 'getAdminIdByUsername' with your actual function
$admin_username = $_SESSION['username']; // Assuming admin username is stored in session
$admin_id = getAdminIdByUsername($admin_username); // Query admin ID from database

require '../includes/config.inc.php';



// Retrieve form data
$name = $_POST['Name'];
$email = $_POST['Email'];
$usn = $_POST['USN'];
$subject = $_POST['Subject'];
$message = $_POST['Message'];

// Save message to admin_messages table
$sql = "INSERT INTO admin_messages (sender_id, receiver_id, subject, message) VALUES ('$admin_id', '$usn', '$subject', '$message')";
if(mysqli_query($conn, $sql)){
    echo "Message sent successfully.";
} else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Update student's message column
$sql_update = "UPDATE student SET messages = CONCAT(messages, '<br>', '$message') WHERE Student_id = '$usn'";
if(mysqli_query($conn, $sql_update)){
    echo "Student's message column updated successfully.";
} else{
    echo "Error updating student's message column: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
