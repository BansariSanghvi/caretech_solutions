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
    <title>Referral Form</title>
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
            border: 2px solid #ccc; /* Slightly thicker border for visibility */
            border-radius: 6px; /* More rounded corners */
            transition: border-color 0.3s; /* Smooth transition for border color */
        }

        /* Hover effect for inputs and textareas */
        .form-group select:hover,
        .form-group input:hover,
        .form-group textarea:hover {
            border-color: #007bff; /* Blue border on hover */
        }

        /* Focus effect for inputs and textareas */
        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
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
                <h2>Referral Form</h2>
                <form action="process_referral.php" method="POST">
                    <!-- Hospital Selection -->
                    <div class="form-group">
                        <label for="hospital">Referred From (Hospital):</label>
                        <select id="hospital" name="hospital" required>
                            <option value="" disabled selected>-- Select Hospital --</option>
                            <option value="City Hospital">City Hospital</option>
                            <option value="Central General">Central General</option>
                            <option value="Northside Clinic">Northside Clinic</option>
                            <option value="Westend Medical">Westend Medical</option>
                        </select>
                    </div>

                    <!-- Clinic/GP Selection -->
                    <div class="form-group">
                        <label for="gp">Referred To (Clinic/GP):</label>
                        <select id="gp" name="gp" required>
                            <option value="" disabled selected>-- Select Clinic/GP --</option>
                            <option value="Dr. Smith's Clinic">Dr. Smith's Clinic</option>
                            <option value="Green Valley GP">Green Valley GP</option>
                            <option value="Downtown Medical Center">Downtown Medical Center</option>
                            <option value="Sunrise Family Health">Sunrise Family Health</option>
                        </select>
                    </div>

                    <!-- Patient Name -->
                    <div class="form-group">
                        <label for="patient_name">Patient's Name:</label>
                        <input type="text" id="patient_name" name="patient_name" placeholder="Enter patient's name" required>
                    </div>

                    <!-- Patient Number -->
                    <div class="form-group">
                        <label for="patient_no">Patient Number:</label>
                        <input type="text" id="patient_no" name="patient_no" placeholder="Enter patient number" required>
                    </div>

                    <!-- Referral Summary -->
                    <div class="form-group">
                        <label for="summary">Reason for Referral:</label>
                        <textarea id="summary" name="summary" rows="5" placeholder="Enter the summary of the referral" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Submit Referral</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
