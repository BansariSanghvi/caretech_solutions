<?php
session_start();

$current_page = 'Settings';

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
    <title>Settings</title>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Inner Section------------------>
            <div class="inside-content">
               <section class="staff_section" id ='staff_hub'>
                  <h2 class="page_title">Settings:</h2>
                  
                  <section class="filter" id="filter_option">
                    

                    <!-------Add the other elements under this------>

                  </section>
                  

               </section>
            </div>
            
        </div>
    </div>



    <script src="assets/js/main.js"></script>
</body>
</html>
