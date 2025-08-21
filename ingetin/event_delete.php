<?php
require_once 'config/database.php';

// Pastikan ada parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: event_list.php");
    exit;
}

$id = intval($_GET['id']);

// Hapus event dari database
$query = "DELETE FROM event WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirect kembali ke daftar event
    header("Location: event.php");
    exit;
} else {
    echo "Gagal menghapus event.";
}
?>
