<?php
session_start();
include dirname(__DIR__).("../connection/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['qty'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $qty = $conn->real_escape_string($_POST['qty']);

    $query = "UPDATE medicalEquipment_list SET qty = ? WHERE equipment_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $qty, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
