<header class="shadow-sm p-3 d-flex w-100" style="height:100px">
    <div class="col-6 pt-3">
        <img src="" alt="LOGO" class="navbar-brand">
        <a class="navbar-brandz" href="index.php">南港展覽館接駁專車系統</a>
    </div>
    <div class="col-6 row align-items-center justify-content-end pt-3 ">
        <a href="admin.php">系統管理</a>
        <?php
        if (isset($_SESSION['login'])) {
            echo "<a href='./api/logout.php'  class='mx-2'>登出</a>";
        }

        ?>
    </div>
</header>