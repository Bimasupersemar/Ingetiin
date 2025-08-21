<?php
require_once 'config/database.php';
require_once 'function/event.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = updateEventStatus($id, 'selesai');
}
?>
