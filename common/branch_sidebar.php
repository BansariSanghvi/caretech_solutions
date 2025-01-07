<section id="menu">
    <div class="logo">
        <img src="../img/heart.png" alt="">
        <h3 class="name">CareTech Solutions</h3>
    </div>
    <div class="items">
        <li>
            <i class='bx bxs-home'></i><a href="branchDashboard.php">Dashboard</a>
        </li>
        <li>
            <i class='bx bxs-user-detail'></i><a href="branchStaff.php">Staff Hub</a>
        </li>
        <li>
            <i class='bx bx-male-female'></i><a href="branchPatients.php">Patient Records</a>
        </li>
        <li>
            <i class='bx bx-cabinet'></i><a href="branchStock.php">Stock / Inventory</a>
        </li>
        <li>
            <i class='bx bx-line-chart'></i><a href="branchAnalytics.php">Analytics</a>
        </li>
        <li>
            <i class='bx bxs-check-circle'></i><a href="branchApprovals.php">Approvals</a>
        </li>
        <li class="dropdown <?php echo ($current_page == 'forms') ? 'active' : ''; ?>">
            <i class='bx bxs-file'></i><a href="#">Forms</a>
            <ul class="dropdown-menu">
                <li><a href="branchLetter.php">Letter Generation</a></li>
                <li><a href="branchReferral.php">Referral Form</a></li>
            </ul>
        </li>
        <li>
            <i class='bx bx-history'></i><a href="branchReferralHistory.php">Referral History</a>
        </li>
        <li>
            <i class='bx bxs-cog'></i><a href="branchSettings.php">Settings</a>
        </li>
    </div>
</section>