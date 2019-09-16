<?php
$product = get_request("product");


if (get_request("product") !== null) {
    $id_product = get_request("product");

    if (get_request("stock_quantity") !== null) {
        $quantity = get_request("stock_quantity");
        if ($stock->addProduct2Stock($id_product, $quantity)) {
            //error_log("adicionando isso");
            header("Refresh: 0");
        } else {
            header("location: edit?product=" . $id_product . "&qt=low");
        }
    }

    $products->load($id_product);
}


?>

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-8">
        <div class="widget">

            <input type="hidden" value="register" name="action">

            <h4>Informações do Produto</h4>

            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xl-4">
                    <div class="thumb">
                        <img src="<?= PAGS_IMAGES ?>/products/default/<?= $products->getProductImage(); ?>"
                             style="border-radius:5px;">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12 col-xl-8">
                    <div class="product_name"><?= $charset->singleUTF8(base64_decode($products->getProductName())); ?></div>
                    <table width="100%">
                        <tr>
                            <td width="175">Quantidade em Estoque</td>
                            <td><?= $products->getStockQuantity(); ?> unidades</td>
                        </tr>
                        <tr>
                            <td>Preço de Venda</td>
                            <td>R$ <?= $number->singleMoney($products->getSalePrice()); ?></td>
                        </tr>
                        <tr>
                            <td>Preço de Compra 25%</td>
                            <td>R$ <?= $number->singleMoney($products->getLevelPriceA()); ?></td>
                        </tr>
                        <tr>
                            <td>Preço de Compra 35%</td>
                            <td>R$ <?= $number->singleMoney($products->getLevelPriceB()); ?></td>
                        </tr>
                        <tr>
                            <td>Preço de Compra 42%</td>
                            <td>R$ <?= $number->singleMoney($products->getLevelPriceC()); ?></td>
                        </tr>
                        <tr>
                            <td>Preço de Compra 50%</td>
                            <td>R$ <?= $number->singleMoney($products->getLevelPriceD()); ?></td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <p>Digite um valor para adicionar ao estoque.</p>
            <form action="" method="POST">

                <div class="form_input">
                    <input autocomplete="off" type="number" id="stock_quantity"
                           value="0"
                           name="stock_quantity"
                           placeholder="Quantidade encomenda" class="number">
                    <label for="email">
                        <span class="floating_icon"><i class="far fa-calculator"></i></span>
                    </label>
                </div>

                <div class="form_input">
                    <button>Adicionar ao estoque</button>
                </div>
            </form>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    <?php if(get_request("qt") === "low"){ ?>
    const Added = Swal.mixin({
        toast: false,
        type: 'error',
        title: 'Você tem certeza?',
        text: 'Você está tentando adicionar quantidade igual ou menor a 0 (zero). Considere valores positivos e superiores a zero.',
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 4000
    });
    window.setTimeout(function () {
        Added.fire({
            onClose: () => {
                window.history.pushState({}, document.title, "/" + '<?=BASE_PATH_PAGS . $this->getModuleURLByKey("P00007", true) . "?product=". $id_product ?>');
            }
        });

    }, 100);
    <?php } ?>
</script>
