<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
    <title><?php echo !is_null($this -> title) ? "Ассистент | {$this -> title}" : "Ассистент"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Serif|Ubuntu&display=swap" rel="stylesheet">
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <script type="text/javascript" src="/global-assets/js/alerts-confirms.js?122"></script>
    <script type="text/javascript" src="/global-assets/js/global.js?2"></script>
    <script type="text/javascript" src="/global-assets/js/download.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
    <link rel="stylesheet" href="/global-assets/css/styles.css?<?php echo time(); ?>">
    <link rel="icon" href="https://emojipedia-us.s3.dualstack.us-west-1.amazonaws.com/thumbs/120/apple/237/female-scientist_1f469-200d-1f52c.png">
</head>

<body>
    <div id="alerts-area"></div>
    <div class="modal fade" style="z-index: 10000000; background: rgba(0, 0, 0, 0.3);" role="dialog" tabindex="-1" id="modal-spinner" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 8rem; margin: 0 auto;">
            <div class="modal-content">
                <div class="modal-body d-flex justify-content-center">
                    <div class="spinner-grow" style="width: 5rem; height: 5rem;" role="status">
                        <span class="sr-only">Загрузка...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>