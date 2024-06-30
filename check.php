<?php
    header('Content-Type: text/plain');
    include 'functions.php';
    if(get_invoice($_GET['id'])['is_paid'] == 1){
        echo 'paid';
    }
?>