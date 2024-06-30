<?php

include 'functions.php';
header("Location: pay.php?id=".strval(new_invoice(floatval($_GET['amount']), $_GET['comment'], $_GET['notification_url'])));