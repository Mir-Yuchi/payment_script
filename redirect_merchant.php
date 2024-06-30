<?php
    include 'functions.php';
    $methods_m = ['beeline', 'mts', 'megafon'];
    $payment_info = get_invoice($_GET['id']);
    if($payment_info['is_paid'] == 1){
        die("Счёт уже оплачен.");
    }

    if(in_array($_GET['method'], $methods_m)){
        header('Location: mobile.php?id='.urlencode($payment_info['id']).'&method='.urlencode($_GET['method']));
        die();
    }else if($_GET['method'] == 'sbp'){
        header('Location: sbp.php?id='.urlencode($payment_info['id']));
        die();
    }
?>
<form method="POST" action="https://yoomoney.ru/quickpay/confirm" id="form">
    <input type="hidden" name="receiver" value="<?= $ym_number; ?>"/>
    <input type="hidden" name="label" value="<?= $payment_info['id'] ?>"/>
    <input type="hidden" name="quickpay-form" value="button"/>
    <input type="hidden" name="sum" value="<?= $payment_info['amount'] ?>" data-type="number"/>
    <input type="hidden" name="successURL" value="<?= $success_url ?>?id=<?= $payment_info['id'] ?>" />
</form>

<script>
window.localStorage.setItem("pay_id", "<?= htmlspecialchars($payment_info['id']) ?>");
document.getElementById('form').submit();</script>