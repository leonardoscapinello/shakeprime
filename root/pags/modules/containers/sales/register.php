<?php
$user = get_request("user");
$cart = get_request("cart");
$remove = get_request("remove");

$updateLevel = get_request("updateLevel");
$progress = false;
$name = $email = $birthday = "";

$sold_price_total = 0;
$sale_price_total = 0;
$purchase_price_total = 0;
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

    if ($sales->getIsClosed() === "Y") {
        header("location: " . $this->getModuleURLByKey("P00014") . "?cart=" . $cart);
        die;
    }

    if ($remove !== null) {
        $sales->removeCart($cart);
        header("location: " . $this->getModuleURLByKey("P00015") . "?cart=" . $cart);
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

    $discount_level = $account->getDiscountLevel();
    $purchase_level = "sale_price";
    if ($discount_level === "25") $purchase_level = "level_price_a";
    if ($discount_level === "35") $purchase_level = "level_price_b";
    if ($discount_level === "42") $purchase_level = "level_price_c";
    if ($discount_level === "50") $purchase_level = "level_price_d";

    for ($i = 0; $i < count($list); $i++) {
        $sold_price_total_iter = $list[$i]['quantity'] * $list[$i]['sold_price'];
        $sale_price_total_iter = $list[$i]['quantity'] * $list[$i]['sale_price'];
        $volume_total_iter = $list[$i]['quantity'] * $list[$i]['volume'];
        $product_purchase_price = $list[$i]['quantity'] * $list[$i][$purchase_level];


        $sold_price_total = $sold_price_total + $sold_price_total_iter;
        $sale_price_total = $sale_price_total + $sale_price_total_iter;
        $volume_total = $volume_total + $volume_total_iter;
        $purchase_price_total = $purchase_price_total + $product_purchase_price;

    }

    $profit = ($sold_price_total - $purchase_price_total);
    $sales->setTotals($cart, $sale_price_total, $sold_price_total, $volume_total, $profit, $purchase_price_total);


} else {
    $selectUser = true;
}

if ($selectUser) {
    header("location: " . $this->getModuleURLByKey("P00003") . "?startShopping=Y");
    die();
}

$productList = $products->getList();

?>


