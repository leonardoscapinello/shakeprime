<?php

class SalesProducts
{

    public function addProduct2Cart($unique_code, $id_product, $quantity)
    {



        global $charset;
        global $database;
        global $account;
        global $products;
        global $sales;
        try {

            $id_account = $account->isLogged();
            $database->query("SELECT pr.id_product, pr.volume, pr.sale_price, pr.level_price_a, pr.level_price_b, pr.level_price_c, pr.level_price_d, st.quantity FROM products pr LEFT JOIN stock st ON st.id_product = pr.id_product AND st.id_account = ? WHERE pr.id_product = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $id_product);
            $prod = $database->resultset();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {

                $prod = $prod[0];

                $id_product = $prod['id_product'];

                $sales->load($unique_code);
                $discount_level = $sales->getDiscountLevel();

                $sale_price = $prod['sale_price'];
                $sold_price = $sale_price;
                if ($discount_level === "0") $sold_price = $prod['sale_price'];
                if ($discount_level === "25") $sold_price = $prod['level_price_a'];
                if ($discount_level === "35") $sold_price = $prod['level_price_b'];
                if ($discount_level === "42") $sold_price = $prod['level_price_c'];
                if ($discount_level === "50") $sold_price = $prod['level_price_d'];

                $discount_applied = $sale_price - $sold_price;

                $products->load($id_product);


                $database->query("SELECT sp.id_product, sp.quantity FROM sales_products sp WHERE sp.id_product = ? AND sp.id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ? AND id_account = ?)");
                $database->bind(1, $id_product);
                $database->bind(2, $unique_code);
                $database->bind(3, $id_account);
                $hasProd = $database->resultset();
                if (count($hasProd) > 0) {

                    error_log("Has product!");


                    $setQuantity = $hasProd[0]['quantity'];
                    $totalQuantity = $setQuantity + $quantity;
                    if ($quantity > $products->getStockQuantity()) {
                        error_log($totalQuantity);
                        error_log("Total quantity bigger than stock");
                        return false;
                    }

                    error_log("Increasing quantity to " . $totalQuantity);
                    error_log("Stock quantity " . $products->getStockQuantity());
                    $database->query("UPDATE sales_products SET quantity = ? WHERE id_product = ? AND id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ? AND id_account = ?)");
                    $database->bind(1, $totalQuantity);
                    $database->bind(2, $id_product);
                    $database->bind(3, $unique_code);
                    $database->bind(4, $id_account);
                    $database->execute();
                    return true;

                } else {
                    if ($quantity <= $products->getStockQuantity()) {
                        $database->query("INSERT INTO sales_products (id_sale, id_product, sale_price, sold_price, quantity, discount_applied) VALUES ((SELECT id_shopping_cart FROM sales WHERE unique_code = ? AND id_account = ?),?,?,?,?,?)");
                        $database->bind(1, $unique_code);
                        $database->bind(2, $id_account);
                        $database->bind(3, $id_product);
                        $database->bind(4, $prod['sale_price']);
                        $database->bind(5, $sold_price);
                        $database->bind(6, $quantity);
                        $database->bind(7, $discount_applied);
                        $database->execute();
                        return true;
                    }else{
                        return false;
                    }

                }


            }
        } catch (Exception $exception) {
            error_log($exception);
        }

    }

    public function getCartProducts($unique_code)
    {

        global $charset;
        global $database;
        global $account;
        global $products;
        global $sales;
        try {

            $id_account = $account->isLogged();
            $database->query("SELECT sp.sale_price, sp.sold_price, sp.discount_applied, sp.quantity, pr.product_name, pr.product_image, pr.volume FROM sales_products sp LEFT JOIN products pr ON pr.id_product = sp.id_product WHERE sp.id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ? AND id_account = ?)");
            $database->bind(1, $unique_code);
            $database->bind(2, $id_account);
            $prod = $database->resultset();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                return $prod;
            }

        } catch (Exception $exception) {
            error_log($exception);
        }

    }


}