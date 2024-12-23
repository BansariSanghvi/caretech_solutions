<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

if (!isset($_GET['id'])) {
    die("No Item ID specified.");
}

$item_id = intval($_GET['id']);

// Fetch existing data from the medicalequipment_list table
$query = "SELECT 
                medicalEquipment_list.equipment_ID,
                medicalEquipment_list.equipment_Name,
                medicalEquipment_list.qty,
                medicalEquipment_list.hospital_department_id,
                hospital_branches.department_name
                FROM 
                medicalEquipment_list
                INNER JOIN 
                hospital_branches 
                ON 
                medicalEquipment_list.hospital_department_id = hospital_branches.hospital_department_id
                WHERE
                medicalEquipment_list.equipment_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Item not found.");
}

$equipment = $result->fetch_assoc();

// Handle POST request to update the quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_qty = $_POST['qty'];

    // Update the quantity in the database for the specific equipment and department
    $update_query = "UPDATE medicalequipment_list SET qty = ? WHERE equipment_ID = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $new_qty, $item_id);

    if ($update_stmt->execute()) {
        header("Location: admin_stock_inventory.php");
        exit;
    } else {
        echo "Error updating quantity: " . $conn->error;
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
    <title>Edit Item Quantity</title>
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
        <!-- Side Menu -->
        <?php include("../common/sidebar.php"); ?>

        <!-- Header -->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <div class="update-container">
                <h2>Edit Item Quantity: </h2>
                <p><strong>Item Name:</strong> <?php echo htmlspecialchars($equipment['equipment_Name']); ?></p>
                <p><strong>Department ID:</strong> <?php echo htmlspecialchars($equipment['department_name']); ?></p>
                
                <form method="POST">
                    <label for="qty">Quantity:</label>
                    <input style= "height: 40px; font-size: 18px;" type="number" name="qty" id="qty" value="<?php echo htmlspecialchars($equipment['qty']); ?>" required>

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
    alert("Item quantity updated successfully!");
}
</script>

