<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Add Branch</title>

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
        <?php include("common/sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("common/navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="add_branch_section" id='branch_add'>
                    <h3 class="page_title">Add Medical Branches:</h3>

                    <!-- Form to add new staff -->
                    <div class="form-container">
                        <form action="add_branch_process.php" method="POST">
                            
                            <div class="row">
                                <label for="bname">Branch Name:</label>
                                <input type="text" id="bname" name="bname" required>
                            </div>

                            <div class="row">
                                <label for="type">Type:</label>
                                <select id="type" name="type" required>
                                    <option value="hospital">Hospital</option>
                                    <option value="clinic">Clinic</option>
                                    <option value="centre">Health Center</option>
                                    <option value="surgery">GP Surgery</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <label for="location">Location:</label>
                                <input type="text" id="location" name="location" required>
                            </div>

                        
                            <div class="row">
                                <label for="status">Status:</label>
                                <select id="status" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="row">
                                <label for="postcode">Postcode</label>
                                <input type="text" id="postcode" name="postcode" required>
                            </div>

                            <div class="row">
                                <label for="phone">Number:</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>

                            <div class="row">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <button type="submit">Add Branch</button>
                            <button class="cancel" onclick="window.location.href='medicalBranches.php'">Cancel</button>

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
