<?php

require_once(__DIR__ . "/../../settings/orchestrator.php");
require_once(__DIR__ . "/../settings/pags.php");
$token = get_request("token");
$smallToken = get_request("small_token");
$password = get_request("password");

if ($token === null) {
    header("location: " . WELCOME_PAGS);
    die();
} else {

    $accountToken->load($token);

    if ($accountToken->getSmallToken() !== str_replace("-", "", $smallToken)) {

        header("location: " . REGISTER_PAGS . "/" . $token . "?sm=error");
        die();

    } else {

        if ($password !== null) {
            $id_account = $accountToken->getIdAccount();

            error_log("Setting reset password");
            error_log("id_account > " . $id_account);
            error_log("password > " . $password);

            $account->setAsPrime($id_account, "Y");
            $account->changePassword($password, $id_account);

            header("location: " . LOGOUT_PAGE);
            die();
        }

    }
}

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

    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery.mask.js"></script>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>/sweetalert2.min.js"></script>
</head>
<body class="dark">
<div id="wrapper">
    <form name="login" action="./reset" method="POST">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="hidden" name="small_token" value="<?= $smallToken ?>">
        <div class="account_box">
            <div class="company_login">
                <img src="<?= PAGS_IMAGES ?>pags-logo-extensive.png">
            </div>

            <div style="width:100%;height:5px;background:rgba(255,255,255,.05);position: relative;border-radius:5px;overflow: hidden;margin-top:10px;">
                <div style="width:66%;background:#00BFED;position: absolute;top:0;left:0;height:5px;"></div>
            </div>


            <h1 style="font-size:2.3em;color: #FFFFFF;margin-top:20px;">Agora, é hora da segurança!</h1>

            <p>Essa é a última etapa de verificação de sua conta. Digite uma senha abaixo para finalizar seu cadastro
                como <b>Prime</b>.</p>

            <div class="form_input">
                <input type="password" placeholder="Crie sua senha" id="password" class="password"
                       name="password">
                <label for="password">
                    <span class="floating_icon"><i class="far fa-key"></i></span>
                </label>
            </div>
            <div class="form_input">
                <button>Definir Senha</button>
            </div>
        </div>
    </form>
    <div class="video_background">
        <video autoplay="" loop="" muted="" oncanplay="this.play()" onloadedmetadata="this.muted = true"
               src="<?= PAGS_MEDIA ?>sign_in@2x.mp4" style="opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"></video>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $('.small_token').mask('000-000', {clearIfNotMatch: true});
    });
</script>
</html>