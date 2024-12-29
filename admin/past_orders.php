<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

$where_clause = "WHERE equipment_orders.delivery_status = 'Completed'";

// Filter by department
if (isset($_GET['department']) && !empty($_GET['department'])) {
    $department_id = $conn->real_escape_string($_GET['department']);
    $where_clause .= " AND hospital_branches.hospital_department_id = '$department_id'";
}

// Filter by date range
if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
    $dates = explode(' to ', $_GET['date_range']);
    if (count($dates) === 2) {
        $start_date = $conn->real_escape_string($dates[0]);
        $end_date = $conn->real_escape_string($dates[1]);
        $where_clause .= " AND equipment_orders.order_date BETWEEN '$start_date' AND '$end_date'";
    }
}

// Query to fetch filtered data
$query = "SELECT equipment_orders.order_number, equipment_orders.equipment_ID, medicalequipment_list.equipment_Name, 
                 equipment_orders.order_qty, equipment_orders.order_date, equipment_orders.hospital_department_id, 
                 equipment_orders.delivery_status, hospital_branches.department_name  
          FROM equipment_orders 
          INNER JOIN medicalequipment_list ON medicalequipment_list.equipment_ID = equipment_orders.equipment_ID 
          INNER JOIN hospital_branches ON hospital_branches.hospital_department_id = equipment_orders.hospital_department_id
          $where_clause 
          ORDER BY equipment_orders.order_number DESC";

$result = $conn->query($query);

// Check if there are any records
if ($result->num_rows > 0) {
    $orders_data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $orders_data = [];
}
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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <title>Past Orders</title>
    <style>
        .staff_table {
            width: 94%;
            border-collapse: collapse;
            margin-left: 2rem;
            margin-top:2rem;
            margin-bottom: 2rem
        }
        .staff_table thead {
            background-color: #001f3f;
            color: white;
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
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .orders_top_container {
            margin: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search_filter {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 15px;
        }
        .search_filter input, .search_filter select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .scrollable-table {
            display: block;
            max-height: 500px;
            overflow-y: auto;
        }

        .add_staff_btn{
            background-color: #4CAF50; 
            color: white;
            padding: 5px 10px;
            border: none;
            font-size: 14px;
            border-radius: 4px;
            margin-left: 30px;
        }

        .remove_staff_btn{
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
        <?php include("../common/sidebar.php"); ?>
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <section class="orders_section" id='orders_hub'>
                <h2 class="page_title">Past Orders:</h2>
                <div class="orders_top_container">
                    <form method="GET" action="">
                        <div class="search_filter">
                            <label for="department">Department:</label>
                            <select name="department" id="department" onchange="this.form.submit()">
                                <option value="">All Departments</option>
                                <?php
                                $dept_query = "SELECT hospital_department_id, department_name FROM hospital_branches";
                                $dept_result = $conn->query($dept_query);
                                while ($row = $dept_result->fetch_assoc()) {
                                    $selected = (isset($_GET['department']) && $row['hospital_department_id'] == $_GET['department']) ? 'selected' : '';
                                    echo "<option value='" . $row['hospital_department_id'] . "' $selected>" . $row['department_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="date_range">Date Range:</label>
                            <input type="text" name="date_range" id="date_range" value="<?php echo htmlspecialchars($_GET['date_range'] ?? ''); ?>" />
                            <button type="submit" class="edit-button">Filter</button>
                        </div>
                    </form>
                </div>

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
                            <?php foreach ($orders_data as $order): ?>
                                <tr>
                                    <td><?= $order['order_number'] ?></td>
                                    <td><?= $order['equipment_Name'] ?></td>
                                    <td><?= $order['order_qty'] ?></td>
                                    <td><?= htmlspecialchars(date('d-m-Y', strtotime($order['order_date']))) ?></td>
                                    <td><?= $order['department_name'] ?></td>
                                    <td><?= $order['delivery_status'] ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date_range').daterangepicker({
                opens: 'right',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
</body>
</html>
