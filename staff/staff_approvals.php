<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Equipment Request</title>
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

        .form-group textarea {
            height: 100px; 
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

        <div class="main-content">
            <!-- Navbar -->
            <?php include("../common/staff_navbar.php"); ?>

            <!-- Equipment Request Section -->
            <section id="equipment_request_form">
                <h2 class="page_title">Equipment Request Form</h2>
                <div class="form-container">
                    <form action="process_equipment_request.php" method="post">
                        <!-- Hospital Department -->
                        <div class="form-group">
                            <label for="department">Select Hospital Department:</label>
                            <select id="department" name="department" required>
                                <option value="" disabled selected>Select a department</option>
                                <option value="Emergency">Emergency</option>
                                <option value="ICU">ICU</option>
                                <option value="Radiology">Radiology</option>
                                <option value="Pediatrics">Pediatrics</option>
                                <option value="Surgery">Surgery</option>
                                <option value="Pharmacy">Pharmacy</option>
                            </select>
                        </div>

                        <!-- Medical Equipment -->
                        <div class="form-group">
                            <label for="equipment">Select Medical Equipment:</label>
                            <select id="equipment" name="equipment" required>
                                <option value="" disabled selected>Select an equipment</option>
                                <option value="Syringe">Syringe</option>
                                <option value="Stethoscope">Stethoscope</option>
                                <option value="MRI Machine">MRI Machine</option>
                                <option value="Ventilator">Ventilator</option>
                                <option value="ECG Machine">ECG Machine</option>
                                <option value="Defibrillator">Defibrillator</option>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" required placeholder="Enter quantity">
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description (Optional):</label>
                            <textarea id="description" name="description" placeholder="Enter additional details about the request"></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <input type="submit" value="Submit Request">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
