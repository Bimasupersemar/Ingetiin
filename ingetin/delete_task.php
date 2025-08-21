<?php
session_start();
require_once 'function/tasks.php';

if (!isset($_GET['id'])) {
    $_SESSION['pesan'] = 'Task ID tidak valid!';
    header('Location: tasks.php');
    exit;
}

if (deleteTask($_GET['id'])) {
    $_SESSION['pesan'] = 'Tugas berhasil dihapus!';
} else {
    $_SESSION['pesan'] = 'Gagal menghapus tugas!';
}

header('Location: tasks.php');
exit;
?>