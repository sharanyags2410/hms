<?php
require_once '../includes/config.inc.php';


// Check if hostel manager ID is set in the session
// if (!isset($_SESSION['Hostel_man_id'])) {
//     // Handle the case when hostel manager is not logged in
//     // You can redirect to a login page or display an error message
//     exit("Hostel manager is not logged in.");
    
// }

// Retrieve the hostel manager ID from the session
$hostel_manager_id = '4';

// Retrieve messages for the hostel manager
$query = "SELECT * FROM message WHERE receiver_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $hostel_manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        // Check if there are messages
        if (mysqli_num_rows($result) > 0) {
            // Loop through each message
            while ($row = mysqli_fetch_assoc($result)) {
                // Access message details and display/process them as needed
                $sender_id = $row['sender_id'];
                $message = $row['message'];
                // Display or process the message details as needed
                echo "<div class='message'>";
                echo "<strong>Sender ID:</strong> $sender_id <br>";
                echo "<strong>Message:</strong> $message <br>";
                echo "</div>";
            }
        } else {
            // Handle case when no messages are found
            echo "No messages found.";
        }
    } else {
        // Handle query error
        echo "Error executing query: " . mysqli_error($conn);
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle statement preparation error
    echo "Error preparing statement: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hostel Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Intrend Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
    <!-- Add your CSS stylesheets here -->
    <link href="../web_home/css_home/slider.css" type="text/css" rel="stylesheet" media="all">

	<!-- css files -->
	<link rel="stylesheet" href="../web_home/css_home/bootstrap.css"> <!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="../web_home/css_home/style.css" type="text/css" media="all" /> <!-- Style-CSS -->
	<link rel="stylesheet" href="../web_home/css_home/fontawesome-all.css"> <!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->

	<!-- testimonials css -->
	<link rel="stylesheet" href="../web_home/css_home/flexslider.css" type="text/css" media="screen" property="" /><!-- flexslider css -->
	<!-- //testimonials css -->

	<!-- web-fonts -->
	<link href="//fonts.googleapis.com/css?family=Poiret+One&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    <style>
        /* Add your CSS styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #000;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .message {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        

    </style>
</head>
<body>

<footer class="py-5 " >
	<div class="container py-md-5">
		<div class="footer-logo mb-5 text-center">
			<a class="navbar-brand" href="http://www.nie.ac.in/" target="_blank">NIE<span class="display"> MYSURU</span></a>
		</div>
		<div class="footer-grid">
			
			<div class="list-footer">
				<ul class="footer-nav text-center">
					<li>
						<a href="admin_home.php">Home</a>
					</li>
					
					<li>
						<a href="create_hm.php">Appoint</a>
					</li>
					<li>
						<a href="students.php">Student</a>
					</li>
					<li>
						<a href="admin_contact.php">Contact</a>
					</li>
					<li>
						<a href="student_messages.php">Messages</a>
					</li>
					<li>
						<a href="admin_profile.php">Profile</a>
					</li>
				</ul>
			</div>
			
		</div>
	</div>
</footer>
<script type="text/javascript" src="../web_home/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="../web_home/js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap -->
	<!-- //js -->

	<!-- banner js -->
	<script src="../web_home/js/snap.svg-min.js"></script>
	<script src="../web_home/js/main.js"></script> <!-- Resource jQuery -->
	<!-- //banner js -->

	<!-- flexSlider --><!-- for testimonials -->
	<script defer src="../web_home/js/jquery.flexslider.js"></script>
	<script type="text/javascript">
		$(window).load(function(){
		  $('.flexslider').flexslider({
			animation: "slide",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		  });
		});
	</script>
	<!-- //flexSlider --><!-- for testimonials -->

	<!-- start-smoth-scrolling -->
	<script src="../web_home/js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="../web_home/js/move-top.js"></script>
	<script type="text/javascript" src="../web_home/js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
		});
	</script>
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear'
				};
			*/

			$().UItoTop({ easingType: 'easeOutQuart' });

			});
	</script>
	<!-- //here ends scrolling icon -->
	<!-- start-smoth-scrolling -->

<!-- //js-scripts -->

</body>


</html>

