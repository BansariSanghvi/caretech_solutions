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

        .send-approval select,
        .send-approval input,
        .send-approval textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
                <h2 class="page_title">Equipment Requests</h2>
                
                <!-- Send Approval Section -->
                <div class="send-approval">
                    <h3>Send an Approval Request</h3>
                    <form action="process_approval.php" method="POST">
                        <!-- Department Selection -->
                        <label for="department">Select Department:</label>
                        <select id="department" name="department" required>
                            <option value="" disabled selected>-- Select Department --</option>
                            <option value="Emergency">Emergency</option>
                            <option value="ICU">ICU</option>
                            <option value="Radiology">Radiology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Oncology">Oncology</option>
                        </select>

                        <!-- Staff Selection -->
                        <label for="staff">Select Staff Name:</label>
                        <select id="staff" name="staff" required>
                            <option value="" disabled selected>-- Select Staff Name --</option>
                            <option value="Dr. Smith">Dr. Smith</option>
                            <option value="Nurse Johnson">Nurse Johnson</option>
                            <option value="Technician Lee">Technician Lee</option>
                            <option value="Dr. Patel">Dr. Patel</option>
                        </select>

                        <!-- Equipment Selection -->
                        <label for="equipment">Select Equipment:</label>
                        <select id="equipment" name="equipment" required>
                            <option value="" disabled selected>-- Select Equipment --</option>
                            <option value="Ventilator">Ventilator</option>
                            <option value="Defibrillator">Defibrillator</option>
                            <option value="Syringe Pump">Syringe Pump</option>
                            <option value="ECG Machine">ECG Machine</option>
                            <option value="Ultrasound Machine">Ultrasound Machine</option>
                        </select>

                        <!-- Quantity Input -->
                        <label for="quantity">Quantity Requested:</label>
                        <input type="number" id="quantity" name="quantity" min="1" placeholder="Enter quantity" required>

                        <!-- Comments Section -->
                        <label for="comments">Additional Comments:</label>
                        <textarea id="comments" name="comments" rows="4" placeholder="Type your comments or details here..." required></textarea>

                        <button type="submit">Send Request</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
