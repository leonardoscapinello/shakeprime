<?php
$user = get_request("user");
$cart = get_request("cart");
$updateLevel = get_request("updateLevel");
$progress = false;
$name = $email = $birthday = "";

$sold_price_total = 0;
$sale_price_total = 0;
$volume_total = 0;

$selectUser = false;

if ($user !== null) {
    $progress = $sales->hasSaleInProgress($user);
    if (!$progress) {
        $progress = $sales->startSale($user);
    }
    if ($progress) {
        header("location: " . $this->getModuleURLByKey("P00005") . "?cart=" . $progress);
        die();
    }
} else {
    $selectUser = true;
}

if ($cart !== null) {
    $selectUser = false;
    $sales->load($cart);

    if ($sales->getIsClosed() === "N") {
        header("location: " . $this->getModuleURLByKey("P00005") . "?cart=" . $cart);
        die;
    }


    $user = $sales->getIdCustomer();
    if ($updateLevel !== null) {
        $sales->updateDiscountLevel($cart, $updateLevel);
        header("location: " . $this->getModuleURLByKey("P00005") . "?cart=" . $cart);
        die();
    }
    $products_list = $salesProducts->getCartProducts($cart);
    $customer->load($user);
    $name = $customer->getName();
    $email = $customer->getEmail();
    $birthday = date("d/m/Y", strtotime($customer->getBirthday()));
    $list = $products_list;
    for ($i = 0; $i < count($list); $i++) {
        $sold_price_total_iter = $list[$i]['quantity'] * $list[$i]['sold_price'];
        $sale_price_total_iter = $list[$i]['quantity'] * $list[$i]['sale_price'];
        $volume_total_iter = $list[$i]['quantity'] * $list[$i]['volume'];

        $sold_price_total = $sold_price_total + $sold_price_total_iter;
        $sale_price_total = $sale_price_total + $sale_price_total_iter;
        $volume_total = $volume_total + $volume_total_iter;


    }
} else {
    $selectUser = true;
}

if ($selectUser) {
    header("location: " . $this->getModuleURLByKey("P00003") . "?startShopping=Y");
    die();
}

$productList = $products->getList();

?>


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">

            <h5>Usuário</h5>

            <div class="form_input">
                <input autocomplete="off" disabled type="text" id="name"
                       value="<?= $name; ?>"
                       name="name"
                       placeholder="Nome do Cliente">
                <label for="name">
                    <span class="floating_icon"><i class="far fa-user"></i></span>
                </label>
            </div>
            <div class="form_input">
                <input autocomplete="off" disabled type="text" id="email"
                       value="<?= $email; ?>"
                       name="email"
                       placeholder="Endereço de E-mail">
                <label for="email">
                    <span class="floating_icon"><i class="far fa-envelope"></i></span>
                </label>
            </div>
            <div class="form_input">
                <input autocomplete="off" disabled type="text" id="email"
                       value="<?= $birthday; ?>"
                       name="email"
                       placeholder="Data de Nascimento" class="date">
                <label for="email">
                    <span class="floating_icon"><i class="far fa-calendar"></i></span>
                </label>
            </div>

            <div class="separator"></div>


            <div class="price_section">
                <div class="price_block">
                    <div class="caption">REGIME DE DESCONTO</div>
                    <div class="price"><?= $sales->getDiscountLevel() ?>% de desconto</div>
                </div>
                <div class="price_block">
                    <div class="caption">CRÉDITOS DO CLIENTE</div>
                    <div class="price" style="font-weight:400;">R$ 0,00</div>
                </div>
                <div class="price_block">
                    <div class="caption">PONTOS DE VOLUME</div>
                    <div class="price" style="font-weight:400;"><?= $number->singleMoney($volume_total) ?> PV</div>
                </div>
                <div class="price_block">
                    <div class="caption">PREÇO DE VENDA</div>
                    <div class="price" style="font-weight:400;">R$ <?= $number->singleMoney($sale_price_total) ?></div>
                </div>
                <div class="price_block">
                    <div class="caption">DESCONTO</div>
                    <div class="price" style="font-weight:400;">-
                        R$ <?= $number->singleMoney($sale_price_total - $sold_price_total) ?></div>
                </div>
                <div class="price_block odd">
                    <div class="caption">VALOR TOTAL DO PEDIDO</div>
                    <div class="price">R$ <?= $number->singleMoney($sold_price_total) ?></div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-12 col-lg-12 col-xl-8">

        <div class="widget">

            <div class="alert alert-info">Essa compra já foi finalizada no
                dia <?= date("d/m/Y H:i:s", strtotime($sales->getSaleDoneDate())) ?></div>

            <h5>Carrinho de Compras</h5>

            <table class="table">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th width="80">QTD</th>
                    <th width="120">PV</th>
                    <th width="120">Preço Unitário</th>
                    <th width="120">Preço Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $list = $products_list;
                for ($i = 0; $i < count($list); $i++) {
                    ?>
                    <tr class="small-vh">
                        <td><?= base64_decode($list[$i]['product_name']) ?></td>
                        <td><?= ($list[$i]['quantity']) ?></td>
                        <td><?= $number->singleMoney($list[$i]['volume']) ?></td>
                        <td>
                            R$ <?= $number->singleMoney($list[$i]['sold_price']) ?>
                        </td>
                        <td>
                            R$ <?= $number->singleMoney($list[$i]['sold_price'] * $list[$i]['quantity']) ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>


        </div>
    </div>
    <div class="clearfix"></div>