<?php
// Include the database configuration file
require_once '../includes/config.inc.php';

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$hostelCount = 6; // Number of hostels
$roomsPerHostel = 10; // Number of rooms per hostel

// Initialize an array to store hostel information
$hostelData = array();

// Loop through each hostel
for ($i = 1; $i <= $hostelCount; $i++) {
    // Retrieve the number of occupied rooms for the current hostel
    $occupiedRoomsQuery = "SELECT COUNT(*) AS occupied_rooms FROM room WHERE hostel_id = ? AND allocated = 1";
    $occupiedRoomsStmt = mysqli_prepare($conn, $occupiedRoomsQuery);
    
    // Check if preparing the statement was successful
    if (!$occupiedRoomsStmt) {
        die("Error preparing occupied rooms statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($occupiedRoomsStmt, "i", $i);
    mysqli_stmt_execute($occupiedRoomsStmt);
    mysqli_stmt_bind_result($occupiedRoomsStmt, $occupiedRooms);
    mysqli_stmt_fetch($occupiedRoomsStmt);
    mysqli_stmt_close($occupiedRoomsStmt);

    // Calculate the number of vacant rooms
    $vacantRooms = $roomsPerHostel - $occupiedRooms;

    // Retrieve student names for occupied rooms
    $occupiedRoomsQuery = "SELECT room_id, student_id FROM room WHERE hostel_id = ? AND Allocated = 1";
    $occupiedRoomsStmt = mysqli_prepare($conn, $occupiedRoomsQuery);
    
    // Check if preparing the statement was successful
    if (!$occupiedRoomsStmt) {
        die("Error preparing occupied rooms statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($occupiedRoomsStmt, "i", $i);
    mysqli_stmt_execute($occupiedRoomsStmt);
    mysqli_stmt_bind_result($occupiedRoomsStmt, $roomNo, $studentid);

    $occupiedRoomsData = array();
    // Store occupied rooms data
    while (mysqli_stmt_fetch($occupiedRoomsStmt)) {
        $occupiedRoomsData[] = array(
            'room_id' => $roomNo,
            'student_id' => $studentid
        );
    }

    // Store hostel information
    $hostelData[$i] = array(
        'occupied_rooms' => $occupiedRooms,
        'vacant_rooms' => $vacantRooms,
        'occupied_rooms_data' => $occupiedRoomsData
    );
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Hostel Management</title>
	
	<!-- Meta tag Keywords -->
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
	<!--// Meta tag Keywords -->
		<link href="../web_home/css_home/slider.css" type="text/css" rel="stylesheet" media="all">
	<!-- css files -->
	<link rel="stylesheet" href="../web_home/css_home/bootstrap.css"> <!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="../web_home/css_home/style.css" type="text/css" media="all" /> <!-- Style-CSS --> 
	<link rel="stylesheet" href="../web_home/css_home/fontawesome-all.css"> <!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->
	<link rel="stylesheet" href="../web_home/css_home/flexslider.css" type="text/css" media="screen" property="" />
	<!-- web-fonts -->
	<link href="//fonts.googleapis.com/css?family=Poiret+One&amp;subset=cyrillic,latin-ext" rel="stylesheet">
	<!-- //web-fonts -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px;
            background-color: #000;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        ul {
    list-style-position: inside; /* Place the bullet inside the list item */
}

li {
    text-align: center; /* Align list item text to the left */
    margin-left: 20px; /* Add some space between list items */
}
.navigate-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .navigate-button:hover {
            background-color: #45a049;
        }


    </style>
	
</head>
<body>
    <h2>Hostel Room Information</h2>
    <table border="1">
        <tr>
            <th>Hostel ID</th>
            <th>Occupied Rooms</th>
            <th>Vacant Rooms</th>
            <th>Occupied Room Details</th>
        </tr>
        <?php foreach ($hostelData as $hostelId => $data): ?>
        <tr>
            <td><?php echo $hostelId; ?></td>
            <td><?php echo $data['occupied_rooms']; ?></td>
            <td><?php echo $data['vacant_rooms']; ?></td>
            <td>
                <?php if (!empty($data['occupied_rooms_data'])): ?>
                    <ul>
                        <?php foreach ($data['occupied_rooms_data'] as $room): ?>
                            <li>Room <?php echo $room['room_id']; ?>: <?php echo $room['student_id']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    No occupied rooms
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button onclick="window.location.href = 'room_allocate.php';">New Applications</button>
    <!-- Add your HTML content here -->
    <footer class="py-5">
	<div class="container py-md-5">
		<div class="footer-logo mb-5 text-center">
			<a class="navbar-brand" href="http://www.nie.ac.in/" target="_blank">NIE <span class="display">MYSURU</span></a>
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
						<a href="students.php">Students</a>
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
<!-- footer -->

<!-- js-scripts -->		

	<!-- js -->
	<script type="text/javascript" src="../../web_home/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="../../web_home/js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap --> 
	<!-- //js -->

	<!-- start-smoth-scrolling -->
	<script src="../../web_home/js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="../../web_home/js/move-top.js"></script>
	<script type="text/javascript" src="../../web_home/js/easing.js"></script>
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
