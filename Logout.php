<?php
    include "Connection.php";
    $db->query("DROP TRIGGER IF EXISTS `memdel1`");
    session_destroy();
    header("Location: index.php");  
?>