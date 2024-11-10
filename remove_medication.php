<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Remove Medication</title>

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
            padding: 8px;
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
                <section class="remove_medicine_section" id='remove-drug'>
                    <h3 class="page_title">Remove Medicine from Inventory:</h3>

                    <!-- Form to add new staff -->
                    <div class="form-container">
                        <form action="remove_drug_process.php" method="POST">
                            
                            <div class="row">
                                <label for="dname">Medicine Name:</label>
                                <input type="text" id="dname" name="dname" required>
                            </div>

                            <div class="row">
                                <label for="last_name">ID Number:</label>
                                <input type="text" id="medicine_id" name="medicine_id" required>
                            </div>

                            <div class="row">
                                <label for="last_name">Reason:</label>
                                <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Enter notes here..."></textarea>
                            </div>

                            <button type="submit">Remove Medicine</button>
                            <button class="cancel" onclick="window.location.href='medicineList.php'">Cancel</button>

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
