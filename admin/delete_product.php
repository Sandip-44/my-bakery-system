<?php
    session_start();
    require_once '../config/database.php';
    if(!isset($_SESSION['admin_logged_in'])){ header('Location: login.php'); exit; }
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $conn = getDBConnection();
        $stmt = $conn->prepare('DELETE FROM products WHERE id=?');
        $stmt->bind_param('i',$id); $stmt->execute();
    }
    header('Location: dashboard.php'); exit;
    ?>