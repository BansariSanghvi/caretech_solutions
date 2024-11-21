<?php
session_start();

$current_page = 'stock';

// Check if the user is an branch manager
if ($_SESSION['role'] != 'branchManager') {
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
    <link rel="stylesheet" href="../css/branch_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>BranchManager Stock / Inventory</title>
    <style>

        .data_table {
            width: 90%;
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

        .data_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data_table tr:hover {
            background-color: #ddd;
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
            gap: 10px; /* Space between buttons */
        }

        .search_filter {
            display: flex;
            align-items: center;
            margin-right: 100px; /* Adjust as needed */
            gap: 5px; /* Space between the icon and input */
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
    </style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Stock Section------------------>
            <div class="inside-content">
               <section class="stock_section" id ='stock'>
                  <h2 class="page_title">Stock / Inventory:</h2>

                  <div class="top_container">
                        <div class="buttons-container">
                            <div class="add_box">
                                <button class = "add_btn" onclick="window.location.href='add_branchStock.php'"><i class='bx bxs-plus-square'></i>   Add Item</button>
                            </div>
                            <div class="remove_box">
                                <button class="remove_btn" onclick="window.location.href='remove_branchStock.php'"><i class='bx bxs-minus-square'></i> Remove Item</button>
                            </div>

                            <div class="upload_box">
                                <button class="upload_btn" onclick="window.location.href='upload_branchStock.php'"><i class="ri-file-upload-fill"></i> Upload CVS File</button>
                            </div>

                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>  
                                <input type="text" placeholder="search">
                            </div>
            </div>
            <div class="scrollable-table">
                <table class="data_table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Current Quantity</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>I1001</td>
                            <td>Surgical Gloves</td>
                            <td>Protective Equipment</td>
                            <td>5000</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>I1002</td>
                            <td>Paracetamol 500mg</td>
                            <td>Medication</td>
                            <td>10000</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>I1003</td>
                            <td>Syringe 10ml</td>
                            <td>Medical Supplies</td>
                            <td>2000</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>I1004</td>
                            <td>Bandage Roll</td>
                            <td>First Aid</td>
                            <td>500</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>
                        
                        <tr>
                            <td>I1005</td>
                            <td>Stethoscope</td>
                            <td>Medical Equipment</td>
                            <td>50</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>

                        <tr>
                            <td>I1006</td>
                            <td>Ibuprofen 200mg</td>
                            <td>Medication</td>
                            <td>8000</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>

                        <tr>
                            <td>I1007</td>
                            <td>Disposable Masks</td>
                            <td>Protective Equipment</td>
                            <td>10000</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>

                        <tr>
                            <td>I1008</td>
                            <td>Blood Pressure Monitor</td>
                            <td>Medical Equipment</td>
                            <td>30</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>

                        <tr>
                            <td>I1009</td>
                            <td>Antiseptic Solution</td>
                            <td>First Aid</td>
                            <td>200</td>
                            <td><button class="edit-button">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
                </section>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>
</body>
</html>

