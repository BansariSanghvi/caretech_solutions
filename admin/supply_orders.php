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
    <title>Orders</title>

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

.orders_top_container {
    margin-left: 20px;
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

.place_order_btn {
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
                <section class="orders_section" id='orders_hub'>
                    <h2 class="page_title">Order Summary</h2>

                    <div class="orders_top_container">
                        <div class="buttons-container">

                            <div class="add_staff_box">
                                <button class = "place_order_btn" onclick="window.location.href='place_order_form.php'"><i class="ri-user-add-line"></i>   Place Order</button>
                            </div>
                        
                            </div>
                                <div class="search_filter">
                                <i class="ri-search-line"></i>
                                <input type="text" placeholder="search">
                            </div>
            </div>


                    <?php
                    $query = "SELECT equipment_orders.order_number, equipment_orders.equipment_ID, equipment_orders.order_qty,
                    equipment_orders.order_date, equipment_orders.hospital_department_id, equipment_orders.delivery_status 
                    FROM equipment_orders INNER JOIN medicalequipment_list 
                    ON medicalequipment_list.equipment_ID = equipment_orders.equipment_ID 
                    INNER JOIN hospital_branches ON hospital_branches.hospital_department_id = equipment_orders.hospital_department_id; ";
    
                    $result = $conn->query($query);
                   
                   // Check if there are any records
                   if ($result->num_rows > 0) {
                       $orders_data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
                   } else {
                       $orders_data = []; // No records found
                   }
                    ?>
                   

                    <div class="scrollable-table">
                    <table class="staff_table">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Order Date</th>
                                <th>Department</th>
                                <th>Delivery Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            // Loop through inventory data and display it in the table
                            foreach ($orders_data as $order) {
                                echo "<tr>";
                                echo "<td>" . $order['order_number'] . "</td>";
                                echo "<td>" . $order['equipment_ID'] . "</td>";
                                echo "<td>" . $order['order_qty'] . "</td>";
                                echo "<td>" . $order['order_date'] . "</td>";
                                echo "<td>" . $order['hospital_department_id'] . "</td>";
                                echo "<td>" . $order['delivery_status'] . "</td>";
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
