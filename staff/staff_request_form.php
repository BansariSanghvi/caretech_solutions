<?php
session_start();

// Check if the user is authorized
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <title>Submit Approval Request</title>
    <style>
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #063478;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #063478;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #042456;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include("../common/staff_sidebar.php"); ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <?php include("../common/staff_navbar.php"); ?>

            <!-- Form Section -->
            <section id="approval_request_form">
                <h2 class="page_title">Submit Approval Request</h2>
                <div class="form-container">
                    <form action="process_equipment_request.php" method="POST">
                        <!-- User -->
                        <div class="form-group">
                            <label for="userID">Select User Level:</label>
                            <select id="userID" name="userID" required>
                                <option value="" disabled selected>-- Select User Level --</option>
                                <option value="1">Admin</option>
                                <option value="2">Branch Manager</option>
                                <option value="3">Staff</option>
                            </select>
                        </div>

                        <!-- Equipment List -->
                        <div class="form-group">
                            <label for="equipment">Select Equipment:</label>
                            <select id="equipment" name="equipment" required>
                                <option value="" disabled selected>-- Select Equipment --</option>
                                <option value="1">Ventilator</option>
                                <option value="2">Defibrillator</option>
                                <option value="3">Syringe Pump</option>
                                <option value="4">ECG Machine</option>
                                <option value="5">Ultrasound Machine</option>
                            </select>
                        </div>

                        <!-- Approval Quantity -->
                        <div class="form-group">
                            <label for="quantity">Approval Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" required>
                        </div>

                        <!-- Department -->
                        <div class="form-group">
                            <label for="department">Select Department:</label>
                            <select id="department" name="department" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                <option value="1">Emergency</option>
                                <option value="2">ICU</option>
                                <option value="3">Radiology</option>
                                <option value="4">Pediatrics</option>
                                <option value="5">Oncology</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Approval Description:</label>
                            <textarea id="description" name="description" rows="4" required placeholder="Provide details about the request..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <input type="submit" value="Submit Approval Request">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
