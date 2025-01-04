<?php
session_start();

$current_page = 'settings';

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

<style>
.settings-container {
            padding: 20px;
            border-radius: 8px;
            width: 95%;
            margin-left: 10px;
        }

        .settings-container h2 {
            margin: 0 0 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: left;
            color: #000;
            text-decoration: underline;
        }

        .settings-grid {
            display: flex;
            gap: 30px;
            justify-content: space-between;
        }

        .settings-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            flex: 1;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .settings-section h4 {
            background-color: rgb(21, 10, 66);
            color: #fff;
            padding: 10px;
            border-radius: 4px 4px 0 0;
            margin: -15px -15px 10px;
            font-size: 15px;
        }

        .settings-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-section li {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .settings-section li:hover {
            background-color: #f0f0f0;
        }

        .settings-section li:last-child {
            border-bottom: none;
        }
         

        
    </style>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Inner Section------------------>
                  <section class="filter" id="filter_option">
                  <div class="inside-content">
                <section class="settings_section" id="settings_hub">
                    <h2 class="page_title">Settings:</h2>

                    <div class="settings-container">
                        <div class="settings-grid">
                            <!-- Account Section -->
                            <div class="settings-section">
                                
                                <ul>
                                    <li onclick="window.location.href='branchRequestPasswordChange.php'">Request Password Change</li>
                                    <li onclick="window.location.href='branch_report_problem.php'">Report Problem</li>
                                   
                                    
                                </ul>
                            </div>

                  </section>
                  

               </section>
            </div>
            
        </div>
    </div>



    <script src="assets/js/main.js"></script>
</body>
</html>
