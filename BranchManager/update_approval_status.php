<?php
session_start();
include dirname(__DIR__).("/connection/connection.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $type = $_POST['type'];

    if ($type == 'equipment') {
        $sql = "UPDATE approvals SET approval_status = ?, approval_date = CURRENT_DATE WHERE approval_id = ?";
    } else if ($type == 'referral') {
        $sql = "UPDATE referral_form SET isViewed = ? WHERE request_id = ?";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid approval type']);
        exit;
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
        exit;
    }

    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
