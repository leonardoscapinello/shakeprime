<?php
require_once(__DIR__ . "../../settings/orchestrator.php");
require_once(__DIR__ . "/settings/pags.php");

if (!$account->isLogged()) {
    header("location: " . LOGIN_PAGS);
    die();
}

$isForceReset = $account->isForceReset();
if ($isForceReset) {
    header("location: " . REGISTER_PAGS . "/" . $isForceReset);
    die();
}

$less->compileFile("static/less/pags.less", "static/stylesheet/pags.min.css");
$less->compileFile("static/less/container.less", "static/stylesheet/container.min.css");
//$less->compileFile("../../account/less/container.less", "account/css/container.min.css");


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
    <link href="<?= PAGS_STYLESHEET ?>container.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>fontawesome5.css" rel="stylesheet" type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>sweetalert2.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet"
          type="text/css"/>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery.mask.js"></script>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!--[if (lt IE 9)]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.helper.ie8.js"></script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>

</head>
<body>
<div id="wrapper">


    <div class="masterbar">
        <div class="mb_structure">
            <div class="item">

                <div class="full-center">
                    <div class="company_menu">
                        <img src="<?= PAGS_IMAGES ?>pags-logo.png">
                    </div>
                    <div class="action_menu">
                        <div class="project">
                            <div class="heading">Empresa</div>
                            <div class="company_name">ShakePrime</div>
                        </div>
                        <div class="project">
                            <div class="heading">Unidade</div>
                            <div class="company_name">São Bernardo do Campo</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="full-center">
                    <ul class="navigation">
                        <li><a href="<?=WELCOME_PAGS?>" class="active" data-text="Dashboard"><i class="far fa-window"></i></a></li>
                        <li><a href="<?=SERVER?>" data-text="ShakePrime"><i class="far fa-globe"></i></a></li>
                        <li><a href="<?=LOGOUT_PAGS?>" data-text="Desconectar"><i class="far fa-power-off"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="item">
                <div class="full-center">
                    <div class="profile_menu">
                        <img src="<?= PAGS_IMAGES ?>profile/no-photo.svg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="sidebar open">
        <ul class="navigation">
            <li><a href="#" class="active" data-text="Dashboard"><i class="far fa-tachometer-slowest"></i> Dashboard</a>
            </li>
            <li><span>Clientes</span></li>
            <li><a href="#"><i class="far fa-user-plus"></i> Cadastrar</a></li>
            <li><a href="#"><i class="far fa-users"></i> Lista de Clientes</a></li>
            <li><span>Pedidos</span></li>
            <li><a href="#"><i class="far fa-cart-plus"></i> Novo Pedido</a></li>
            <li><a href="#"><i class="far fa-bars"></i> Lista de Pedidos</a></li>
            <li><span>Estoque</span></li>
            <li><a href="#"><i class="far fa-boxes"></i> Ver Estoque</a></li>
            <li><a href="#"><i class="far fa-people-carry"></i> Adicionar Remessa</a></li>
            <li><span>Agenda</span></li>
            <li><a href="#"><i class="far fa-calendar-plus"></i> Novo Evento</a></li>
            <li><a href="#"><i class="far fa-calendar-alt"></i> Nova Avaliação</a></li>
        </ul>
    </div>-->
    <div class="sidebar open">
        <?php echo $module->getSidebarNavigation() ?>
    </div>
    <div class="content">

        <div class="content main">
            <div id="dashview">

                <h3 class="c__title"><?= $module->getModuleTitle() ?></h3>
                <?php $module->getContent(); ?>


            </div>
        </div>
    </div>


</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $('.small_token').mask('000-000', {clearIfNotMatch: true});
        $('.date').mask('00/00/0000', {clearIfNotMatch: true});
        $('.time').mask('00:00:00', {clearIfNotMatch: true});
        $('.date_time').mask('00/00/0000 00:00:00', {clearIfNotMatch: true});
        $('.cep').mask('00000-000', {clearIfNotMatch: true});
        $('.phone').mask('0000-0000', {clearIfNotMatch: true});
        $('.mobile').mask('(00) 0 0000-0000', {clearIfNotMatch: true});
        $('.phone_with_ddd').mask('(00) 0000-0000', {clearIfNotMatch: true});
        $('.phone_us').mask('(000) 000-0000', {clearIfNotMatch: true});
        $('.mixed').mask('AAA 000-S0S', {clearIfNotMatch: true});
        $('.cpf').mask('000.000.000-00', {reverse: true, clearIfNotMatch: true});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true, clearIfNotMatch: true});
        $('.money').mask('000.000.000.000.000,00', {reverse: true, clearIfNotMatch: true});
        $('.money2').mask("#.##0,00", {reverse: true, clearIfNotMatch: true});
        $('.number').mask("00.00", {reverse: true, clearIfNotMatch: false});
    });

    $(document).ready(function () {

        function clearAdressForm() {
            $("#zipcode").val("");
            $("#address").val("");
            $("#neighborhood").val("");
            $("#state").val("");
            $("#city").val("");
            $("#number").val("");
        }

        $(".cep").blur(function () {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    $("#address").val("...");
                    $("#neighborhood").val("...");
                    $("#state").val("...");
                    $("#city").val("...");
                    $("#number").val("");
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                        if (!("erro" in dados)) {
                            $("#address").val(dados.logradouro);
                            $("#neighborhood").val(dados.bairro);
                            $("#city").val(dados.localidade);
                            $("#state").val(dados.uf);

                            $("#address").prop("readonly", "readonly");
                            $("#neighborhood").prop("readonly", "readonly");
                            $("#city").prop("readonly", "readonly");
                            $("#state").prop("readonly", "readonly");


                            $("#number").focus();
                        } else {
                            clearAdressForm();
                            alert("CEP não encontrado.");
                            $("#zipcode").focus();
                        }
                    });
                } else {
                    clearAdressForm();
                    $("#zipcode").focus();
                }
            } else {
                clearAdressForm();
            }
        });
    });

    var slider = tns({
        container: '.productsSlideCart',
        items: 9.5,
        width: 800,
        center: false,
        loop: true,
        "mouseDrag": false,
        "speed": 1000,
        "controlsPosition": "bottom",
        slideBy: 10
    });


</script>
</html>