<?php

require_once(__DIR__ . "/../../settings/orchestrator.php");
require_once(__DIR__ . "/../settings/pags.php");
$error = "";
if (!$account->isLogged()) {
    if (get_request("action") === "authenticate") {
        $account->setAuthUsername(get_request("username"));
        $account->setAuthPassword(get_request("password"));
        if ($account->login()) {
            header("location: " . WELCOME_PAGS);
            die();
        } else {
            $error = "password-no-match";
        }
    }
} else {
    header("location: " . WELCOME_PAGS);
    die();
}

$less->compileFile("../static/less/pags.less", "../static/stylesheet/pags.min.css");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8"/>
    <title>ShakePrime - A Expansão dos seus Sonhos!</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <link rel="apple-touch-icon" href="root/pags/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="root/pags/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="root/pags/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="root/pags/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="<?= PAGS_STYLESHEET ?>pags.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>container.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>fontawesome5.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet"
          type="text/css"/>
</head>
<body class="dark">
<div id="wrapper">
    <form name="login" action="" method="POST">
        <input type="hidden" name="action" value="authenticate">
        <div class="account_box">
            <div class="company_login">
                <img src="<?= PAGS_IMAGES ?>pags-logo-extensive.png">
            </div>
            <p>Seja bem-vindo(a) ao portal <b>ShakePrime</b> exclusivo para Gestão de Negócios. Entre com seus dados
                para
                continuar.</p>
            <?php if ($error !== "") { ?>
                aaa
            <?php } ?>
            <div class="form_input">
                <input type="text" placeholder="Email" id="username" name="username">
                <label for="username">
                    <span class="floating_icon"><i class="far fa-envelope"></i></span>
                </label>
            </div>
            <div class="form_input">
                <input type="password" placeholder="Senha" name="password" id="password">
                <label for="password">
                    <span class="floating_icon"><i class="far fa-key"></i></span>
                </label>
            </div>
            <div class="form_input">
                <button>Fazer Login</button>
            </div>
        </div>
    </form>
    <div class="video_background">
        <video autoplay="" loop="" muted="" oncanplay="this.play()" onloadedmetadata="this.muted = true"
               src="<?= PAGS_MEDIA ?>sign_in@2x.mp4" style="opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"></video>
    </div>
</div>
</body>
<script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery-2.1.0.js"></script>
</html>