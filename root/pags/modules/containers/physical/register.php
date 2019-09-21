<?php
$user = get_request("user");
$birthday = $zipcode = $neighborhood = $number = $stret = $state = $city = "";

if ($user !== null && $user !== "") {

    $customer->load($user);
    $customer->load($user);
    $name = $customer->getName();
    $phone = $customer->getPhone();
    $mobile = $customer->getMobile();
    $email = $customer->getEmail();
    $username = $customer->getEmail();
    $birthday = $customer->getBirthday();
    if ($birthday !== null && $birthday !== "") $birthday = date("d/m/Y", strtotime($birthday));

    $picture_image = $customer->getProfilePicture();

} else {
    die;
}
?>


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget" align="center">
            <img src="<?= $picture_image ?>" style="max-width: 100%;border-radius:4px;max-height: 202px;">
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-9">
        <div class="widget">
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
        </div>
    </div>
    <div class="clearfix"></div>
</div>


<form action="" method="GET">

    <input type="hidden" name="id_account" id="id_account">

    <h5 class="c__title">Índice de Massa Corpórea</h5>

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-4">
            <div class="widget">
                <div class="form_input">
                    <input autocomplete="off" type="text" id="body_mass" value="0" name="body_mass"
                           placeholder="Índice de Massa Corpórea" class="number">
                    <label for="body_mass"> <span class="floating_icon"><i class="far fa-weight"></i></span> </label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">
                <table class="table sml_tbl" style="margin: 0">
                    <thead>
                    <tr>
                        <th>IMC</th>
                        <th>Classificação OMS</th>
                        <th>Risco de Saúde</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Menor de 18,5</td>
                        <td>Peso abaixo do normal</td>
                        <td>Fraqueza, fadiga, stress e/ou ansiedade</td>
                    </tr>
                    <tr class="odd">
                        <td>18,5 a 25</td>
                        <td>Normal</td>
                        <td>Bom nível de energia, vitalidade e/ou resistência</td>
                    </tr>
                    <tr>
                        <td>25 a 30</td>
                        <td>Sobrepeso</td>
                        <td>Fadiga, problemas digestivos e/ou circulação</td>
                    </tr>
                    <tr class="odd">
                        <td>30 a 35</td>
                        <td>Obesidade I</td>
                        <td rowspan="2">Diabetes, hipertensão, doenças cardiacas, <br/>problemas gástricos e articulares
                            (joelho, coluna, embolias) etc.
                        </td>
                    </tr>
                    <tr>
                        <td>acimda de 40</td>
                        <td>Obesidade mórbida</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <h5 class="c__title">Índice de Gordura Corporal</h5>

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-4">

            <div class="widget">
                <div class="form_input">
                    <input autocomplete="off" type="text" id="body_fat" value="0" name="body_fat"
                           placeholder="Gordura Corporal" class="number">
                    <label for="body_fat"> <span class="floating_icon"><i class="far fa-weight"></i></span> </label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">
                <table class="table sml_tbl" style="margin: 0">
                    <thead>
                    <tr>
                        <th>Gênero</th>
                        <th>Idade</th>
                        <th>- (Baixo)</th>
                        <th>0 (Normal)</th>
                        <th>+ (Alto)</th>
                        <th>++ (Muito alto)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="3">Mulher</td>
                        <td>20-39</td>
                        <td>< 21</td>
                        <td>21,0 - 32,9</td>
                        <td>33,0 - 38,9</td>
                        <td>>= 39</td>
                    </tr>
                    <tr>
                        <td>40-59</td>
                        <td>< 23</td>
                        <td>23,0 - 33,9</td>
                        <td>34,2 - 39,9</td>
                        <td>>= 40</td>
                    </tr>
                    <tr>
                        <td>60-79</td>
                        <td>< 24</td>
                        <td>24,0 - 35,9</td>
                        <td>36,0 - 41,9</td>
                        <td>>= 42</td>
                    </tr>
                    <tr class="odd">
                        <td rowspan="3">Homem</td>
                        <td>20-39</td>
                        <td>< 8</td>
                        <td>8,0 - 19,9</td>
                        <td>20,0 - 24,9</td>
                        <td>>= 25</td>
                    </tr>
                    <tr class="odd">
                        <td>40-59</td>
                        <td>< 11</td>
                        <td>11,0 - 21,9</td>
                        <td>22,0 - 27,9</td>
                        <td>>= 28</td>
                    </tr>
                    <tr class="odd">
                        <td>60-79</td>
                        <td>< 13</td>
                        <td>13,0 - 24,9</td>
                        <td>25,0 - 29,9</td>
                        <td>>= 30</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <h5 class="c__title">Índice de Massa Muscular</h5>

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-4">
            <div class="widget">
                <div class="form_input">
                    <input autocomplete="off" type="text" id="muscle_mass" value="0" name="muscle_mass"
                           placeholder="Massa Muscular" class="number">
                    <label for="muscle_mass"> <span class="floating_icon"><i class="far fa-weight"></i></span> </label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">
                <table class="table sml_tbl" style="margin: 0">
                    <thead>
                    <tr>
                        <th>Gênero</th>
                        <th>Idade</th>
                        <th>- (Baixo)</th>
                        <th>0 (Normal)</th>
                        <th>+ (Alto)</th>
                        <th>++ (Muito alto)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="3">Mulher</td>
                        <td>18-39</td>
                        <td>< 24,3</td>
                        <td>24,3 - 30,3</td>
                        <td>30,4 - 35,3</td>
                        <td>>= 35,4</td>
                    </tr>
                    <tr>
                        <td>40-59</td>
                        <td>< 24,1</td>
                        <td>24,1 - 30,1</td>
                        <td>30,2 - 35,1</td>
                        <td>>= 35,2</td>
                    </tr>
                    <tr>
                        <td>60-80</td>
                        <td>< 23,9</td>
                        <td>23,9 - 29,9</td>
                        <td>30,0 - 34,9</td>
                        <td>>= 35,2</td>
                    </tr>
                    <tr class="odd">
                        <td rowspan="3">Homem</td>
                        <td>18-39</td>
                        <td>33,3</td>
                        <td>33,3 - 39,3</td>
                        <td>39,4 - 44,0</td>
                        <td>>= 44,1</td>
                    </tr>
                    <tr class="odd">
                        <td>40-59</td>
                        <td>< 33,1</td>
                        <td>33,1 - 39,1</td>
                        <td>,6,2 - 43,8</td>
                        <td>>= 43,9</td>
                    </tr>
                    <tr class="odd">
                        <td>60-79</td>
                        <td>< 32,9</td>
                        <td>32,9</td>
                        <td>39,2 - 43,8</td>
                        <td>>= 43,7</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <h5 class="c__title">Índice de Gordura Visceral</h5>

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-4">
            <div class="widget">
                <div class="form_input">
                    <input autocomplete="off" type="text" id="visceral_fat" value="0" name="visceral_fat"
                           placeholder="Gordura Visceral" class="number">
                    <label for="visceral_fat"> <span class="floating_icon"><i class="far fa-weight"></i></span> </label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-xl-8">
            <div class="widget">
                <table class="table sml_tbl" style="margin: 0">
                    <thead>
                    <tr>
                        <th>01-02</th>
                        <th>03-04</th>
                        <th>05-06</th>
                        <th>07-09</th>
                        <th>10-14</th>
                        <th>Maior que 14</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Ideal</td>
                        <td>Normal</td>
                        <td>Médio</td>
                        <td>Alto</td>
                        <td>Muito Alto<br/> (perigo a saúde)</td>
                        <td>Altissimo <br/>(muito risco a saúde)</td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="offset-4"></div>

        <div class="col-sm-12 col-lg-12 col-xl-3">
            <div class="">
                <div class="form_input">
                    <button>Salvar Avaliação</button>
                </div>
            </div>
        </div>

        <div class="offset-4"></div>


    </div>
</form>