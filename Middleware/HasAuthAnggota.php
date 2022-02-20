<?php

$is_login = $_SESSION['is_login'] ?? 0;
$is_anggota = ($_SESSION['role'] ?? null) === "ANGGOTA";

if ($is_login == 0) {
    header('location: index.php');
    die();
}

if (!$is_anggota) {
    ob_start();

    require_once __DIR__ . '/../403.php';

    $view = ob_get_clean();

    reset_session_flash();

    echo $view;

    die();
}