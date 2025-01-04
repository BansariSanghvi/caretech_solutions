<?php
session_start();

$current_page = 'dashboard';

// Check if the user is a branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}

include dirname(__DIR__) . "../connection/connection.php";

$dbConnect = new DBConnect();
$conn = $dbConnect->connect();

// Fetch Total Staff
$staffQuery = "SELECT COUNT(*) AS total FROM staff_records";
$staffStmt = $conn->query($staffQuery);
$totalStaff = $staffStmt->fetchColumn();

// Fetch Total appointments
$appointmentsQuery = "SELECT COUNT(*) AS total FROM appointments";
$appointmentsStmt = $conn->query($appointmentsQuery);
$totalAppointments = $appointmentsStmt->fetchColumn();

// Fetch Total Patients
$patientsQuery = "SELECT COUNT(*) AS total FROM patient_records";
$patientsStmt = $conn->query($patientsQuery);
$totalPatients = $patientsStmt->fetchColumn();

// Fetch Total Referrals
$referralsQuery = "SELECT COUNT(*) AS total FROM referral_form WHERE isViewed = 'Pending'";
$referralsStmt = $conn->query($referralsQuery);
$totalReferrals = $referralsStmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>BranchManager Dashboard</title>
    <style>
        /* General Styles */
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 0;
            justify-content: space-between;
        }

        .count-box {
            background-color: #ffffff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 120px; /* Fixed height for uniform size */
            width: 265px;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */ 
        }

        .count-box:hover {
            transform: translateY(-5px); 
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
        }

        .count-box h5 i {
            font-size: 24px;
            color: #4a90e2; 
            margin-right: 8px;
            vertical-align: middle;
        }

        .count-box h5 {
            font-size: 18px;
            color: #333; 
            font-weight: 600;
            margin-bottom: 10px;
        }

        .count-box h6 {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60; 
        }

        /* Quick Actions Styles */
        .card-header {
            background-color: #063478;
            color: white;
            text-align: center;
            font-weight: bold;
            width: 1150px;
            height: 30px;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            height: 80px;
            padding: 10px;
            justify-content: space-between;
            background-color: white;
        }

        /* Quick Action Buttons */
        .big-button {
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: none;
            box-shadow: none;
            padding: 10px 20px;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        .big-button:hover {
            transform: scale(1.05);
            background-color: #f1f1f1;
        }

        /* Button Icon Styling */
        .big-button i {
            margin-right: 8px;
            font-size: 20px;
        }

        
        .graph-container {
            display: flex;
            justify-content: space-between; 
			gap :20px; 
			margin-top :20px; 
			margin-left :33px; 
			margin-right :33px; 
			height :400px; 
		}

		.graph-container .graph { 
			flex :1; 
			background-color :#fff; 
			padding :20px; 
			border-radius :8px; 
			box-shadow :0px 4px 8px rgba(0, 0, 0, 0.1); 
			height :100%; 
		} 

		canvas { 
			width :100% !important; 
			height :100% !important; 
		}

		.announcements-container { 
			margin-top :20px; 
			padding :0 33px; 
		}

		.announcements-box { 
			background-color :#fff; 
			border-radius :8px; 
			box-shadow :0px 4px 8px rgba(0, 0, 0, 0.1); 
			padding :20px; 
		}

		.announcements-box h3 { 
			margin-bottom :15px; 
			color :#063478; 
		}

		#announcements-list { 
			max-height :200px; 
			overflow-y :auto; 
			margin-bottom :15px; 
		}

		.announcement { 
			background-color :#f8f9fa; 
			border-left :4px solid #4a90e2; 
			padding :10px; 
			margin-bottom :10px; 
		}

		.announcement p { margin :0; }
		
		.announcement .timestamp { font-size :.8em;color:#6c757d;}

        #announcement-form textarea { width :100%;padding :10px;margin-bottom :10px;border :1px solid #ced4da;border-radius :4px;resize :vertical;}

        #announcement-form button { background-color:#063478;color:white;border:none;padding :10px 20 px;border-radius :4 px;cursor:pointer;transition:bg-color:.3s;}

        #announcement-form button:hover { background-color:#0056b3;}
        
    </style>  
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
      <?php include dirname(__DIR__) . "../common/branch_sidebar.php"; ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php include dirname(__DIR__) . "../common/branch_navbar.php"; ?>
<!------------------Dashboard Section------------------>

<div class="inside-content">
    <section class="dashboard_section" id="dashboard">
        <h2 class="page_title">Dashboard:</h2>
        
        <!-- Top Metrics -->
        <div class="container-fluid">
           <div class="row">

                <!-- Box for Total Staff -->
                <div class="col-md-3">
                    <div class="count-box">
                        <h5><i class='bx bx-street-view'></i>Total Staff</h5>
                        <h6><?php echo htmlspecialchars($totalStaff); ?></h6>
                    </div>
                </div>

                <!-- Box for Total Referrals -->
                <div class="col-md-3">
                    <div class="count-box">
                        <h5><i class='bx bx-clipboard'></i>Total Referrals</h5>
                        <h6><?php echo htmlspecialchars($totalReferrals); ?></h6>
                    </div>
                </div>

                <!-- Box for Total Patients -->
                <div class="col-md-3">
                    <div class="count-box">
                        <h5><i class="ri-user-fill"></i>Total Patients</h5>
                        <h6><?php echo htmlspecialchars($totalPatients); ?></h6>
                    </div>
                </div>

                <!-- Box for Total Appointments -->
                <div class="col-md-3">
                    <div class="count-box">
                        <h5><i class="ri-add-box-fill"></i>Total Appointments</h5>
                        <h6><?php echo htmlspecialchars($totalAppointments); ?></h6>
                    </div>
                </div>
           </div>
       </div>

       <!-- Announcements Box -->
       <div class="announcements-container">
           <div class="announcements-box">
               <h3>Announcements</h3>
           </div>
           <form id="announcement-form">
               <textarea id="announcement-text" placeholder="Type your announcement here..." required></textarea>
               <button type="submit">Post Announcement</button>
           </form>
       </div>

       <!-- Graphs Split into Two Equal Parts -->
       <div class="graph-container">
           <!-- Left Graph -->
           <div class="graph">
               <h5>Appointments per Month</h5>
               <canvas id="appointmentsBarChart"></canvas>
           </div>

           <!-- Right Graph -->
           <div class="graph">
               <h5>Revenue per Quarter (Branch)</h5>
               <canvas id="revenueLineChart"></canvas>
           </div>
       </div>

   </section>
</div>

</body>

<!-- Scripts for Charts and AJAX -->
<script>
// Bar Chart for Appointments per Month
const ctxBar = document.getElementById('appointmentsBarChart').getContext('2d');
const appointmentsBarChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels:['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets:[{
          label:'Appointments',
          data:[120,150,180,130,160,200,170,190,210,180,160,150],
          backgroundColor:'#4e73df',
          borderColor:'#4e73df',
          borderWidth:1
      }]
    },
    options:{
      responsive:true,
      scales:{
          y:{
              beginAtZero:true
          }
      }
    }
});

// Line Chart for Revenue per Quarter
const ctxLine = document.getElementById('revenueLineChart').getContext('2d');
const revenueLineChart = new Chart(ctxLine,{
    type:'line',
    data:{
      labels:['Q1','Q2','Q3','Q4'],
      datasets:[{
          label:'Revenue',
          data:[10000,5000,20000,25000],
          fill:false,
          borderColor:'rgba(255,99,132,1)',
          borderWidth:2,
          tension:.4
      }]
    },
    options:{
      responsive:true,
      maintainAspectRatio:true,
      scales:{
          y:{
              beginAtZero:true
          }
      }
    }
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
// AJAX for posting announcements
$(document).ready(function() {
    $('#announcement-form').submit(function(e) {
        e.preventDefault();
        
        var announcementText = $('#announcement-text').val();
        
        $.ajax({
             url:'post_announcement.php',
             type:'POST',
             data:{ announcement_text : announcementText },
             dataType:'json',
             success:function(response){
                 if(response.status === 'success'){
                     $('#announcement-text').val('');
                     alert(response.message);
                 }else{
                     alert(response.message);
                 }
             },
             error:function(){
                 alert('An error occurred while posting the announcement.');
             }
         });
     });
});
</script>

</html>

