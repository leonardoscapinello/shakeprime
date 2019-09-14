<?php
$name = "oi";
$user = get_request("user");
$birthday = $zipcode = $neighborhood = $number = $stret = $state = $city = "";

if ($user !== null && $user !== "") {

    if (get_request("action") === "update") {

        $customer->setUsername(get_request("email"));
        $customer->setEmail(get_request("email"));
        $customer->setName(get_request("name"));
        $customer->setPhone(get_request("phone"));
        $customer->setMobile(get_request("mobile"));
        $customer->setBirthday(get_request("birthday"));
        $c_save = $customer->update($user);


        $address->setZipcode(get_request("zipcode"));
        $address->setAddress(get_request("address"));
        $address->setNumber(get_request("number"));
        $address->setNeighborhood(get_request("neighborhood"));
        $address->setCity(get_request("city"));
        $address->setState(get_request("state"));
        $a_save = $address->update($user);

        if ($c_save && $a_save) {
            header("location: " . SERVER_PAGS . "customer/edit?user=" . $user . "&s=" . $user);
        } else {
            header("location: " . SERVER_PAGS . "customer/edit?user=" . $user . "&e=" . $user);
        }

        die();

    }

    $customer->load($user);
    $name = $customer->getName();
    $phone = $customer->getPhone();
    $mobile = $customer->getMobile();
    $email = $customer->getEmail();
    $username = $customer->getEmail();
    $birthday = $customer->getBirthday();
    if ($birthday !== null && $birthday !== "") $birthday = date("d/m/Y", strtotime($birthday));
    $address->load($user);

    $zipcode = $address->getZipcode();
    $neighborhood = $address->getNeighborhood();
    $number = $address->getNumber();
    $street = $address->getAddress();
    $state = $address->getState();
    $city = $address->getCity();

}
?>


<input autocomplete="off" type="hidden" name="user" value="<?= $user ?>">
<input autocomplete="off" type="hidden" name="action" value="update">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget">
            <div class="form_input">
                <button onClick="newSale(<?= $user ?>);return false;">Novo Pedido</button>
                <button onClick="newExam(<?= $user ?>);return false;">Nova Avaliação</button>
                <button onClick="newMessage(<?= $user ?>);return false;">Enviar Mensagem</button>
            </div>
            <div class="separator"></div>

            <p align="center">Ainda nenhum pedido foi feito para esse usuário.</p>

        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-9">
        <div class="widget">
            <form action="" method="POST">
                <h4>Informações Pessoais</h4>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="name" name="name" value="<?= $name; ?>"
                                   placeholder="Nome" required>
                            <label for="name">
                                <span class="floating_icon"><i class="far fa-user"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="phone" class="phone_with_ddd" name="phone"
                                   value="<?= $phone; ?>"
                                   placeholder="Telefone">
                            <label for="phone">
                                <span class="floating_icon"><i class="far fa-phone"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="mobile" class="mobile" name="mobile"
                                   value="<?= $mobile; ?>"
                                   placeholder="WhatsApp">
                            <label for="mobile">
                                <span class="floating_icon"><i class="fab fa-whatsapp"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="email" name="email" value="<?= $email; ?>"
                                   placeholder="E-mail" required>
                            <label for="email">
                                <span class="floating_icon"><i class="far fa-envelope"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="birthday" class="date" name="birthday"
                                   value="<?= $birthday; ?>"
                                   placeholder="Data de Nascimento">
                            <label for="birthday">
                                <span class="floating_icon"><i class="far fa-calendar"></i></span>
                            </label>
                        </div>
                    </div>
                </div>

                <h4>Endereço</h4>


                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="zipcode" class="cep" name="zipcode"
                                   value="<?= $zipcode; ?>"
                                   placeholder="CEP">
                            <label for="zipcode">
                                <span class="floating_icon"><i class="far fa-mailbox"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <p style="display: none;">Digite seu cep para preencher o endereço</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-10">
                        <div class="form_input">
                            <input autocomplete="off" type="text" id="address" name="address"
                                   value="<?= $street; ?>"
                                   placeholder="Endereço">
                            <label for="phone">
                                <span class="floating_icon"><i class="far fa-map-marker"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-2">
                        <div class="form_input">
                            <input autocomplete="off" type="text" class="noicon" id="number" name="number"
                                   value="<?= $number; ?>"
                                   placeholder="Número">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input autocomplete="off" type="text" class="noicon" id="neighborhood"
                                   value="<?= $neighborhood; ?>"
                                   name="neighborhood"
                                   placeholder="Bairro">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input autocomplete="off" type="text" class="noicon" id="city" name="city"
                                   value="<?= $city; ?>"
                                   placeholder="Cidade">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input autocomplete="off" type="text" class="noicon" id="state" name="state"
                                   value="<?= $state; ?>"
                                   placeholder="Estado">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-9"></div>
                    <div class="col-sm-12 col-lg-12 col-xl-3">
                        <div class="form_input">
                            <button>Salvar Cadastro</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">


    function newSale(user_id) {
        window.location.href = "<?=$this->getModuleURLByKey('P00005'); ?>?user=" + user_id;
    }


    <?php if (get_request("s") !== null) { ?>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        type: 'success',
        title: 'Alterações salvas com sucesso'
    });
    <?php } else if (get_request("e") !== null) { ?>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        type: 'error',
        title: 'Não foi possível salvar as alterações'
    });
    <?php } ?>


</script>

