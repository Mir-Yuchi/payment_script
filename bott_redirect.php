<?php

include 'functions.php';
header("Location: pay.php?id=".strval(new_invoice(floatval($_GET['sum'])/100, $_GET['order_id'], 'SELF_BOTT')));