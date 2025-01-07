
<?php
session_start();

include dirname(__DIR__) . '/connection/connection.php';

$dbConnect = new DBConnect();
$conn = $dbConnect->connect();


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
    <title>Add Staff</title>

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
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            
        }


    </style>
</head>
<body>
    <div class="container">
        <!-- Side Menu -->
        <?php include dirname(__DIR__) . "/common/branch_sidebar.php"; ?>

        <!-- Header -->
        <div class="main-content">
        <?php include dirname(__DIR__) . "/common/branch_navbar.php"; ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
            <section class="staff_hub_section" id='staff_hub'>
                <h3 class="page_title">Add Staff Member:</h3>

                <!-- Form to add new staff -->
                <div class="form-container">
                    <form action="add_branchStaff_process.php" method="POST">
                        
                        <div class="row">
                            <label for="staff_id">Staff ID:</label>
                            <input type="text" id="staff_id" name="staff_id" required>
                        </div>

                        <div class="row">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>

                        <div class="row">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>

                        <div class="row">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="row">
                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="Doctor">Doctor</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Receptionist">Receptionist</option>

                            </select>
                        </div>

                        <div class="row">
                            <label for="status">Status:</label>
                            <select id="status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="row">
                            <label for="dialcode">Dial Code:</label>
                            <input type="text" id="dialcode" name="dialcode" required>
                        </div>

                        <button type="submit">Add Staff Member</button>
                            <button class="cancel" onclick="window.location.href='branchStaff.php'">Cancel</button>

                        </div>
                    </form>
                </div>
            </section>
        </div>
                            
                </section>
            </div>
        </div>
    </div>

    
</body>
</html>
