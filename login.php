<?php
session_start();

// Hardcoded user data
$users = [
    ['username' => 'admin@caretech.com', 'password' => 'admin123', 'role' => 'admin'],
    ['username' => 'manager@caretech.com', 'password' => 'manager123', 'role' => 'branchManager'],
    ['username' => 'gp@caretech.com', 'password' => 'gp123', 'role' => 'gp'],
    ['username' => 'staff@caretech.com', 'password' => 'staff123', 'role' => 'staff'],
];

function generateOTP($length = 6) {
    $otp = "";
    for ($i = 1; $i <= $length; $i++) {
        $otp .= rand(0, 9);
    }
    return $otp;
}

$errorMessage = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Loop through users array to check credentials
    $authenticated = false;
    foreach ($users as $user) {
        if ($user['username'] == $username && $user['password'] == $password) {
            // Credentials match, generate OTP
            $otp = generateOTP();
            $_SESSION['temp_user'] = $user;
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

            // Break the loop after finding the matching user
            $authenticated = true;
            break;
        }
    }

    if (!$authenticated) {
        $errorMessage = "Invalid credentials!";
    }
} elseif (isset($_POST['verify_otp'])) {
    $userOTP = $_POST['otp'];
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
        if (time() <= $_SESSION['otp_expiry']) {
            if ($userOTP == $_SESSION['otp']) {
                // OTP verified, complete login
                $user = $_SESSION['temp_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Clear OTP-related session variables
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expiry']);
                unset($_SESSION['temp_user']);
                
                // Redirect based on role
                if ($user['role'] == 'admin') {
                    header('Location: admin/index.php');
                } elseif ($user['role'] == 'branchManager') {
                    header('Location: BranchManager/branchDashboard.php');
                } elseif ($user['role'] == 'staff') {
                    header('Location: staff/staff_dashboard.php');
                }
                exit;
            } else {
                $errorMessage = "Invalid OTP.";
            }
        } else {
            $errorMessage = "OTP has expired.";
        }
    } else {
        $errorMessage = "OTP verification failed.";
    }
    // Clear OTP-related session variables even if verification fails
    unset($_SESSION['otp']);
    unset($_SESSION['otp_expiry']);
    unset($_SESSION['temp_user']);
}

// Generate a new OTP if the user is on the OTP verification page
if (isset($_SESSION['temp_user']) && !isset($_SESSION['otp'])) {
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Verification</title>
</head>
<body>
    <div class="login__container container grid">
        <div class="logo_part">
            <img src="img/logo.png" style="height: 300px; width: 700px" alt="">
        </div>
        <div class="wrapper">
            <?php if (!isset($_SESSION['temp_user'])): ?>
                <!-- Initial Login Form -->
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
                    
                    <!-- Remember Me and Forgot Password -->
                    <div class="remember-forgot">
                        <label><input type="checkbox" name="remember_me"> Remember Me</label>
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" name="login" class="btn">Login</button>
                    
                    <!-- Create Account Link -->
                    <div class="register-link">
                        <p>Don't have an account? <a href="register.php">Create Account</a></p>
                    </div>
                    
                    <!-- Error Message Display -->
                    <?php if ($errorMessage): ?>
                        <p id="errorMessage" style="color: red;"><?= $errorMessage ?></p>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <!-- OTP Verification Form -->
                <form id="otpForm" class="login-form" method="POST" action="login.php">
                    <h1 class="title">OTP Verification</h1>
                    
                    <div class="input__box">
                        <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    
                    <button type="submit" name="verify_otp" class="btn">Verify OTP</button>
                    
                    <!-- Error Message Display -->
                    <?php if ($errorMessage): ?>
                        <p id="errorMessage" style="color: red;"><?= $errorMessage ?></p>
                    <?php endif; ?>
                    
                    <!-- OTP Hint (remove in production) -->
                    <p style="color: green;">OTP: <?= $_SESSION['otp'] ?></p>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="/js/main.js"></script>
</body>
</html>
