<?php

if (isset($_POST['signup-submit'])) {

  require 'config.inc.php';

  $roll = $_POST['student_roll_no'];
  $fname = $_POST['student_fname'];
  $lname = $_POST['student_lname'];
  $mobile = $_POST['mobile_no'];
  $dept = $_POST['department'];
  $year = $_POST['year_of_study'];
  $hostel_name = $_POST['hostel_name'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$roll)){
    header("Location: ../apply_hostel.php?error=invalidroll");
    exit();
  }
  else {

    $sql = "SELECT Student_id FROM Student WHERE Student_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../apply_hostel.php?error=sql1error");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $roll);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../apply_hostel?error=userexists");
        exit();
      }
      else {
        $sql = "INSERT INTO student_applications (student_id,Dept,Fname, hostel_name, Lname, Mob_no, Year_of_study) VALUES ( ?,?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../apply_hostel?error=sql2error");
          exit();
        }
        else {

        //   mysqli_stmt_bind_param($stmt, "sssssss",$roll, $dept,$fname, $lname, $mobile, $dept, $year, $hostel_name);
          mysqli_stmt_bind_param($stmt, "sssssss", $roll, $dept, $fname, $hostel_name, $lname, $mobile, $year);

          mysqli_stmt_execute($stmt);
          header("Location: ../apply_hostel?signup=success");
          exit();
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  header("Location: ../apply_hostel");
  exit();
}
