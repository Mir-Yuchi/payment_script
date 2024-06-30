<?php
include 'functions.php';
$payment_id = $_GET['id'];
$payment_info = get_invoice($payment_id);
$date_created = date_create_from_format('Y-m-d H:i:s', $payment_info['time']);

$date_until = date_create_from_format('Y-m-d H:i:s', $payment_info['valid_until']);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $name ?></title>
    <link rel="stylesheet" href="css/index.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="w-100 d-flex" style="height: 100vh;">
        <div class="w-40 m-auto">
            <h1>Оплата по СБП</h1>
            <p>
                <span>Переведите <?= get_magic_amount($payment_info); ?> рублей на ЮMoney, по номеру <?= $phone ?></span><br><br>
                <span>Все коммиссии перевода лежат на вас. Оплата должна быть произведена одним платежом, c точностью до копеек.</span><br><br>
                <span class="text-muted">Счёт создан <?= date_format($date_created, 'H:i:s'); ?>, оплатите до <?= date_format($date_until, 'H:i:s'); ?></span>
            </p>
            <button class="btn btn-primary w-100" onclick="window.location.href='status.php?id=<?= urlencode($payment_id) ?>&method=sbp'">Я оплатил</button>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>