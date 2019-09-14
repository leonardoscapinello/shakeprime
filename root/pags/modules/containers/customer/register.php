<?php
$first_name = get_request("first_name");
$last_name = get_request("last_name");
$email = get_request("email");


$name = null;
if ($first_name !== null) {
    if ($last_name !== null) {
        $name = $first_name . " " . $last_name;
    }
}

if (get_request("action") === "register") {
    $customer->setName($name);
    $customer->setEmail($email);
    $customer->setUsername($email);
    $customer->setPassword("forceReset");
    $customer->setForceReset("Y");
    $customer->setIsPrime("Y");
    $customer->setIsAdmin("N");
    $id_account = $customer->register();
    if ($id_account > 0) {
        header("location: " . SERVER_PAGS . "customer/edit?user=" . $id_account);
    }
}


?>

<form action="" method="POST">
    <div class="row">
        <div class="offset-2"></div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">

                <input type="hidden" value="register" name="action">

                <h4>Informações Pessoais</h4>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" id="first_name" name="first_name" placeholder="Nome" required>
                            <label for="first_name">
                                <span class="floating_icon"><i class="far fa-user"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-xl-6">
                        <div class="form_input">
                            <input type="text" class="noicon" name="last_name" placeholder="Sobrenome" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="form_input">
                            <input type="text" id="email" name="email" placeholder="E-mail" required>
                            <label for="email">
                                <span class="floating_icon"><i class="far fa-envelope"></i></span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="offset-7"></div>
                    <div class="col-sm-12 col-lg-12 col-xl-5">
                        <div class="form_input">
                            <button>Continuar para Dados Pessoais</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="offset-2"></div>
        <div class="clearfix"></div>
    </div>
</form>