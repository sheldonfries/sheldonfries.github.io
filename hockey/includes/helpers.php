<?php

    function render($view, $values = [])
    {
        extract($values);
        
        require("views/header.php");
        require("views/{$view}");
        require("views/footer.php");
        exit;
    }
    
?>