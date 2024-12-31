<?php
session_start();

// Check if the user is authorized
if ($_SESSION['role'] != 'staff') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <title>Submit Approval Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-group select,
        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 2px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        .form-group select:hover,
        .form-group input:hover,
        .form-group textarea:hover {
            border-color: #007bff;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #0056b3;
            outline: none;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .form-group button:hover {
            background-color: #0056b3;
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
            <div class="form-container">
                <h2>Submit Approval Request</h2>
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
                        <button type="submit">Submit Approval Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
