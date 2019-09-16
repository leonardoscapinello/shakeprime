<?php

require_once(__DIR__ . "/../../../../settings/orchestrator.php");
require_once(__DIR__ . "/../../../settings/pags.php");
$id_sales_products = 0;
if (get_request("id") !== null) {
    if (get_request("cart") !== null) {
        if (get_request("quantity") !== null) {
            $id_sales_products = get_request("id");
            $cart = get_request("cart");
            $quantity = get_request("quantity");
        }
    }
}

$result = $salesProducts->editCartProduct($id_sales_products, $quantity);

if(!$result){
    echo "biggerThanStock";
}
