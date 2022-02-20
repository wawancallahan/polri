<?php
    $role = $_SESSION['role'] ?? null;
?>
<ul class="navbar-nav">
    <li class="nav-item">
        <a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
    </li>
    <?php if ($role === 'ADMIN') { ?> 
        <li class="nav-item">
            <a href="anggota.php" class="nav-link"><i class="fas fa-user"></i><span>Anggota</span></a>
        </li>
        <li class="nav-item">
            <a href="regu.php" class="nav-link"><i class="fas fa-users"></i><span>Regu</span></a>
        </li>
    <?php } ?>

    <?php if ($role === 'ANGGOTA') { ?>
    <li class="nav-item">
        <a href="regu_ketua_anggota.php" class="nav-link"><i class="fas fa-users"></i><span>Regu</span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </li>
</ul>