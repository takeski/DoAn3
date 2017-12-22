<?php
    session_start();
    unset($_SESSION["account"]);
    header("Location: /");
    exit(0);
?>