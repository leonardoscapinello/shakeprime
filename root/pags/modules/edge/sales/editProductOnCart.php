<?php
require_once(__DIR__ . "/../../../../settings/orchestrator.php");
require_once(__DIR__ . "/../../../settings/pags.php");
$id_sales_products = 0;
$cart = "";
$inCartQuantity = 0;
if (get_request("id") !== null) {
    if (get_request("cart") !== null) {
        if (get_request("qtd") !== null) {
            $id_sales_products = get_request("id");
            $cart = get_request("cart");
            $inCartQuantity = get_request("qtd");
            $salesProducts->loadCartProduct($id_sales_products);
        }
    }
}

$stock_quantity = ($salesProducts->getStockQuantity() + $inCartQuantity);


$className = "blurred";


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimuEu m-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicione um Produto ao Carrinho</title>
    <link href="<?= PAGS_STYLESHEET ?>pags.min.css?v=<?php echo date("ymdhis"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>container.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= PAGS_STYLESHEET ?>fontawesome5.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= PAGS_JAVASCRIPT ?>jquery-3.2.0.min.js"></script>
    <style type="text/css">

        html,
        body {
            background: white;
        }

        * {
            padding: 0;
            margin: 0;
        }

        .loader {
        <?=$className==="blurred" ? "display:block;" : "display:none;"?> position: absolute;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 332;
        }


        .loader svg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 333;
        }


        .blurred {
            filter: blur(4px);
        }
    </style>
