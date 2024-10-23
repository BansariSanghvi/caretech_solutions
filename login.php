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
            <img src="img/logo.png" style = "height: 300px; width: 700px" alt="">
        </div>
        <div class="wrapper">
            <form id="loginForm" class="login-form">
                <h1 class="title">Login</h1>
                <div class="input__box">
                    <input type="text" id="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input__box">
                    <input type="password" id="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember Me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn" onclick="#">Login</button>
                <div class="register-link">
                    <p>Don't have an account? <a href="#">Register</a></p>
                </div>
                <p id="errorMessage" style="color: red; display: none;">Invalid username or password.</p>
            </form>
        </div>
    </div>

    <!-- Link to the external JavaScript file -->
    <script src="/js/main.js"></script>
</body>
</html>
