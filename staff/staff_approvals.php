<?php
session_start();

$current_page = 'approvals';

// Check if the user is correct
if ($_SESSION['role'] != 'gp') {
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
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Staff Approval</title>
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
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .approval-details {
            margin-bottom: 15px;
            font-size: 14px;
            color: #555;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .approve-btn {
            background-color: #4CAF50; 
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
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

        /* Send Approval Section */
        .send-approval {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f4f4f4;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .send-approval h3 {
            margin-bottom: 15px;
        }

        .send-approval textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
            font-size: 14px;
        }

        .send-approval button {
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .send-approval button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu-------------->
        <?php include("../common/staff_sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/staff_navbar.php"); ?>

            <!------------------Approval Section------------------>
            <section id="approvals">
                <h2 class="page_title">Approvals</h2>
                
                <!-- Send Approval Section -->
                <div class="send-approval">
                    <h3>Send an Approval Request</h3>
                    <form action="process_approval.php" method="POST">
                        <textarea name="approval_request" placeholder="Type your approval request here..." required></textarea>
                        <button type="submit">Send Approval</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
