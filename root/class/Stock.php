<?php

class Stock
{

    public function addProduct2Stock($id_product, $quantity)
    {


        global $charset;
        global $database;
        global $account;
        global $products;
        global $sales;

        $added = false;
        try {
            if ($quantity < 1) {
                return false;
            }
            $id_account = $account->isLogged();
            $database->query("SELECT * FROM stock st WHERE st.id_product = ? AND st.id_account = ?");
            $database->bind(1, $id_product);
            $database->bind(2, $id_account);
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {

                $database->query("UPDATE stock SET quantity = (quantity + ?), update_time = CURRENT_TIMESTAMP WHERE id_product = ? AND id_account = ?");
                $database->bind(1, $quantity);
                $database->bind(2, $id_product);
                $database->bind(3, $id_account);
                $database->execute();
                $added = true;

            } else {

                $database->query("INSERT INTO stock (quantity, id_product, id_account, update_time) VALUES (?,?,?,CURRENT_TIMESTAMP)");
                $database->bind(1, $quantity);
                $database->bind(2, $id_product);
                $database->bind(3, $id_account);
                $database->execute();
                $added = true;

            }

            if($added){
                $database->query("INSERT INTO stock_history (id_stock, id_account, id_product, quantity, type) VALUES ((SELECT id_stock FROM stock WHERE id_account = ? AND id_product = ?),?,?,?,'ADD')");
                $database->bind(1, $id_account);
                $database->bind(2, $id_product);
                $database->bind(3, $id_account);
                $database->bind(4, $id_product);
                $database->bind(5, $quantity);
                $database->execute();
                return true;
            }



        } catch (Exception $exception) {
            error_log($exception);
        }

        return false;

    }


}