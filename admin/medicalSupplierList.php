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
    <title>Suppliers</title>

    <style>
.staff_table {
    width: 90%;
    border-collapse: collapse;
    margin-left: 2rem;
    margin-top:2rem;
    margin-bottom: 2rem
}

.staff_table thead {
    background-color: #001f3f; /* Dark navy blue */
    color: white; /* White text */
}
        
.staff_table th, .staff_table td {
    padding: 12px;
    border: 1px solid #ddd;
}
        
.staff_table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.staff_table tr:hover {
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

.supplier_top_container {
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
    margin-right: 100px;
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

.add_supplier_btn{
    background-color: #4CAF50; 
    color: white;
    padding: 5px 10px;
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 30px;
}

.remove_supplier_btn{
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
        <?php include("../common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <!------------------Dashboard Section------------------>
            <div class="inside-content">
                <section class="providers_section" id='supplier_hub'>
                    <h2 class="page_title">Verifed External Medical Suppliers:</h2>

                    <div class="supplier_top_container">
                        <div class="buttons-container">
                            <div class="add_staff_box">
                                <button class = "add_supplier_btn" onclick="window.location.href='add_supplier.php'"><i class="ri-user-add-line"></i>   Add Supplier</button>
                            </div>
                            <div class="remove_staff_box">
                                <button class="remove_supplier_btn" onclick="window.location.href='remove_supplier.php'"><i class='bx bxs-minus-square'></i>  Remove Supplier</button>
                            </div>

                            <div class="upload_box">
                                        <button class="upload_btn" onclick="window.location.href='upload_supplierList.php'"><i class="ri-file-upload-fill"></i> Upload CVS File</button>
                            </div>

                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>
                                <input type="text" placeholder="search">
                            </div>
            </div>


                    <?php
                    $query = "SELECT manufacturers.supplier_id, manufacturers.supplier_name, manufacturers.supplier_email,
                    manufacturers.supplier_location , manufacturers.supplier_phone 
                    FROM `manufacturers` WHERE manufacturers.supplier_status = 'Active' ; ";
    
                    $result = $conn->query($query);
                   
                   // Check if there are any records
                   if ($result->num_rows > 0) {
                       $supplier_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
                   } else {
                       $supplier_data = []; // No records found
                   }
                    ?>
                   

                    <div class="scrollable-table">
                    <table class="staff_table">
                        <thead>
                            <tr>
                                <th>Supplier ID</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Number</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            // Loop through inventory data and display it in the table
                            foreach ($supplier_data as $supplier) {
                                echo "<tr>";
                                echo "<td>" . $supplier['supplier_id'] . "</td>";
                                echo "<td>" . $supplier['supplier_name'] . "</td>";
                                echo "<td>" . $supplier['supplier_email'] . "</td>";
                                echo "<td>" . $supplier['supplier_location'] . "</td>";
                                echo "<td>" . $supplier['supplier_phone'] . "</td>";
                                echo "<td><a href='edit_supplier.php?id=" . $supplier['supplier_id'] . "' class='edit-button'>Edit</a></td>";
                                echo "</tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>
</body>
</html>
