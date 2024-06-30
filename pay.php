<?php
include 'functions.php';
$payment_id = $_GET['id'];
$payment_info = get_invoice($payment_id);

$date_created = date_create_from_format('Y-m-d H:i:s', $payment_info['time']);
$date_until = date_create_from_format('Y-m-d H:i:s', $payment_info['valid_until']);
if(date_create()>$date_until){
    die('Счёт просрочен');
}
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
        <div class="p-3 m-auto">
            <h1>Счёт на <?= $payment_info['amount']; ?> рублей</h1>
            <p>
                <span> <?= htmlspecialchars($payment_info['comment']) ?> </span><br>
                <span class="text-muted">Счёт создан <?= date_format($date_created, 'H:i:s'); ?>, оплатите до <?= date_format($date_until, 'H:i:s'); ?></span>
            </p>

            <div class="mt-3 mb-3 flex-column gap-2 d-flex container">
                <?php
                    createMethod($payment_id, 'yoo.png', 'ЮMoney', 'Оплатите кошельком ЮMoney', 'card');
                    createMethod($payment_id, 'card.png', 'Карта', 'Оплатите картой банка РФ', 'yoomoney');
                    createMethod($payment_id, 'sbp.png', 'Система быстрых платежей', 'Переведите определенную сумму средств по СБП', 'sbp');
                    createMethod($payment_id, 'beeline.png', 'Билайн', 'Оплатите балансом Билайна', 'beeline');
                    createMethod($payment_id, 'mts.svg', 'МТС', 'Оплатите балансом МТС', 'mts');
                    createMethod($payment_id, 'megafon.png', 'Мегафон', 'Оплатите балансом Мегафона', 'megafon');
                ?>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>