<?php
session_start();

$current_page = 'approvals';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
    header('Location: unauthorized.php');
    exit;
}
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
    <title>BranchManager Approval</title>
    <style>
    #approvals {
        padding: 20px;
    }

    .approvals-container {
        display: flex;
        flex-direction: column;
        gap: 20px; 
    }

    .approval-request {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #f9f9f9; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .approval-request h3 {
        margin-top: 0;
    }

    .approve-btn {
        background-color: #4CAF50; 
        color: white;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 5px; 
    }

    .deny-btn {
        background-color: #f44336; 
        color: white;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .approve-btn:hover {
        background-color: #45a049; 
    }

    .deny-btn:hover {
        background-color: #d32f2f; 
    }

    .filter-container {
        display: flex;
        margin-bottom: 20px;
        justify-content: center;
        align-items: center;
        width 100%;
    }

    .filter-container select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
            <?php include("../common/branch_sidebar.php"); ?>
        


<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Approval Section------------------>
            <section id="approvals">
    <h2 class="page_title">Approvals</h2>

    <div class="filter-container">
    <select id="departmentFilter" onchange="filterApprovals()">
        <option value="all">All Departments</option>
        <option value="Cardiology">Cardiology</option>
        <option value="Emergency">Emergency</option>
        <option value="Orthodontics">Orthodontics</option>
        <option value="Rehabilitation">Rehabilitation</option>
    </select>
</div>
    
    <div class="approvals-container">
    <div class="approval-request">
        <h3>Equipment Request</h3>
        <p><strong>Department:</strong> Rehabilitation</p>
        <p><strong>Equipment Name:</strong> MRI Machine</p>
        <p><strong>Quantity:</strong> 1</p>
        <p><strong>Description:</strong> 3T MRI scanner for high-resolution imaging</p>
        <p><strong>Approval Sent Date:</strong> December 1, 2024</p>
        <p><strong>Status:</strong> Waiting Approval</p>
        <button class="approve-btn">Approve</button>
        <button class="deny-btn">Deny</button>
    </div>

    <div class="approval-request">
    <h3>Cardiology Equipment Approval Request</h3>
    <p><strong>Department:</strong> Cardiology</p>
    <p><strong>Equipment Name:</strong> Advanced Cardiac Ultrasound Machine</p>
    <p><strong>Quantity:</strong> 2</p>
    <p><strong>Description:</strong> High-resolution echocardiography system with 4D imaging capabilities and strain analysis</p>
    <p><strong>Approval Sent Date:</strong> December 6, 2024</p>
    <p><strong>Status:</strong> Waiting Approval</p>
    <button class="approve-btn">Approve</button>
    <button class="deny-btn">Deny</button>
</div>

    <div class="approval-request">
        <h3>Equipment Request</h3>
        <p><strong>Department:</strong> Emergency</p>
        <p><strong>Equipment Name:</strong> Surgical Microscope</p>
        <p><strong>Quantity:</strong> 2</p>
        <p><strong>Description:</strong> High-precision microscopes for microsurgery</p>
        <p><strong>Approval Sent Date:</strong> December 5, 2024</p>
        <p><strong>Status:</strong> Waiting Approval</p>
        <button class="approve-btn">Approve</button>
        <button class="deny-btn">Deny</button>
    </div>



</div>
</section>



<script src="assets/js/main.js"></script>
    <script>
        function filterApprovals() {
            var filter = document.getElementById("departmentFilter").value;
            var requests = document.getElementsByClassName("approval-request");

            for (var i = 0; i < requests.length; i++) {
                var department = requests[i].getElementsByTagName("p")[0].innerText;
                if (filter === "all" || department.includes(filter)) {
                    requests[i].style.display = "";
                } else {
                    requests[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
