<table class="table">
    <thead>
    <tr>
        <th>SKU</th>
        <th>Produto</th>
        <th>PV</th>
        <th>Preço de Venda</th>
        <th>25%</th>
        <th>35%</th>
        <th>42%</th>
        <th>50%</th>
        <th>CPV</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $list = $products->getList();
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
            <td>R$ <?= $number->singleMoney($list[$i]['level_price_a']) ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['level_price_b']) ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['level_price_c']) ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['level_price_d']) ?></td>
            <td>R$ <?= $number->singleMoney($list[$i]['fractional_cost']) ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    function edit(id_account) {
        window.location.href = "<?=$this->getModuleURLByKey('P00005'); ?>?product=" + id_account;
    }
</script>