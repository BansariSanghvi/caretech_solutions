<?php
session_start();

$current_page = 'approvals';


include dirname(__DIR__) . "../connection/connection.php";

$dbConnect = new DBConnect();
$conn = $dbConnect->connect(); // Assuming this returns a PDO instance

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;

$approvalType = isset($_GET['type']) ? $_GET['type'] : 'equipment';
$department = isset($_GET['department']) ? $_GET['department'] : 'all';

$whereClause = $department != 'all' ? "AND hb.department_name = :department" : "";

try {
    if ($approvalType == 'equipment') {
        $sql = "SELECT a.*, hb.department_name, m.equipment_name 
                FROM approvals a
                JOIN hospital_branches hb ON a.hospital_department_id = hb.hospital_department_id
                JOIN medicalEquipment_list m ON a.equipment_ID = m.equipment_ID
                WHERE a.approval_status = 'Waiting Approval' $whereClause
                ORDER BY a.approval_sent_date DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($department != 'all') {
            $stmt->bindValue(':department', $department, PDO::PARAM_STR);
        }
        $stmt->execute();
        $approvals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count query
        $count_sql = "SELECT COUNT(*) AS total FROM approvals a
                      JOIN hospital_branches hb ON a.hospital_department_id = hb.hospital_department_id
                      WHERE a.approval_status = 'Waiting Approval' $whereClause";
        
        $count_stmt = $conn->prepare($count_sql);
        if ($department != 'all') {
            $count_stmt->bindValue(':department', $department, PDO::PARAM_STR);
        }
        $count_stmt->execute();
        $total_approvals = $count_stmt->fetchColumn();
    } else {
        // Referral approvals query
        $sql = "SELECT r.*, hb.department_name, s.fname AS staff_fname, s.lname AS staff_lname
                FROM referral_form r
                JOIN hospital_branches hb ON r.hospital_department_id = hb.hospital_department_id
                JOIN staff_records s ON r.staff_id = s.staff_id
                WHERE r.isViewed = 'Pending' $whereClause
                ORDER BY r.request_id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($department != 'all') {
            $stmt->bindValue(':department', $department, PDO::PARAM_STR);
        }
        $stmt->execute();
        $approvals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count query for referrals
        $count_sql = "SELECT COUNT(*) AS total FROM referral_form r
                      JOIN hospital_branches hb ON r.hospital_department_id = hb.hospital_department_id
                      WHERE r.isViewed = 'Pending' $whereClause";
        
        $count_stmt = $conn->prepare($count_sql);
        if ($department != 'all') {
            $count_stmt->bindValue(':department', $department, PDO::PARAM_STR);
        }
        $count_stmt->execute();
        $total_approvals = $count_stmt->fetchColumn();
    }

    // Calculate total pages for pagination
    $total_pages = ceil($total_approvals / $limit);

    // Fetch all departments for the filter dropdown
    $dept_sql = "SELECT DISTINCT department_name FROM hospital_branches";
    $dept_stmt = $conn->query($dept_sql);
    $departments = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error executing query: " . htmlspecialchars($e->getMessage()));
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
    <title>BranchManager Approval</title>
    <style>
      /* Your existing styles */
      #approvals { padding: 20px; }
      .approvals-container { display: flex; flex-direction: column; gap: 20px; }
      .approval-request { border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #f9f9f9; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
      .approval-request h3 { margin-top: 0; }
      .approve-btn { background-color: #4CAF50; color: white; border: none; padding: 10px 15px; font-size: 14px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
      .deny-btn { background-color: #f44336; color: white; border: none; padding: 10px 15px; font-size: 14px; border-radius: 4px; cursor: pointer; }
      .approve-btn:hover { background-color: #45a049; }
      .deny-btn:hover { background-color: #d32f2f; }
      .filter-container { display: flex; margin-bottom: 20px; justify-content: center; align-items: center; width 100%; }
      .filter-container select { padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px; background-color: #f9f9f9; }
      .pagination { margin-top: 20px; display: flex; justify-content: center; gap: 10px; }
      .pagination .prev-btn, .pagination .next-btn { padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;}
      .pagination .prev-btn:hover, .pagination .next-btn:hover { background-color: #45a049;}
      .approval-request.urgent-priority { background-color: rgba(255, 0, 0, 0.1); border-left: 5px solid red;}
      .approval-request.standard-priority { background-color: rgba(173, 216, 230, 0.5); border-left: 5px solid lightblue;}
      .approval-request { padding: 15px;margin-bottom: 10px;border-radius: 8px;}
    </style>
</head>
<body>
<div class="container">
   <!--------------------Side Menu------------ -->
   <?php include dirname(__DIR__) . "../common/branch_sidebar.php"; ?>
   <!-------------------Header------------------->
   <div class="main-content">
       <?php include dirname(__DIR__) . "../common/branch_navbar.php"; ?>
       <!------------------Approval Section------------------>
       <section id="approvals">
          <h2 class="page_title">Approvals</h2>

          <div class="filter-container">
              <select id="approvalTypeFilter" onchange="changeApprovalType()">
                  <option value="equipment" <?php echo ($approvalType == 'equipment') ? 'selected' : ''; ?>>Equipment Approvals</option>
                  <option value="referral" <?php echo ($approvalType == 'referral') ? 'selected' : ''; ?>>Referral Approvals</option>
              </select>
              <select id="departmentFilter" onchange="changeDepartment()">
                  <option value="all" <?php echo ($department == 'all') ? 'selected' : ''; ?>>All Departments</option>
                  <?php foreach ($departments as $dept): ?>
                      <option value="<?php echo htmlspecialchars($dept['department_name']); ?>" 
                              <?php echo ($department == htmlspecialchars($dept['department_name'])) ? 'selected' : ''; ?>>
                          <?php echo htmlspecialchars($dept['department_name']); ?>
                      </option>
                  <?php endforeach; ?>
              </select>
          </div>

          <div class="pagination">
              <?php if ($page > 1): ?>
                  <a href="?type=<?php echo htmlspecialchars($approvalType); ?>&department=<?php echo htmlspecialchars($department); ?>&page=<?php echo ($page - 1); ?>" class="prev-btn">Previous</a>
              <?php endif; ?>
              <?php if ($page < $total_pages): ?>
                  <a href="?type=<?php echo htmlspecialchars($approvalType); ?>&department=<?php echo htmlspecialchars($department); ?>&page=<?php echo ($page + 1); ?>" class="next-btn">Next</a>
              <?php endif; ?>
          </div>

          <div class="approvals-container">
              <?php if (empty($approvals)): ?>
                  <p>No approvals found.</p>
              <?php else: ?>
                  <?php foreach ($approvals as $approval): ?>
                      <?php if ($approvalType == 'equipment'): ?>
                          <div class="approval-request equipment">
                              <h3>Equipment Request</h3>
                              <p><strong>Department:</strong> <?php echo htmlspecialchars($approval['department_name']); ?></p>
                              <p><strong>Equipment Name:</strong> <?php echo htmlspecialchars($approval['equipment_name']); ?></p>
                              <p><strong>Quantity:</strong> <?php echo htmlspecialchars($approval['approval_qty']); ?></p>
                              <p><strong>Description:</strong> <?php echo htmlspecialchars($approval['approval_description']); ?></p>
                              <p><strong>Approval Sent Date:</strong> <?php echo htmlspecialchars($approval['approval_sent_date']); ?></p>
                              <p><strong>Status:</strong> <?php echo htmlspecialchars($approval['approval_status']); ?></p>
                              <button class="approve-btn" onclick="updateApprovalStatus(<?php echo htmlspecialchars($approval['approval_id']); ?>, 'Approved', 'equipment')">Approve</button>
                              <button class="deny-btn" onclick="updateApprovalStatus(<?php echo htmlspecialchars($approval['approval_id']); ?>, 'Denied', 'equipment')">Deny</button>
                          </div>
                      <?php else: ?>
                          <!-- Handle referral requests here -->
                      <?php endif; ?>
                  <?php endforeach; ?>
              <?php endif; ?>
          </div>
       </section>

       <!-- Your existing JavaScript -->
       <!-- Include your scripts here -->
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
// JavaScript functions remain unchanged...
function changeApprovalType() {
   var type = document.getElementById('approvalTypeFilter').value;
   var department = document.getElementById('departmentFilter').value;
   window.location.href = '?type=' + type + '&department=' + department;
}

function changeDepartment() {
   var type = document.getElementById('approvalTypeFilter').value;
   var department = document.getElementById('departmentFilter').value;
   window.location.href = '?type=' + type + '&department=' + department;
}

function updateApprovalStatus(id, status, type) {
   $.ajax({
       url:'update_approval_status.php',
       type:'POST',
       data:{id:id,status,status,type:type},
       dataType:'json',
       success:function(response){
           if(response.success){
               alert('Status updated successfully to '+status);
               location.reload(); 
           }else{
               alert('Failed to update status:'+response.message);
           }
       },
       error:function(){
           alert('An error occurred while updating the status');
       }
   });
}
</script>

</body>
</html>