</head>
<body>
<form action="editProductInfo.php" id="frm">
    <input id="id" name="id" type="hidden" value="<?= $id_sales_products ?>">
    <input id="id" name="cart" type="hidden" value="<?= $cart ?>">
    <input id="action" name="action" type="hidden" value="add">


    <div class="widgetFloating" style="position: relative;">

        <div class="loader loader--style3" title="2">
            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 x="0px" y="0px"
                 width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                 xml:space="preserve">
                <path fill="#000"
                      d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                    <animateTransform attributeType="xml"
                                      attributeName="transform"
                                      type="rotate"
                                      from="0 25 25"
                                      to="360 25 25"
                                      dur="0.6s"
                                      repeatCount="indefinite"/>
                </path>
            </svg>
        </div>

        <div class="row <?= $className ?>">
            <div class="col-4">
                <div class="productImage">
                    <img src="<?= PAGS_IMAGES ?>products/default/<?= $salesProducts->getProductImage(); ?>"
                         class="<?= $stock_quantity === "0" ? "nostock" : "instock" ?>">
                </div>
            </div>
            <div class="col-8">
                <div class="productInfo">
                    <div class="productTitle">
                        <span class="sku">SKU: <?= trim(($salesProducts->getSku())); ?></span>
                        <h3><?= trim(base64_decode($salesProducts->getProductName())); ?></h3>
                    </div>
                    <?php if ($stock_quantity > 0) { ?>
                    <div class="productQuantity">
                        <div class="widget_input">
                            <label for="quantity">
                                <span class="floating_icon">Digite a quantidade (0 para remover):</span>
                            </label>
                            <input autocomplete="off" type="number" id="quantity"
                                   value="<?= $inCartQuantity ?>"
                                   name="quantity"
                                   placeholder="Quantidade" onkeyup="getTotal(this);" onkeypress="getTotal(this);">
                        </div>
                    </div>
                    <div id="productQuantity" class="productQuantity">
                        <div class="widget_input" style="margin-top:10px;">

                            <label for="quantity"
                                   style="display:inline-block;width:50%;height:20px;line-height:20px;">
                                <span class="floating_icon">VALOR UNITÁRIO: R$ <?= $number->singleMoney($salesProducts->getSalePrice()) ?></span>
                            </label>
                            <label for="quantity" style="width:50%;height:20px;line-height:20px;">
                                <span class="floating_icon">VALOR TOTAL: <span id="totalValue">R$ 0,00</span></span>
                            </label>
                            <label for="quantity"
                                   style="display:inline-block;width:50%;height:20px;line-height:20px;">
                                <span class="floating_icon">EM ESTOQUE: <?= str_pad($stock_quantity, 2, "0", STR_PAD_LEFT); ?></span>
                            </label>
                            <label for="quantity" style="width:50%;height:20px;line-height:20px;">
                                <span class="floating_icon">FICARÁ EM ESTOQUE: <span id="restValue"></span></span>
                            </label>
                            <br>
                        </div>
                        <div class="form_input">
                            <button>Atualizar quantidade</button>
                        </div>
                    </div>
                    <div id="productRemoval" class="productQuantity" style="display: none">

                        <div class="alert alert-danger" style="margin-top:10px;">
                            Quantidade inferior a um <strong>removerá</strong> o produto do carrinho!
                        </div>

                        <div class="widget_input" style="margin-top:-10px;">
                            <div class="form_input">
                                <button>Remover do carrinho</button>
                            </div>
                        </div>

                        <?php } else { ?>
                            <div class="productQuantity">
                                <div class="widget_input" style="margin-top:10px;">

                                    <label for="quantity"
                                           style="display:inline-block;width:50%;height:20px;line-height:20px;">
                                        <span class="floating_icon">VALOR UNITÁRIO: R$ <?= $number->singleMoney($salesProducts->getSalePrice()) ?></span>
                                    </label>
                                    <label for="quantity"
                                           style="display:inline-block;width:50%;height:20px;line-height:20px;">
                                        <span class="floating_icon">PONTOS DE VOLUME: <?= $salesProducts->getVolume() ?></span>
                                    </label>

                                    <div class="alert alert-danger" style="margin-top:30px;">
                                        <strong>Produto fora de estoque.</strong><br/>Não pode ser adicionado ao
                                        carrinho.
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

            </div>
        </div>
</form>
<?php if ($stock_quantity > 0) { ?>
    <script type="text/javascript">
        function getTotal() {
            var stock = <?=$stock_quantity?>;
            var productRemoval = document.getElementById("productRemoval");
            var productQuantity = document.getElementById("productQuantity");
            var el = document.getElementById("quantity");
            var total = document.getElementById("totalValue");
            var rest = document.getElementById("restValue");
            var unity = '<?=$salesProducts->getSalePrice();?>';
            if (el.value > 0) {

                productQuantity.style.display = "block";
                productRemoval.style.display = "none";

                if (el.value > stock) {
                    el.value = stock;
                }
                total.innerHTML = "R$ " + (unity * el.value).toFixed(2);

                var resting = stock - el.value;
                if (resting < 10) {
                    resting = "0" + resting;
                }

                rest.innerHTML = resting;
            } else if (el.value < 1) {


                productRemoval.style.display = "block";
                productQuantity.style.display = "none";

                el.value = 0;
            }
        }

        window.setInterval(function () {
            getTotal();
        }, 300);

        function displayLoader() {
            var loader = document.getElementsByClassName("loader");
            var row = document.getElementsByClassName("row");
            if (loader.length > 0) {
                for (var i = 0; i < loader.length; i++) {
                    loader[i].style.display = "block";
                }
            }
            if (row.length > 0) {
                for (var i = 0; i < row.length; i++) {
                    row[i].className = "row blurred";
                }
            }
        }


        $("#frm").on('submit', function (e) {
            displayLoader();
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (data) {
                    if (data.trim() === "biggerThanStock") {
                        window.top.location.href = window.top.location.href + "&error=stockQuantity";
                    } else {
                        window.top.location.href = window.top.location.href + "&upd=success";
                    }
                }
            });
        });


    </script>
<?php } ?>
<script type="text/javascript">
    function hideLoader() {
        var loader = document.getElementsByClassName("loader");
        var row = document.getElementsByClassName("row");
        if (loader.length > 0) {
            for (var i = 0; i < loader.length; i++) {
                loader[i].style.display = "none";
            }
        }
        if (row.length > 0) {
            for (var i = 0; i < row.length; i++) {
                row[i].className = "row";
            }
        }
    }

    window.setTimeout(function () {
        hideLoader();
    }, 250);
</script>
</body>
</html>