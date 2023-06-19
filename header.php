<header class="shadow-sm p-3 d-flex w-100 bg-light" style="height:100px">
<a class="text-reset text-decoration-none" href="index.php">
            <img src="./icon/LOGO.png" alt="LOGO" height=80px>
        </a>
    <a class="text-reset text-decoration-none" href="index.php">
            <h1 class="text-secondary pt-2">南港展覽館接駁專車系統</h1>
        </a>
    <div class="col-6 row align-items-center justify-content-end">
        <a href="admin.php" class="mx-2 text-reset text-decoration-none">&#x1F527;系統管理</a>
        <?php
        if (isset($_SESSION['login'])) {
            echo "<a href='./api/logout.php'  class='mx-2 text-reset text-decoration-none'>&#x1F464;登出(logout)</a>";
        }

        ?>

    </div>
</header>