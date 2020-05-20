<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no user-scalable=no">
    <title>Ассистент настраивается...</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container" style="min-width: 100vw;height: calc(100vh - 155px);margin-top: 150px;padding: 25px;">
        <div class="row" style="max-width: 75vw;margin: 0 auto;">
            <div class="col-md-3"><i class="far fa-window-close" style="font-size: 17vw;"></i></div>
            <div class="col-md-9">
                <h1 style="margin-top: 25px;">Работа кипит</h1>
                <p class="d-block" style="max-width: 71vw;">На данный момент система недоступна в связи с проведением плановых работ. Попробуйте повторить подключение позже.</p><small><strong>ИНФОРМАЦИЯ&nbsp;ДЛЯ&nbsp;АДМИНИСТРАТОРА!</strong> Если вы видете это окно, то разрешите вашему IP адресу работу с системой. Нужно прописать ваш адрес в конфигурационном файле модуля first-start (configuration.php). Ваш IP-адрес: <strong><?php echo CLIENT_IP; ?></strong>.</small>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>