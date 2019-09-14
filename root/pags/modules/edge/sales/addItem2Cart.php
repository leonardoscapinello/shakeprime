<?php

require_once(__DIR__ . "/../../../../settings/orchestrator.php");
require_once(__DIR__ . "/../../../settings/pags.php");
$id_product = 0;
if (get_request("id") !== null) {
    if (get_request("cart") !== null) {
        if (get_request("quantity") !== null) {
            $id_product = get_request("id");
            $cart = get_request("cart");
            $quantity = get_request("quantity");
            $products->load($id_product);
        }
    }
}

$result = $salesProducts->addProduct2Cart($cart, $id_product, $quantity);

if(!$result){
    echo "biggerThanStock";
}
