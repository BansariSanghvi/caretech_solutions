
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
</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Approval Section------------------>
            <section id="approvals">
    <h2 class="page_title">Approvals</h2>

    <div class="approvals-container">
        <!-- Example Approval Request Box -->
        <div class="approval-request">
            <h3>Equipment Request</h3>
            <p><strong>Requested By:</strong> Dr. John Smith</p>
            <p><strong>Item:</strong> MRI Machine</p>
            <p><strong>Justification:</strong> Replacement of outdated equipment.</p>
            <p><strong>Status:</strong> Pending Approval</p>
            <button class="approve-btn">Approve</button>
            <button class="deny-btn">Deny</button>
        </div>

        <div class="approval-request">
            <h3>Staff Overtime Request</h3>
            <p><strong>Requested By:</strong> Nurse Emily Clarke</p>
            <p><strong>Date:</strong> November 25, 2024</p>
            <p><strong>Hours Requested:</strong> 4 hours</p>
            <p><strong>Status:</strong> Pending Approval</p>
            <button class="approve-btn">Approve</button>
            <button class="deny-btn">Deny</button>
        </div>

        <div class="approval-request">
            <h3>Training Request</h3>
            <p><strong>Requested By:</strong> Technician Robert Davis</p>
            <p><strong>Training Program:</strong> Advanced CPR Training</p>
            <p><strong>Date:</strong> December 10, 2024</p>
            <p><strong>Status:</strong> Pending Approval</p>
            <button class="approve-btn">Approve</button>
            <button class="deny-btn">Deny</button>
        </div>

        
    </div>
</section>



    <script src="assets/js/main.js"></script>
</body>
</html>