<div class="widget products_fixed">


    <div id="prodChoosen">
        <div class="productsSlideCart">
            <?php
            $list = $productList;
            for ($i = 0; $i < count($list); $i++) {
                ?>
                <div onclick="addProduct(<?= $list[$i]['id_product']; ?>);">
                    <img src="<?= PAGS_IMAGES ?>products/default/<?= $list[$i]['product_image']; ?>"
                         class="<?= $list[$i]['stock_quantity'] === "0" ? "nostock" : "instock" ?>">
                    <section class="stock">
                        <?= $list[$i]['stock_quantity'] === "0" ? "Sem estoque" : $list[$i]['stock_quantity'] . " unidade(s)" ?>
                    </section>
                    <aside class="product_widget_info">
                        <p><b>Produto:</b> <?= base64_decode($list[$i]['product_name']); ?></p>
                        <p><b>Preço de Venda:</b> R$ <?= $number->singleMoney($list[$i]['sale_price']); ?></p>
                        <p><b>Pontos de Volume:</b> <?= $list[$i]['volume']; ?></p>
                        <p><b>Quantidade em Estoque:</b> <?= $list[$i]['stock_quantity'] ?></p>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">


            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xl-3">
                    <div class="form_input">
                        <button onClick="window.location.href = './index'">
                            <i class="far fa-list"></i>
                        </button>
                    </div>
                </div>
                <div class="offset-6">

                </div>
                <div class="col-sm-12 col-lg-12 col-xl-3">
                    <div class="form_input">
                        <button onClick="removeCart('<?= $cart ?>')" class="red">
                            <i class="far fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

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
                    <select class="small_select" onchange="updateLevel(this.value);">
                        <option value="0" <?= $sales->getDiscountLevel() === "0" ? "selected" : "" ?>>Sem desconto
                        </option>
                        <option value="25" <?= $sales->getDiscountLevel() === "25" ? "selected" : "" ?>>25% de
                            desconto
                        </option>
                        <option value="35" <?= $sales->getDiscountLevel() === "35" ? "selected" : "" ?>>35% de
                            desconto
                        </option>
                        <option value="42" <?= $sales->getDiscountLevel() === "42" ? "selected" : "" ?>>42% de
                            desconto
                        </option>
                        <option value="50" <?= $sales->getDiscountLevel() === "50" ? "selected" : "" ?>>50% de
                            desconto
                        </option>
                    </select>
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
                <?php if ($sold_price_total > 0) { ?>
                    <div class="form_input">
                        <button onClick="continuePayment('<?= $cart ?>')">Continuar para forma de pagamento</button>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <div class="col-sm-12 col-lg-12 col-xl-8">

        <div class="widget">

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
                    <tr class="selectable small-vh"
                        onClick="editCartItem('<?= $list[$i]['id_sale_product'] ?>','<?= $list[$i]['quantity'] ?>');">
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

    <div id="searchContainer">
        <div class="container">
            <div class="input_search_bigger">
                <input type="search" name="searchProduct" id="searchProduct" value=""
                       placeholder="Digite o nome de um produto">
            </div>

            <div id="product_list_bigger">
                <?php
                $list = $productList;
                for ($i = 0;
                $i < count($list);
                $i++) {
                ?>
                <?php if ($list[$i]['stock_quantity'] === "0") { ?>
                <div class="nostock">
                    <?php } else { ?>
                    <div onclick="addProduct(<?= $list[$i]['id_product']; ?>);" class="instock">
                        <?php } ?>
                        <img src="<?= PAGS_IMAGES ?>products/default/<?= $list[$i]['product_image']; ?>"
                             class="<?= $list[$i]['stock_quantity'] === "0" ? "nostock" : "instock" ?>">
                        <aside class="product_widget_info">
                            <h3 class="productTitleSearch"><?= base64_decode($list[$i]['product_name']); ?></h3>
                            <span>R$ <?= $number->singleMoney($list[$i]['sale_price']); ?></span>
                            <p><b>Quantidade em Estoque:</b> <?= $list[$i]['stock_quantity'] ?></p>
                        </aside>
                    </div>
                    <?php } ?>
                </div>


            </div>
        </div>

    </div>
    <script type="text/javascript">

        function continuePayment(cart) {
            window.location.href = "<?=$this->getModuleURLByKey('P00011'); ?>?cart=" + cart;
        }

        function removeCart(cart) {
            window.location.href = "<?=$this->getModuleURLByKey('P00005'); ?>?remove=Y&cart=" + cart;
        }

        const Toast = Swal.mixin({
            toast: false,
            width: "575px",
            position: 'center-center',
            showConfirmButton: false,
            showCancelButton: false,
            customClass: 'swalFloating'
        });

        <?php if(get_request("add") === "success"){ ?>
        const Added = Swal.mixin({
            toast: false,
            type: 'success',
            title: 'Item adicionado ao carrinho',
            text: 'Só um instante, estamos atualizando os cálculos.',
            showConfirmButton: false,
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 1500
        });
        window.setTimeout(function () {
            Added.fire({
                onClose: () => {
                    window.history.pushState({}, document.title, "/" + '<?=BASE_PATH_PAGS . $this->getModuleURLByKey("P00005", true) . "?cart=" . $sales->getUniqueCode()?>');
                }
            });

        }, 100);
        <?php }else if(get_request("add") === "success"){ ?>
        const Added = Swal.mixin({
            toast: false,
            type: 'success',
            title: 'Item atualizado com sucesso!',
            text: 'Só um instante, estamos atualizando os cálculos.',
            showConfirmButton: false,
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 1500
        });
        window.setTimeout(function () {
            Added.fire({
                onClose: () => {
                    window.history.pushState({}, document.title, "/" + '<?=BASE_PATH_PAGS . $this->getModuleURLByKey("P00005", true) . "?cart=" . $sales->getUniqueCode()?>');
                }
            });

        }, 100);
        <?php }else if(get_request("error") === "stockQuantity"){ ?>
        const Added = Swal.mixin({
            toast: false,
            type: 'error',
            title: 'Quantidade indisponível',
            text: 'Você não tem produto suficiente em estoque. Verifique se outros pedidos não estão reservando produtos desnecessariamente',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 2000
        });
        window.setTimeout(function () {
            Added.fire({
                onClose: () => {
                    window.history.pushState({}, document.title, "/" + '<?=BASE_PATH_PAGS . $this->getModuleURLByKey("P00005", true) . "?cart=" . $sales->getUniqueCode()?>');
                }
            });

        }, 100);
        <?php } ?>

        function addProduct(id_product) {
            Toast.fire({
                html: `<iframe src="<?=PAGS_EDGE?>sales/selectProduct.php?id=${id_product}&cart=<?= $sales->getUniqueCode()?>" style="width:100%;height:280px;border:none;" allowtransparency="true" scrolling="no"></iframe>`,
            });
        }

        function updateLevel(level) {
            window.location.href = "<?=$this->getModuleURLByKey("P00005") . "?cart=" . $sales->getUniqueCode()?>&updateLevel=" + level;
        }

        var typer = "";
        $(document).on('keyup', function (e) {
            var se = document.getElementById("searchProduct");
            var sp = document.getElementById("searchContainer");
            var c = String.fromCharCode(e.which);
            var tag = e.target.tagName.toLowerCase();
            if ((e.which >= 65 && e.which <= 90)) typer = typer + c;
            if (e.which === 8 && se.value.length === 0) {
                sp.style.display = "none";
                se.value = "";
                typer = "";
            }
            if (e.which === 27) {
                sp.style.display = "none";
                se.value = "";
                typer = "";
            }
            if ((e.which >= 65 && e.which <= 90) && tag !== 'input' && tag !== 'textarea') {
                sp.style.display = "block";
                se.focus();
            }
            if (se.value.length < 2 && typer !== "") {
                se.value = typer;
            } else {
                typer = "";
            }

            filterField(se);

        });

        $("#searchContainer").on('click', function (e) {
            var se = document.getElementById("searchProduct");
            var sp = document.getElementById("searchContainer");
            sp.style.display = "none";
            se.value = "";
            typer = "";
        });
        $("#searchProduct").on('click', function (e) {
            e.stopPropagation();
        });

        function filterField(field) {
            var titles = document.getElementsByClassName("productTitleSearch");
            if (titles !== null && titles !== undefined) {
                if (field !== null && field !== undefined) {

                    for (let i = 0; i < titles.length; i++) {
                        var title = sanitizeSearch(titles[i].innerHTML);
                        var value = sanitizeSearch(field.value);
                        if (title.indexOf(value) !== -1) {
                            titles[i].parentElement.parentElement.style.display = "block";
                        } else {
                            titles[i].parentElement.parentElement.style.display = "none";
                        }
                    }


                }
            }
        }

        function sanitizeSearch(str) {
            return str.replace(/[^0-9a-z]/gi, '').replace(/[\u0300-\u036f]/g, "").toLowerCase();
        }

        function editCartItem(id, qtd) {
            Toast.fire({
                html: `<iframe src="<?=PAGS_EDGE?>sales/editProductOnCart.php?id=${id}&cart=<?= $sales->getUniqueCode()?>&qtd=${qtd}" style="width:100%;height:290px;border:none;" allowtransparency="true" scrolling="no"></iframe>`,
            });
        }

    </script>