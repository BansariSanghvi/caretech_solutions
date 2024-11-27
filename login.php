<?php
session_start();

// Hardcoded user data
$users = [
    ['username' => 'admin@caretech.com', 'password' => 'admin123', 'role' => 'admin'],
    ['username' => 'manager@caretech.com', 'password' => 'manager123', 'role' => 'branchManager'],
    ['username' => 'gp@caretech.com', 'password' => 'gp123', 'role' => 'gp'],
];

$errorMessage = '';

if (isset($_POST['login'])) {  // Check if the form is submitted
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Loop through users array to check credentials
    $authenticated = false;
    foreach ($users as $user) {
        if ($user['username'] == $username && $user['password'] == $password) {
            // Credentials match, store the user role in session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            $authenticated = true;

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: admin/index.php');
            } elseif ($user['role'] == 'branchManager') {
                header('Location: BranchManager/branchDashboard.php');
            } elseif ($user['role'] == 'gp') {
                header('Location: staff/staff_dashboard.php');
            }
            exit;
        }
    }

    if (!$authenticated) {
        $errorMessage = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="css/styles.css">

    <!--===============BOXICONS================-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Login Form</title>
</head>
<body>
    <div class="login__container container grid">
        <div class="logo_part">
            <img src="img/logo.png" style="height: 300px; width: 700px" alt="">
        </div>
        <div class="wrapper">
            <form id="loginForm" class="login-form" method="POST" action="login.php">
                <h1 class="title">Login</h1>
                
                <!-- Username Field -->
                <div class="input__box">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                
                <!-- Password Field -->
                <div class="input__box">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember Me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" name="login" class="btn">Login</button>
                
                <div class="register-link">
                    <p>Don't have an account? <a href="#">Register</a></p>
                </div>
                
                <!-- Error Message Display -->
                <?php if ($errorMessage): ?>
                    <p id="errorMessage" style="color: red;"><?= $errorMessage ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Link to the external JavaScript file -->
    <script src="/js/main.js"></script>
</body>
</html>
