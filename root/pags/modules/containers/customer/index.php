<table class="table">
    <thead>
    <tr>
        <th>Nome do Cliente</th>
        <th>Endereço de E-mail</th>
        <th>Data de Nascimento</th>
        <th>Pontos de Volume</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $list = $customer->getCustomers();
    for ($i = 0; $i < count($list); $i++) {
        ?>
        <tr class="selectable" onClick="edit(<?= $list[$i]['id_account'] ?>);return false;">
            <td><?= $list[$i]['name'] ?></td>
            <td><?= $list[$i]['username'] ?></td>
            <td><?= date("d/m/Y", strtotime($list[$i]['birthday'])) ?></td>
            <td><?= $list[$i]['name'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    function edit(id_account){
        <?php if(get_request("startShopping") === "Y"){ ?>
            window.location.href = "<?=$this->getModuleURLByKey('P00005'); ?>?user=" + id_account;
        <?php }else{ ?>
            window.location.href = "<?=$this->getModuleURLByKey('P00002'); ?>?user=" + id_account;
        <?php } ?>
    }
    <?php if(get_request("startShopping") === "Y"){ ?>
    const Added = Swal.mixin({
        toast: true,
        type: 'info',
        title: 'Vamos lá?',
        text: 'Selecione um usuário para iniciar um pedido.',
        allowEscapeKey : false,
        allowOutsideClick: false,
        showConfirmButton: false,
        position: 'top-right',
        timer: 2000
    });
    window.setTimeout(function () {
        Added.fire();
    }, 100);
    <?php } ?>
</script>