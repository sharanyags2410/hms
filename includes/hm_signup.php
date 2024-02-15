<?php

if (isset($_POST['hm_signup_submit'])) {

  require 'config.inc.php';
  $manager_id = $_POST['hm_man_id'];
  $username= $_POST['hm_uname'];
  $fname = $_POST['hm_fname'];
  $lname = $_POST['hm_lname'];
  $mobile = $_POST['hm_mobile'];
  $hostel_name = $_POST['hostel_name'];
  $email = $_POST['Email'];
  $password = $_POST['pass'];
  $cnfpassword = $_POST['confpass'];

  // Validate username format
  if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
    header("Location: ../admin/create_hm.php?error=invalidusername");
    exit();
  }
  // Check if passwords match
  elseif($password !== $cnfpassword){
    header("Location: ../admin/create_hm.php?error=passwordcheck");
    exit();
  }
  else {
    // Check if username already exists
    $sql = "SELECT Username FROM Hostel_Manager WHERE Username=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../admin/create_hm.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../admin/create_hm.php?error=userexists");
        exit();
      }
      else {
        // Hash the password
        //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        // Retrieve Hostel ID from the hostel name
        $sql = "SELECT * FROM hostel WHERE Hostel_name = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $hostel_name);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if($row = mysqli_fetch_assoc($result)){
            $HostelID = $row['Hostel_id'];
            $isadmin = 0;
            // Insert the new hostel manager into the database
            $sql = "INSERT INTO hostel_manager (Hostel_man_id,Username, Fname, Lname, Mob_no, Hostel_id, Pwd, Isadmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt, $sql)){
              mysqli_stmt_bind_param($stmt, "sssssssi",$manager_id, $username, $fname, $lname, $mobile, $HostelID, $password, $isadmin);
              mysqli_stmt_execute($stmt);
              header("Location: ../admin/create_hm.php?added=success");
              exit();
            }
            else {
              // header("Location: ../admin/create_hm.php?added=failure");
              header("Location: ../admin/create_hm.php?added=failure&error=" . mysqli_error($conn));
              exit();
            }
          }
          else {
            header("Location: ../admin/create_hm.php?error=nohostel");
            exit();
          }
        }
        else {
          header("Location: ../admin/create_hm.php?error=sqlerror");
          exit();
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../admin/create_hm.php");
  exit();
}
?>

