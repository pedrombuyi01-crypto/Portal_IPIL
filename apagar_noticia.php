<?php

session_start();
require_once "conecxao.php";

// Só administradores podem apagar
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "administrador") {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = (int) $_GET['id']; // Converte para inteiro - protege contra SQL injection

    $sql = "DELETE FROM noticias WHERE id = $id";
    mysqli_query($conn, $sql);

    header("Location: admin.php");
    exit();

} else {
    header("Location: admin.php");
    exit();
}