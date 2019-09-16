<table class="table">
    <thead>
    <tr>
        <th>SKU</th>
        <th>Produto</th>
        <th>PV</th>
        <th>Preço de Venda</th>
        <th>Quantidade em Estoque</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $list = $products->getInStockList();
    for ($i = 0; $i < count($list); $i++) {
        ?>
        <tr class="selectable" onClick="edit(<?= $list[$i]['id_product'] ?>);return false;">
            <td><?= $list[$i]['sku'] ?></td>
            <td>
                <div class="product_image_small">
                    <img src="<?= PAGS_IMAGES ?>/products/default/<?= $list[$i]['product_image']; ?>">
                    <div class="thumb">
                        <img src="<?= PAGS_IMAGES ?>/products/default/<?= $list[$i]['product_image']; ?>">
                    </div>
                </div>
                <?= $charset->singleUTF8(base64_decode($list[$i]['product_name'])); ?>
            </td>
            <td><?= $list[$i]['volume'] ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['sale_price']) ?></td>
            <td><?=$list[$i]['stock_quantity'] ?> unidades</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    function edit(id_account) {
        window.location.href = "<?=$this->getModuleURLByKey('P00007'); ?>?product=" + id_account;
    }
</script>