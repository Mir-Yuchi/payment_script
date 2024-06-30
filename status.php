<?php include 'config.php'; ?>
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
        <div class="m-auto">
            <h1 id="state">Проверка поступления..</h1>
            <script>
                setInterval(async () => {
                   let r = await (await fetch(`check<?= (isset($_GET['method']) ? '2' : '') ?>.php?id=${encodeURIComponent('<?= htmlspecialchars($_GET['id']) ?>')}`)).text()
                   if(r == 'paid'){
                       document.getElementById('state').innerText = "Успешно оплачено!"
                   } 
                }, 2000);
            </script>

        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>