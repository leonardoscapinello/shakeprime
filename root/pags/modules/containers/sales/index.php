<?php
$filter = get_request("q");
?>
<table class="table">
    <thead>
    <tr>
        <th>Protocolo</th>
        <th>Nome do Cliente</th>
        <th>Desconto</th>
        <th>Valor do Pedido</th>
        <th>Data de Inicio</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($filter !== null) {
        $list = $sales->getSales();
    } else {
        $list = $sales->getSales();
    }
    for ($i = 0; $i < count($list); $i++) {
        ?>
        <tr class="selectable">
            <td><?= $list[$i]['unique_code'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
            <td><?= $list[$i]['unique_code'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>