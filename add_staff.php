<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_theme.css">
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
            width: 100%;
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

        /* Flexbox for first and last name in one row */
        .name-row {
            display: flex;
            gap: 20px; 
        }

        .name-row input {
            width: 48%; 
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
                <section class="staff_hub_section" id='staff_hub'>
                    <h2 class="page_title">Add Staff Member:</h2>

                    <!-- Form to add new staff -->
                    <div class="form-container">
                        <form action="add_staff_process.php" method="POST">
                            
                            <div class="name-row">
                                <div>
                                    <label for="first_name">First Name:</label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>

                                <div>
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                            </div>


                            <div>
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div>
                                <label for="role">Role:</label>
                                <input type="text" id="role" name="role" required>
                            </div>

                            <div>
                                <label for="department">Department:</label>
                                <select id="department" name="department" required>
                                    <option value="radiology">Radiology</option>
                                    <option value="oncology">Oncology</option>
                                    <option value="ER">Emergency Response</option>
                                    <option value="ICU">Intensive Care Unit</option>
                                </select>
                            </div>

                            <div>
                                <label for="status">Status:</label>
                                <select id="status" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div>
                                <label for="phone">Phone Number:</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>

                            <div>
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" required>
                            </div>

                            <button type="submit">Add Staff Member</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
