<?php
  // Include the database connection file and any necessary functions
  // Include the database configuration file
require_once '../includes/config.inc.php';

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

  // Step 1: Retrieve data from student_applications table
  $sql = "SELECT * FROM student_applications";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Step 2: Display data and options
    echo "<table>";
    echo "<tr><th>Application ID</th><th>First Name</th><th>Last Name</th><th>Department</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>".$row['application_id']."</td>";
      echo "<td>".$row['Fname']."</td>";
      echo "<td>".$row['Lname']."</td>";
      echo "<td>".$row['Dept']."</td>";
      echo "<td>";
      echo "<form action='Approve_application.php' method='post'>";
      echo "<input type='hidden' name='student_id' value='".$row['student_id']."'>";
      echo "<input type='hidden' name='fname' value='".$row['Fname']."'>";
      echo "<input type='hidden' name='lname' value='".$row['Lname']."'>";
      echo "<input type='hidden' name='mobile_no' value='".$row['Mob_no']."'>";
      echo "<input type='hidden' name='dept' value='".$row['Dept']."'>";
      echo "<input type='hidden' name='year_of_study' value='".$row['Year_of_study']."'>";
      echo "<input type='submit' name='approve' value='Approve'>";
      echo "<input type='submit' name='reject' value='Reject'>";
      echo "</form>";
      echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No pending applications";
  }
?>
