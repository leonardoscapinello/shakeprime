<?php


require_once("root/settings/orchestrator.php");

$less->compileFile("account/less/landing.less", "account/css/shakeprime.min.css");
$less->compileFile("account/less/container.less", "account/css/container.min.css");
$less->compileFile("account/less/navigation.less", "account/css/navigation.min.css");
$less->compileFile("account/less/slider.less", "account/css/slider.min.css");


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
    <link href="static/css/shakeprime.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="static/css/container.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="static/css/navigation.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="static/css/slider.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="static/css/fontawesome5.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="wrapper">

    <header>
        <div id="header" class="header fixed">
            <div class="container">
                <div class="row">
                    <div class="col col-2">
                        <h1 class="company">ShakePrime</h1>
                    </div>
                    <div class="col col-8">
                        <?php require_once("root/composition/navigation.php"); ?>
                    </div>
                    <div class="col col-2">
                        <ul class="nav right">
                            <li><a href="#"><i class="far fa-user-circle"></i> Fazer Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </header>
    <section>
        <div class="ParallaxVideo inside-content">
            <video autoplay muted loop>
                <source src="static/movie/shakeprime-project.mp4" type="video/mp4">
            </video>
            <div class="container" style="position: relative;">
                <div class="overlayer"></div>
                <div class="col col-6">
                    <h2 class="color white ruge blackcoffee">Nossa História</h2>
                </div>
                <div class="col col-6">&nbsp;</div>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <section>
        <div class="content">
            <div class="container">
                aa
            </div>
        </div>
    </section>
    <footer>
        <div class="section white footer">
            <div class="container">
                <div class="col col-3">
                    <h1 class="company color blackwhite">ShakePrime</h1>
                </div>
                <div class="col col-3">
                    <h4 class="blackcoffee">ShakePrime</h4>
                    <ul class="navigation">
                        <li><a href="#">Nossa História</a></li>
                        <li><a href="#">Missão</a></li>
                        <li><a href="#">Projeto Social</a></li>
                    </ul>
                </div>
                <div class="col col-3">
                    <h4 class="blackcoffee">Expansão</h4>
                    <ul class="navigation">
                        <li><a href="#">Como funciona?</a></li>
                        <li><a href="#">Cadastro</a></li>
                        <li><a href="#">Intranet</a></li>
                    </ul>
                </div>
                <div class="col col-3">
                    <h4 class="blackcoffee">Fale com a gente</h4>
                    <ul class="navigation">
                        <li><a href="#">Suporte</a></li>
                        <li><a href="#">Institucional</a></li>
                        <li><a href="#">Imprensa</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</div>
</body>
<script type="text/javascript" src="<?= JAVASCRIPT_PATH ?>jquery-2.1.0.js"></script>
<script type="text/javascript" src="<?= JAVASCRIPT_PATH ?>gr.js"></script>
<script type="text/javascript" src="<?= JAVASCRIPT_PATH ?>ls.km.jquery.js"></script>
<script type="text/javascript" src="<?= JAVASCRIPT_PATH ?>ls.transitions.js"></script>
<script data-cfasync="false" type="text/javascript">var lsjQuery = jQuery;
    var curSkin = 'noskin';</script>
<script data-cfasync="false" type="text/javascript"> lsjQuery(document).ready(function () {
        if (typeof lsjQuery.fn.layerSlider == "undefined") {
            lsShowNotice('sp_slider', 'jquery');
        } else {
            lsjQuery("#sp_slider").layerSlider({
                responsive: true,
                responsiveUnder: 640,
                layersContainer: 1920,
                startInViewport: true,
                skin: 'fullwidth',
                globalBGColor: 'transparent',
                hoverPrevNext: false,
                autoPlayVideos: false,
                yourLogoStyle: 'left: 10px; top: 10px;',
                skinsPath: 'account/css/slider/',
                thumbnailNavigation: 'hover'
            })
        }
    });

    function slider() {
        var slide = $("#sp_slider");
        var windowHeight = window.innerHeight;
        slide.css("height", windowHeight + "px");
    }

    $(document).ready(function () {
        slider();
    }, 100);

    $(window).scroll(function () {
        var top = $(window).scrollTop();
        var chocolateTop = (top / 10);
        if (chocolateTop > 250) {
            chocolateTop = 250;
        }
        var grapeTop = (top / 10);
        if (grapeTop > 250) {
            grapeTop = 250;
        }


        if (top > 80) {
            $("#header").addClass("scrolling");
        } else {
            $("#header").removeClass("scrolling");
        }
        $("#shakeChocoSensation").stop().animate({"marginTop": (chocolateTop) + "px"}, "slow");
        $("#shakeGrape").stop().animate({"marginTop": (grapeTop) + "px"}, "slow");
    });


</script>
</html>