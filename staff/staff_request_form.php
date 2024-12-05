<?php
session_start();

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
    <title>Request Equipment Form</title>
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
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 2px solid #ccc; /* Increased border thickness */
            border-radius: 6px; /* More rounded corners */
            transition: border-color 0.3s; /* Smooth transition for border color */
        }

        /* Hover effect for inputs and textareas */
        .form-group select:hover,
        .form-group input:hover {
            border-color: #007bff; /* Blue border on hover */
        }

        /* Focus effect for inputs and textareas */
        .form-group select:focus,
        .form-group input:focus {
            border-color: #0056b3; /* Darker blue border on focus */
            outline: none; /* Remove default outline */
        }

        /* Button styles */
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
                <h2>Request Equipment</h2>
                <form action="process_request.php" method="POST">
                    <!-- Equipment List -->
                    <div class="form-group">
                        <label for="equipment">Select Equipment:</label>
                        <select id="equipment" name="equipment" required>
                            <option value="" disabled selected>-- Select Equipment --</option>
                            <option value="Ventilator">Ventilator</option>
                            <option value="Defibrillator">Defibrillator</option>
                            <option value="Syringe Pump">Syringe Pump</option>
                            <option value="ECG Machine">ECG Machine</option>
                            <option value="Ultrasound Machine">Ultrasound Machine</option>
                        </select>
                    </div>

                    <!-- Department -->
                    <div class="form-group">
                        <label for="department">Select Department:</label>
                        <select id="department" name="department" required>
                            <option value="" disabled selected>-- Select Department --</option>
                            <option value="Emergency">Emergency</option>
                            <option value="ICU">ICU</option>
                            <option value="Radiology">Radiology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Oncology">Oncology</option>
                        </select>
                    </div>

                    <!-- Hospital -->
                    <div class="form-group">
                        <label for="hospital">Select Hospital:</label>
                        <select id="hospital" name="hospital" required>
                            <option value="" disabled selected>-- Select Hospital --</option>
                            <option value="City Hospital">City Hospital</option>
                            <option value="Central General">Central General</option>
                            <option value="Northside Clinic">Northside Clinic</option>
                            <option value="Westend Medical">Westend Medical</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
