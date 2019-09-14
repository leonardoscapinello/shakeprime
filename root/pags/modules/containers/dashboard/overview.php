<?php
$first_name = get_request("first_name");
$last_name = get_request("last_name");
$phone = get_request("phone");
$mobile = get_request("mobile");
$email = get_request("email");
$birthday = get_request("birthday");
$zipcode = get_request("zipcode");
$street = get_request("street");
$number = get_request("number");
$neighborhood = get_request("neighborhood");
$city = get_request("city");
$state = get_request("state");

$name = null;
if ($first_name !== null) {
    if ($last_name !== null) {
        $name = $first_name . " " . $last_name;
    }
}


$account->setName($name);
$account->setEmail($email);

?>

<form action="" method="GET">
    <div class="row">
        <div class="offset-2"></div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">

                <h4>Informações Pessoais</h4>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" id="first_name" name="first_name" placeholder="Nome">
                            <label for="first_name">
                                <span class="floating_icon"><i class="far fa-user"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" class="noicon" name="last_name" placeholder="Sobrenome">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" id="phone" name="phone" placeholder="Telefone">
                            <label for="phone">
                                <span class="floating_icon"><i class="far fa-phone"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" id="mobile" name="mobile" placeholder="WhatsApp">
                            <label for="mobile">
                                <span class="floating_icon"><i class="fab fa-whatsapp"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <div class="form_input">
                            <input type="text" id="email" name="email" placeholder="E-mail">
                            <label for="email">
                                <span class="floating_icon"><i class="far fa-envelope"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input type="text" id="birthday" name="birthday" placeholder="Data de Nascimento">
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
                            <input type="text" id="zipcode" name="zipcode" placeholder="CEP">
                            <label for="zipcode">
                                <span class="floating_icon"><i class="far fa-mailbox"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <p>Digite seu cep para preencher o endereço</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-10">
                        <div class="form_input">
                            <input type="text" id="address" name="address" placeholder="Endereço">
                            <label for="phone">
                                <span class="floating_icon"><i class="far fa-map-marker"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-2">
                        <div class="form_input">
                            <input type="text" class="noicon" id="number" name="number" placeholder="Número">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input type="text" class="noicon" id="neighborhood" name="neighborhood"
                                   placeholder="Bairro">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input type="text" class="noicon" id="city" name="city" placeholder="Cidade">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-4">
                        <div class="form_input">
                            <input type="text" class="noicon" id="state" name="state" placeholder="Estado">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-9"></div>
                    <div class="col-sm-12 col-lg-12 col-xl-3">
                        <div class="form_input">
                            <button>Cadastrar</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="offset-2"></div>
        <div class="clearfix"></div>
    </div>
</form>