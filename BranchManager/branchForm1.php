<?php
session_start();

$current_page = 'forms';

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
    <title>BranchManager Form1</title>
    
    <style>
        .form-container {
            background-color: #ffffff; /* White background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #063478; /* Dark blue for labels */
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 4px;
        }

        .form-group textarea {
            height: 150px;
        }

        .form-group input[type="submit"] {
            background-color: #063478; /* Primary color */
            color: white; /* White text */
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #042456; /* Darker shade on hover */
        }
</style>
</head>
<body>
    <div class="container">
      <!--------------------Side Menu------------ -->
         <!--------------------Side Menu------------ -->
      <?php  include("../common/branch_sidebar.php"); ?>

<!-------------------Header------------------->
<div class="main-content">
    
<?php  include("../common/branch_navbar.php"); ?>
            <!------------------Patient Section------------------>
            <section id="letter_generation">
    <h2 class="page_title">Letter Generation</h2>
    <div class="form-container">
        <form action="generate_letter.php" method="post">
            <div class="form-group">
                <label for="recipient_name">Recipient Name:</label>
                <input type="text" id="recipient_name" name="recipient_name" required>
            </div>
            <div class="form-group">
                <label for="recipient_email">Recipient Email:</label>
                <input type="email" id="recipient_email" name="recipient_email" required>
            </div>
            <div class="form-group">
                <label for="letter_type">Letter Type:</label>
                <select id="letter_type" name="letter_type" required>
                    <option value="">Select Type</option>
                    <option value="appointment_confirmation">Appointment Confirmation</option>
                    <option value="discharge_summary">Discharge Summary</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Generate Letter">
            </div>
        </form>
    </div>
</section>



    <script src="assets/js/main.js"></script>
</body>
</html>
