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

$problem_id = intval($_GET['id']);

// Fetch problem details
$query = "SELECT problem_id, problem_status, problem_catagory, isUrgent, problem_description FROM problems WHERE problem_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $problem_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Problem not found.");
}

$problem = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['problem_status'];

    $update_query = "UPDATE problems SET problem_status = ? WHERE problem_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_status, $problem_id);

    if ($update_stmt->execute()) {
        header("Location: table_problem.php");
        exit;
    } else {
        echo "Error updating problem status: " . $conn->error;
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
    <title>Update Problem Status</title>
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
                <h2>Update Problem Status: </h2>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($problem['problem_catagory']); ?></p>
                <p><strong>Urgency Mark:</strong> <?php echo htmlspecialchars($problem['isUrgent']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($problem['problem_description']); ?></p>
                

                <form method="POST">
                    <label for="problem_status">Status:</label>
                    <select name="problem_status" id="problem_status">
                        <option value="Pending" <?php echo $problem['problem_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="In Progress" <?php echo $problem['problem_status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Resolved" <?php echo $problem['problem_status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                    </select>

                    <div class="action-buttons">
                        <button type="submit">Update</button>
                        <button type ="back-link" on-click = "window.location.href='problems_table.php'" style="background-color: grey;">Cancel</button>
                        
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
