<?php require_once("../../../settings/orchestrator.php"); ?>
<?php require_once("../../settings/pags.php"); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table width="100%" cellpadding="30" bgcolor="#FAFAFA">
    <tr>
        <td align="center">


            <table width="600" cellpadding="30" bgcolor="#241E20">
                <tr>
                    <td>
                        <img src="<?= PAGS_IMAGES ?>pags-logo-extensive.png" width="120px">
                    </td>
                    <td align="right">
                        <p style="font-size:13px;color:#FFFFFF;font-family:'Arial', serif;">
                            Um serviço oferecido por <br/><b style="font-size:16px;">ShakePrime</b> a você!
                        </p>
                    </td>
                </tr>
            </table>
            <table width="600" cellpadding="30" bgcolor="#FFFFFF">
                <tr>
                    <td align="left">

                        <img src="#progress_image" alt="Progresso">

                        <h1 style="font-family:'Arial', serif;">#name,</h1>

                        <p style="font-size:14px;color:#2d2d2d;font-family:'Arial', serif;line-height:32px;">
                            Seu pedido foi finalizado e sua compra foi aprovada em nosso sistema. Isso é uma ótima
                            notícia. <b>Vamos deixar logo abaixo, todos os dados importantes da sua compra, okay?</b>
                        </p>


                        <table style="font-size:13px;color:#2d2d2d;font-family:'Arial', serif;line-height:32px;border-collapse: collapse"
                               width="100%">
                            <tr>
                                <td>Seu consultor</td>
                                <td><strong>#consultor</strong></td>
                            </tr>
                            <tr>
                                <td>Telefone do Consultor</td>
                                <td><strong>#cphone</strong></td>
                            </tr>
                            <tr>
                                <td>Seu protocolo</td>
                                <td><strong>#cart_code</strong></td>
                            </tr>
                            <tr>
                                <td>Forma de Pagamento</td>
                                <td><strong>#payment_method</strong></td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td><strong>#subtotal</strong></td>
                            </tr>
                            <tr>
                                <td>Desconto</td>
                                <td><strong>- #discount</strong></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><strong>#total</strong></td>
                            </tr>
                        </table>

                        <p style="font-size:14px;color:#2d2d2d;font-family:'Arial', serif;line-height:32px;">
                            Se você encontrou algum problema, não se esqueça, estamos prontos a te ajudar! Anota nosso
                            e-mail de suporte <b>ajuda@shakepri.me</b>.
                        </p>

                        <br>


                        <table style="font-size:13px;color:#2d2d2d;font-family:'Arial', serif;line-height:32px;border-collapse: collapse"
                               cellpadding="10" width="100%">
                            <tr style="background: #000000;color: #FFFFFF">
                                <td></td>
                                <td>Produto</td>
                                <td>Qtd</td>
                                <td>R$ Unit</td>
                                <td>R$ Total</td>
                            </tr>
                            #product_table
                        </table>


                    </td>
                </tr>
            </table>


        </td>
    </tr>
</table>
</body>
</html>