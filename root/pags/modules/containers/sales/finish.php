<?php

$user = get_request("user");
$cart = get_request("cart");
$delivery = get_request("delivery");
$payment_method = get_request("method");
if ($cart !== null) {
    $selectUser = false;
    $sales->load($cart);
    $user = $sales->getIdCustomer();

    if ($sales->getIsClosed() === "Y") {
        header("location: " . $this->getModuleURLByKey("P00014") . "?cart=" . $cart);
        die;
    }

    $progress = PAGS_IMAGES . "/shopping-progress-delivery-waiting.png";
    if ($delivery === "TODAY") $progress = PAGS_IMAGES . "shopping-progress-delivery-done.png";

    $products_list = $salesProducts->getCartProducts($cart);

    $customer->load($user);
    $name = $customer->getName();
    $email = $customer->getEmail();
    $birthday = date("d/m/Y", strtotime($customer->getBirthday()));
    $list = $products_list;

    $final_structure = "";

    $sale_price = 0;
    $sold_price = 0;

    for ($i = 0; $i < count($list); $i++) {

        $sold_price_total_iter = $list[$i]['quantity'] * $list[$i]['sold_price'];
        $sale_price_total_iter = $list[$i]['quantity'] * $list[$i]['sale_price'];

        $final_structure .= "<tr style=\"font-size:13px;font-family:'Arial', serif;\">";
        $final_structure .= "     <td><img src=\"" . PAGS_IMAGES . "products/default/" . $list[$i]['product_image'] . "\" width=\"22\"></td>";
        $final_structure .= "     <td>" . base64_decode($list[$i]['product_name']) . "</td>";
        $final_structure .= "     <td>" . $list[$i]['quantity'] . "</td>";
        $final_structure .= "     <td>R$ " . $number->singleMoney($list[$i]['sold_price']) . "</td>";
        $final_structure .= "     <td>R$ " . $number->singleMoney(($list[$i]['quantity'] * $list[$i]['sold_price'])) . "</td>";
        $final_structure .= "</tr>";

        $sale_price = $sale_price + $sale_price_total_iter;
        $sold_price = $sold_price + $sold_price_total_iter;

    }

    switch ($payment_method) {
        case "D":
            $payment_method_caption = "Cartão de Débito";
            break;
        case "C":
            $payment_method_caption = "Cartão de Crédito";
            break;
        case "M":
            $payment_method_caption = "Dinheiro à Vista";
            break;
        default:
            $payment_method_caption = "Carteira Digital Pags";
            break;
    }

    $pagsMailer->send($email, "Você é Incrível! Sua compra foi aprovada.", "finish-cart", array(
        "consultor" => $account->getName(),
        "cphone" => $account->getPhone(),
        "cart_code" => $cart,
        "name" => $name,
        "email" => $email,
        "product_table" => $final_structure,
        "progress" => $progress,
        "subtotal" => "R$ " . $number->singleMoney($sale_price),
        "discount" => "R$ " . $number->singleMoney($sale_price - $sold_price),
        "total" => "R$ " . $number->singleMoney($sold_price),
        "payment_method" => $payment_method_caption
    ));

    $sales->finish($cart, $delivery, $payment_method, $sale_price, $sold_price);

}

