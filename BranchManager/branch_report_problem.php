<?php
session_start();

$current_page = 'settings';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Report Problem</title>

    <style>
        /* Container for the form */
        .form-container {
            display: flex;
            flex-direction: grid;
            width: 70%; /* Adjust width to your liking */
            margin-left: 20px;
            padding: 20px;
        
        }

        /* Form heading */
        .form-container h4 {
            margin-bottom: 16px;
            font-size: 1.4rem;
            font-weight: bold;
            color: #333;
        }

        /* Label styles */
        .form-container label {
            margin-bottom: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: black;
        }

        /* Input and select field styling */
        .form-container input, .form-container select {
            padding: 5px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            width: 100%; 
            box-sizing: border-box;
            background-color: #fff;
        }

        /* Button styling */
        .form-container button {
            color: white;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: green;
            margin-top: 20px;
            
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        
        .form-container input:focus, .form-container select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Space between form fields */
        .form-container > div {
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            align-items: center; 
            gap: 30px; 
            margin-bottom: 16px; 
            width: 100%;
        }

        .row label {
            width: 100px; 
            font-weight: bold;
        }

        .row input, .row select {
            flex: 1; 
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            
        }


    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
      <?php  include dirname(__DIR__).("../common/branch_sidebar.php"); ?>

            <!-------------------Header------------------->
            <div class="main-content">
                
            <?php  include dirname(__DIR__).("../common/branch_navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="report_problem_section" id='report_problem'>
                    <h3 class="page_title">Report Problem:</h3>

                    <!-- Form to add new staff -->
                    <div class="form-container">
                        <form action="report.php" method="POST">
                            
                            <div class="row">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>

                            <div class="row">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>

                            <div class="row">
                                <label for="last_name">Staff ID Number:</label>
                                <input type="text" id="staff_id" name="staff_id" required>
                            </div>

                            <div class="row">
                                <label for="role">Role:</label>
                                <select id="role" name="role" required>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="assistant">Assistant</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>

                            <div class="row">
                                <label for="department">Department:</label>
                                <select id="department" name="department" required>
                                    <option value="HR">HR</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Finance">Finance</option>
                                </select>
                            </div>

                            <div class="row">
                                <label for="last_name">Issue: </label>
                                <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Please describe the issue in detail..."></textarea>
                            </div>

                            <button type="submit">Submit</button>
                            

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
