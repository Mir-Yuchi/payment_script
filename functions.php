<?php
include 'config.php';

function escape($str){ global $mysql; return $mysql->escape_string($str); }

function new_invoice($amount, $comment, $notification_url = "https://example.org", $time_to_pay = 300){
    global $mysql;
    /*
    Создает новый счет и возвращает его ID

    Amount - сумма счёта
    Comment - Комментарий
    time_to_pay - Время на оплату в секундах
    */

    $id = random_int(0, 9999999);
    $special = random_int(0, 450);

    $mysql->query("INSERT INTO `invoices`(`id`, `amount`, `special_number`, `time`, `valid_until`, `is_paid`, `comment`, `notification_url`) 
    VALUES ('".escape($id)."', '".escape($amount)."', '".escape($special)."', CURRENT_TIMESTAMP, DATE_ADD(CURRENT_TIMESTAMP, INTERVAL ".strval(intval($time_to_pay))." second), 0, '".escape($comment)."', '".escape($notification_url)."')");
    
    return $id;
}

function get_invoice($id){
    global $mysql;
    return $mysql->query("SELECT * FROM invoices WHERE id = '".escape($id)."';")->fetch_array();
}

function set_paid($id){
    global $mysql;
    $mysql->query("UPDATE invoices SET is_paid = 1 WHERE id = '".escape($id)."';");
    return $mysql->error;
}


function createMethod($payment_id, $icon, $name, $desc, $method='card', $color="primary", $textcolor="white"){
    echo '<div class="method mw-40 rounded bg-'.$color.' text-'.$textcolor.' d-flex" style="height: 4.5rem;" onclick="window.location.href=\'redirect_merchant.php?id='.urlencode($payment_id).'&method='.urlencode($method).'\'">
    <div class="mt-auto mb-auto ms-3 d-flex flex-direction-row gap-3">
        <img src="icons/'.$icon.'" class="icon"/>
        <div>
            <b>'.$name.'</b><br>
            <span>'.$desc.'</span>
        </div>
    </div>
</div>';
}

function send_notify($url, $info){
    global $secret_key;
    if($url == 'SELF_BOTT'){
        // Отправляем уведом сами себе
        $sign = md5($info['comment'].':'.strval($info['amount']*100).'RUB'.$secret_key);
        $url = 'https://api.bot-t.com/payment/custom-link';
        $content = json_encode([
            'order_id'=> $info['comment'],
            'sum'=> floatval($info['amount']*100),
            'currency'=>'RUB',
            'sign'=> $sign
        ]);
    }else{
        $content = json_encode([
            'amount'=> $info['amount'],
            'comment'=> $info['comment'],
            'id'=> $info['id'],
            'is_paid'=> $info['is_paid'],
            'time'=> $info['time'],
            'valid_until'=> $info['valid_until']
        ]);
    }
    $sign = hash_hmac('sha256', $content, $secret_key);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json", "X-Signature: ".$sign));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);
    curl_close($curl);
}

function mysql_to_ymdate($time){
    return urlencode(strval(date_create_from_format('Y-m-d H:i:s', $time)->format(DateTime::RFC3339_EXTENDED)));
}

function get_magic_amount($info){
    return $info['amount']+($info['special_number']/100);
}

function check_topups_viamagic($id){
    global $ym_token;
    $info = get_invoice($id);
    $magic_amount = get_magic_amount($info);
    $date_until = date_create_from_format('Y-m-d H:i:s', $info['valid_until']);
    
    $c = "records=20&type=deposition&from=".mysql_to_ymdate($info['time'])."&to=".mysql_to_ymdate($info['valid_until']);
    $curl = curl_init("https://yoomoney.ru/api/operation-history");
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/x-www-form-urlencoded", "Content-Length: ".strval(strlen($c)),"Authorization: Bearer ".$ym_token));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $c);

    $json_response = json_decode(curl_exec($curl),true);
    curl_close($curl);
    foreach($json_response['operations'] as $k=>$op){
        if($op['amount'] == $magic_amount && $date_until > date_create()){ return true; }
    }
    return false;
}