?>
<div class="row">
    <div class="offset-3"></div>
    <div class="col-sm-12 col-lg-12 col-xl-6">
        <div class="widget">


            <div class="thumbsup-icon">
                <svg id="stripes" class="stripes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M4 35h83a4 4 0 0 1 4 4 4 4 0 0 1-4 4H4a4 4 0 0 1-4-4 4 4 0 0 1 4-4zM100 51h83a4 4 0 0 1 4 4 4 4 0 0 1-4 4h-83a4 4 0 0 1-4-4 4 4 0 0 1 4-4zM20 67h131a4 4 0 0 1 4 4 4 4 0 0 1-4 4H20a4 4 0 0 1-4-4 4 4 0 0 1 4-4zM92 91h51a4 4 0 0 1 4 4 4 4 0 0 1-4 4H92a4 4 0 0 1-4-4 4 4 0 0 1 4-4zM92 19h51a4 4 0 0 1 4 4 4 4 0 0 1-4 4H92a4 4 0 0 1-4-4 4 4 0 0 1 4-4z"/>
                </svg>

                <svg class="stars star1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M68.1 17.4l-4.3-.6-1.9-3.9c-.2-.3-.5-.5-.9-.5s-.7.2-.9.5l-1.9 3.9-4.3.6c-.4.1-.7.3-.8.7-.1.4 0 .8.3 1l3.1 3-.7 4.3c-.1.4.1.8.4 1 .3.2.7.3 1.1.1l3.9-2 3.9 2c.3.2.7.1 1.1-.1s.5-.6.4-1l-.7-4.3 3.1-3c.3-.3.4-.7.3-1-.5-.3-.8-.6-1.2-.7z"/>
                </svg>

                <svg class="stars star2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M133.1 8.1l-6.6-1-2.9-6c-.3-.5-.8-.8-1.4-.8s-1.1.3-1.4.8l-2.9 6-6.6 1c-.6.1-1.1.5-1.2 1-.2.6 0 1.2.4 1.6l4.8 4.6-1.1 6.6c-.1.6.1 1.1.6 1.5.5.3 1.1.4 1.6.1l5.9-3.1 5.9 3.1c.5.3 1.1.2 1.6-.1s.7-.9.6-1.5l-1.1-6.6 4.8-4.6c.4-.4.6-1 .4-1.6-.4-.5-.8-.9-1.4-1z"/>
                </svg>


                <svg class="stars star3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M92.9 97.7l-4.6-.7-2-4.1c-.2-.3-.6-.5-.9-.5a1 1 0 0 0-.9.5l-2 4.1-4.5.7c-.4.1-.7.3-.8.7-.1.4 0 .8.3 1.1l3.3 3.2-.8 4.5c-.1.4.1.8.4 1s.8.3 1.1.1l4-2.1 4 2.1c.4.2.8.2 1.1-.1.3-.2.5-.6.4-1l-.8-4.5 3.3-3.2c.3-.3.4-.7.3-1.1-.2-.4-.5-.7-.9-.7z"/>
                </svg>


                <svg class="stars star4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M45.8 62l-5.7-.8-2.5-5.1c-.2-.4-.7-.7-1.2-.7s-.9.3-1.2.7l-2.5 5.1-5.6.8c-.5.1-.9.4-1.1.9-.2.5 0 1 .3 1.3l4.1 4-1 5.6c-.1.5.1 1 .5 1.3.4.3.9.3 1.4.1l5.1-2.7 5.1 2.7c.4.2 1 .2 1.4-.1.4-.3.6-.8.5-1.3l-1-5.6 4.1-4c.4-.3.5-.9.3-1.3-.1-.5-.5-.8-1-.9z"/>
                </svg>

                <svg class="stars star5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M142.9 63.7l-2.8-.4-1.3-2.6c-.1-.2-.3-.3-.6-.3s-.5.1-.6.3l-1.3 2.6-2.8.4c-.2 0-.5.2-.5.4-.1.2 0 .5.2.7l2 2-.5 2.8c0 .2.1.5.3.6.2.1.5.2.7 0l2.5-1.3 2.5 1.3h.7c.2-.1.3-.4.3-.6l-.5-2.8 2-2c.2-.2.2-.4.2-.7 0-.2-.2-.4-.5-.4z"/>
                </svg>

                <svg class="thumbsup" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109">
                    <path d="M55 66H33c-4.3 0-8.7-1-12.5-2.9l-7.1-3.5c-.5-.3-.9-.8-.9-1.4v-22c0-.4.1-.7.4-1l15.3-18.4v-12A4.7 4.7 0 0 1 35.3.7c5.4 3.1 5.6 11.1 5.6 16.6v7.9h17.3c4.3 0 7.9 3.5 7.9 7.8v.2L63 58.3a8.1 8.1 0 0 1-8 7.7z"
                          fill="#0095ff" transform="translate(58 19)"/>
                    <path d="M14.1 66H1.6C.7 66 0 65.3 0 64.4V29.9c0-.9.7-1.6 1.6-1.6h12.6c.9 0 1.6.7 1.6 1.6v34.6c-.1.8-.8 1.5-1.7 1.5z"
                          fill="#17c"
                          transform="translate(58 19)"/>
                </svg>
            </div>

            <h3 align="center" style="font-size:3.3em;margin-top: 20px;color: #5BAD3E;">Você é Incrivel!</h3>
            <p align="center" style="font-size:1.4em;margin:20px auto;max-width:400px;">A compra foi finalizada e os
                detalhes encaminhados ao e-mail do cliente.<br/>
                redirecionamos você a visualização da compra.</p>

        </div>

    </div>

    <div class="offset-3"></div>
</div>
<script type="text/javascript">
    window.setTimeout(function () {
        window.location.href = '<?= $this->getModuleURLByKey("P00005") . "?cart=" . $cart?>';
    }, 5000);
</script>