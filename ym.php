<?php

include 'functions.php';
$hash = hash('sha1', implode('&',[$_POST['notification_type'], $_POST['operation_id'], $_POST['amount'], $_POST['currency'], $_POST['datetime'], $_POST['sender'], $_POST['codepro'], $ym_secret, $_POST['label']]));
if(hash_equals($hash, $_POST['sha1_hash']) && (!isset($_POST['test_notification']))) {
    $payment_id = intval($_POST['label']);
    $info = get_invoice($payment_id);
    $date_created = date_create_from_format('Y-m-d H:i:s', $info['time']);
    $date_until = date_create_from_format('Y-m-d H:i:s', $info['valid_until']);
    if($info['is_paid'] == 0){
        set_paid($payment_id);
        $info['is_paid'] = 1;
        send_notify($info['notification_url'], $info);
    }
}