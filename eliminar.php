<?php 
  require_once 'conexion.php';
  $id=base64_decode($_GET['id']);
  $sql ="DELETE FROM `productos` WHERE id=$id";
  $datos = $con->query($sql);
  //Redirecciona al index, después de borrar 
  header("location:index.php");
?>