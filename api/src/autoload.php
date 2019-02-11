<?php
spl_autoload_register(function ($className) {
    $filePath = "classes/$className.php";
    if (file_exists($filePath)) {
        require_once $filePath; 
        return true; 
    }
    return false;
});
