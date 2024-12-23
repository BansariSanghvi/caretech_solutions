<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';
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
    <title>Admin Inventory</title>
    <style>
        .data_table {
            width: 93%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .data_table thead {
            background-color: #001f3f; /* Dark navy blue */
            color: white; /* White text */
        }

        .data_table th, .data_table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .edit-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 4px;
        }

        .scrollable-table {
            display: block;
            max-height: 535px; 
            overflow-y: auto;
        }

        .top_container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;  
        }

        .buttons-container {
            display: flex;
            gap: 10px; 
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px; 
            gap: 5px; 
        }

        .search_filter input {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search_filter i {
            color: #888; 
            font-size: 20px; 
        }

        .add_btn {
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
            margin-left: 30px;
        }

        .remove_btn {
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .upload_btn {
            background-color: #ff5733; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        } 

        .order_btn {
            background-color: #da21be; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .low-stock {
            background-color: #ba0a0a; /* Red for low stock */
            color: white;
        }

        .approaching-stock {
            background-color: #dfd81b; /* Yellow for approaching stock */
        }

        .normal-stock {
            background-color: white; 
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

        <!-- Stock Section -->
        <div class="inside-content">
            <section class="stock_section" id="stock">
                <h2 class="page_title">Admin View: Medical Equipment Inventory:</h2>

                <div class="top_container">
                    <div class="buttons-container">
                        <div class="add_box">
                            <button class="add_btn" onclick="window.location.href='#'"><i class='bx bxs-plus-square'></i> Add Item</button>
                        </div>
                        <div class="remove_box">
                            <button class="remove_btn" onclick="window.location.href='#'"><i class='bx bxs-minus-square'></i> Remove Item</button>
                        </div>

                        <div class="upload_box">
                            <button class="upload_btn" onclick="window.location.href='#'"><i class="ri-file-upload-fill"></i> Upload CVS File</button>
                        </div>

                        <div class="submit_order_box">
                            <button class="order_btn" onclick="window.location.href='place_order_form.php'"><i class="ri-file-upload-fill"></i> Place Order</button>
                        </div>
                    </div>
                    <div class="search_filter">
                        <i class="ri-search-line"></i>  
                        <input type="text" placeholder="search">
                    </div>
                </div>

                <div class="scrollable-table">
                    <table class="data_table" id="inventory-table">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Hospital Branch</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here by AJAX -->
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
      </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Function to fetch and update the table content
        function fetchInventoryData() {
            $.ajax({
                url: 'fetch_inventory_updates.php',  
                method: 'GET',
                success: function(data) {
                    // Update the table's body with the new data
                    $('#inventory-table tbody').html(data);
                },
                error: function() {
                    alert("Error fetching data.");
                }
            });
        }

        
        setInterval(fetchInventoryData, 5000); // Updates after 5 secs

        
        $(document).ready(function() {
            fetchInventoryData();
        });
    </script>

</body>
</html>
