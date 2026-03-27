<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<nav class="admin-navbar">
    <a class="admin-brand" href="index.php">
        <i class="fas fa-store"></i>
        Ecommerce Admin
    </a>
    <div class="admin-nav-right">
        <?php if (
            isset($_SESSION["admin_logged_in"]) &&
            $_SESSION["admin_logged_in"] === true
        ): ?>
            <span style="color:rgba(255,255,255,0.5); font-size:13px; margin-right:4px;">
                <?php echo htmlspecialchars(
                    $_SESSION["admin_email"] ?? "",
                    ENT_QUOTES,
                    "UTF-8",
                ); ?>
            </span>
            <a class="admin-nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Sign out
            </a>
        <?php else:$uriAr = explode("/", $_SERVER["REQUEST_URI"]);
            $page = end($uriAr);
            if ($page !== "login.php"): ?>
                <a class="admin-nav-link" href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php endif;endif; ?>
    </div>
</nav>
