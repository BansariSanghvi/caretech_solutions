<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check if the `id` parameter is provided
if (!isset($_GET['id'])) {
    die("No problem ID specified.");
}

$order_id = intval($_GET['id']);

// Fetch problem details
$query = "SELECT order_number, order_date, order_qty, hospital_department_id, delivery_status FROM equipment_orders WHERE order_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Problem not found.");
}

$orders = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['delivery_status'];

    $update_query = "UPDATE equipment_orders SET delivery_status = ? WHERE order_number = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_status, $order_id);

    if ($update_stmt->execute()) {
        header("Location: supply_orders.php");
        exit;
    } else {
        echo "Error updating delivery status: " . $conn->error;
    }
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
    <title>Update Delivery Status</title>
    <style>
        .update-container {
            width: 80%;
            margin-left: 20px;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .update-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .update-container form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .update-container form select, 
        .update-container form button {
            width: 40%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }

        .update-container form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 10%;
        }

        .update-container form button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .update-container form .action-buttons {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 10px;
        }

        .update-container form .action-buttons button {
            width: auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .update-container form .action-buttons button:hover {
            background-color: #45a049;
        }

        .update-container form .action-buttons .back-link {
            align-self: center;
            color: #007bff;
            font-size: 14px;
            text-decoration: none;
        }

        .update-container form .action-buttons .back-link:hover {
            text-decoration: underline;
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

            <div class="update-container">
                <h2>Update Delivery Status: </h2>
                <p><strong>Order Number:</strong> <?php echo htmlspecialchars($orders['order_number']); ?></p>
                <p><strong>Order Date:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime($orders['order_date']))); ?></p>
                <p><strong>Order Qty:</strong> <?php echo htmlspecialchars($orders['order_qty']); ?></p>
                

                <form method="POST">
                    <label for="delivery_status">Status:</label>
                    <select name="delivery_status" id="delivery_status">
                        <option value="Pending" <?php echo $orders['delivery_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Order Placed" <?php echo $orders['delivery_status'] === 'Order Placed' ? 'selected' : ''; ?>>Order Placed</option>
                        <option value="Order Delivered" <?php echo $orders['delivery_status'] === 'Delivered' ? 'selected' : ''; ?>>Order Delivered</option>
                        <option value="Completed" > <?php echo $orders['delivery_status'] === 'Completed' ? 'selected' : ''; ?>Complete</option>
                    </select>

                    <div class="action-buttons">
                        <button type="submit">Update</button>
                        <button type ="back-link" on-click = "window.location.href='supply_orders.php'" style="background-color: grey;">Cancel</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
if (window.location.search.includes("update=success")) {
    alert("Problem status updated successfully!");
}
</script>
