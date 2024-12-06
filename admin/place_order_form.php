<?php
session_start();

// Check if the user is an branch manager
if ($_SESSION['role'] != 'admin') {
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
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Place Order</title>

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
        <?php include("../common/sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!-- Dashboard Section -->
            <div class="inside-content">
                <section class="inventory" id='inventory'>
                    <h3 class="page_title">Place Order: Medical Equipment</h3>

                    <!-- Form to add new medication -->
                    <div class="form-container">
                        <form action="place_order_process.php" method="POST">
                            <div class="row">
                                <label for="Equipment-Item">Item Name:</label>
                                <?php
                                $result = $conn->query("SELECT equipment_ID, equipment_Name FROM `medicalEquipment_list`;");
                                if ($result->num_rows > 0) { 
                                    echo '<select id="equipment_ID" name="equipment_ID" required>'; 
                                    while ($row = $result->fetch_assoc()) { 
                                        echo '<option value="' . $row['equipment_ID'] . '">' . $row['equipment_Name'] . '</option>'; 
                                    }
                                    echo '</select>'; 
                                } else { 
                                    echo '<p>No Items available</p>'; 
                                }
                                ?>
                            </div>

                            <div class="row">
                                <label for="quantity">Quantity:</label>
                                <input type="number" id="order_qty" name="order_qty" required>
                            </div>

                            <div class="row">
                                <label for="hospital">Hospital Department:</label>
                                <?php
                                $result = $conn->query("SELECT hospital_department_id, department_name FROM `hospital_branches`;");
                                if ($result->num_rows > 0) { 
                                    echo '<select id="hospital_department_id" name="hospital_department_id" required>'; 
                                    while ($row = $result->fetch_assoc()) { 
                                        echo '<option value="' . $row['hospital_department_id'] . '">' . $row['department_name'] . '</option>'; 
                                    }
                                    echo '</select>'; 
                                } else { 
                                    echo '<p>No Items available</p>'; 
                                }
                                ?>
                            </div>

                            <div class="row">
                                <label for="supplier">Supplier:</label>
                                <?php
                                $result = $conn->query("SELECT supplier_id, supplier_name FROM `manufacturers`;");
                                if ($result->num_rows > 0) { 
                                    echo '<select id="supplier_id" name="supplier_id" required>'; 
                                    while ($row = $result->fetch_assoc()) { 
                                        echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_name'] . '</option>'; 
                                    }
                                    echo '</select>'; 
                                } else { 
                                    echo '<p>No Suppliers available</p>'; 
                                }
                                ?>
                            </div>

                            <button type="submit">Place Order</button>
                            <button type="button" class="cancel" onclick="window.location.href='admin_stock_inventory.php'">Cancel</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
