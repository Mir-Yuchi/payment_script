<?php
    header('Content-Type: text/plain');
    include 'functions.php';
    if(check_topups_viamagic($_GET['id']) ){
        if(get_invoice($_GET['id'])['is_paid'] == 0){
            set_paid($_GET['id']);
            $info = get_invoice($_GET['id']);
            send_notify($info['notification_url'], $info);
        }
        echo 'paid';
    }
?>