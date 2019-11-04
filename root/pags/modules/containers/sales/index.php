<?php
$filter = get_request("q");
?>
<div class="search row">
    <div class="offset-8"></div>
    <div class="col col-4">
        <div class="form_input">
            <form action="">
                <input type="text" name="q" id="q" placeholder="Digite o protocolo de uma venda ou nome do cliente"
                       value="<?= $filter ?>">
                <label for="q">
                    <span class="floating_icon"><i class="far fa-search"></i></span>
                </label>
            </form>
        </div>
    </div>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Nome do Cliente</th>
        <th>Protocolo</th>
        <th>Valor do Pedido</th>
        <th>Lucro</th>
        <th>Desconto</th>
        <th>Volume</th>
        <th>Data de Inicio</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($filter !== null) {
        $list = $sales->getSalesWithFilter($filter);
    } else {
        $list = $sales->getSales();
    }
    for ($i = 0; $i < count($list); $i++) {
        $status = $list[$i]['status'];
        $products_quantity = $list[$i]['products'];
        ?>
        <tr class="selectable" onClick="view('<?= $list[$i]['unique_code'] ?>');">
            <td><?= $list[$i]['name'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['final_price']) ?>
                <span  class="stamp-small-grey">R$ <?= $number->singleMoney($list[$i]['sale_price']) ?></span>
            </td>
            <td>R$ <?= $number->singleMoney(($list[$i]['sale_price'] - $list[$i]['final_price'])) ?></td>
            <td>R$ <?= $number->singleMoney(($list[$i]['profit'])) ?></td>
            <td>PV <?= $number->singleMoney(($list[$i]['volume'])) ?></td>
            <td><?= date("d/m/Y H:i", strtotime($list[$i]['sale_start_date'])) ?></td>
            <td>
                <?php if ($status === "1") { ?>
                    <?php if ($products_quantity > 0) { ?>
                        <span class="stamp stamp-bold stamp-sm stamp-font-sm  stamp-label-brand">Ag. Fechamento</span>
                    <?php } else { ?>
                        <span class="stamp stamp-bold stamp-sm stamp-font-sm  stamp-label-danger">Carrinho Vazio</span>
                    <?php } ?>
                <?php } else if ($status === "2") { ?>
                    <span class="stamp stamp-bold stamp-sm stamp-font-sm  stamp-label-warning">Pendente Entrega</span>
                <?php } else if ($status === "3") { ?>
                    <span class="stamp stamp-bold stamp-sm stamp-font-sm  stamp-label-success">Venda Finalizada</span>
                <?php } ?>

            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript">

    function view(cart) {
        window.location.href = "<?=$this->getModuleURLByKey('P00005'); ?>?cart=" + cart;
    }

</script>