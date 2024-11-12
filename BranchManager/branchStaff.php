<?php
session_start();

$current_page = 'staff';

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
    <title>BranchManager Staff Hub</title>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Staff Section------------------>
            <div class="inside-content">
               <section class="staff_section" id ='Staff'>
                  <h2 class="page_title">Staff Hub:</h2>
                  <p class="desc" style="margin-left: 20px; margin-top: 20px;">Complete: </p>

               </section>
            </div>
            
        </div>
    </div>



    <script src="assets/js/main.js"></script>
</body>
</html>
