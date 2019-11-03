<?php

class Sales
{

    private $id_shopping_cart;
    private $id_account;
    private $id_customer;
    private $unique_code;
    private $sale_price;
    private $discount_level;
    private $additional_discount;
    private $final_price;
    private $profit;
    private $sale_start_date;
    private $sale_done_date;
    private $delivery_date;
    private $payment_method;
    private $status;
    private $is_closed;

    public function startSale($id_customer)
    {

        global $account;
        global $database;
        $in_progress = $this->hasSaleInProgress($id_customer);
        if (!$in_progress) {
            $id_account = $account->isLogged();
            $unique_code = $this->createUniqueCode();
            $database->query("INSERT INTO sales (id_account, id_customer, unique_code) VALUES (?,?,?)");
            $database->bind(1, $id_account);
            $database->bind(2, $id_customer);
            $database->bind(3, $unique_code);
            $database->execute();
            return $unique_code;
        } else {
            return $in_progress;
        }

    }

    private function createUniqueCode()
    {
        return strtoupper(uniqid("SP"));
    }

    public function hasSaleInProgress($id_customer)
    {

        global $account;
        global $database;
        try {
            $id_account = $account->isLogged();
            $database->query("SELECT unique_code FROM sales WHERE id_account = ? AND id_customer = ? AND is_closed = 'N'");
            $database->bind(1, $id_account);
            $database->bind(2, $id_customer);
            $resultset = $database->resultset();
            if (count($resultset) > 0) {
                return $resultset[0]['unique_code'];
            }
        } catch (Exception $exception) {
            error_log($exception);
        }

        return false;

    }

    public function updateDiscountLevel($cart, $discount_level)
    {

        global $account;
        global $database;
        try {

            $database->query("UPDATE sales SET discount_level = ? WHERE unique_code = ?");
            $database->bind(1, $discount_level);
            $database->bind(2, $cart);
            $database->execute();


            $database->query("SELECT * FROM sales_products sp LEFT JOIN products pr ON pr.id_product = sp.id_product WHERE sp.id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ?)");
            $database->bind(1, $cart);
            $rs = $database->resultset();
            for ($i = 0; $i < count($rs); $i++) {

                $sale_price = $product_price = $rs[$i]['sale_price'];
                if ($discount_level === "25") $product_price = $rs[$i]['level_price_a'];
                if ($discount_level === "35") $product_price = $rs[$i]['level_price_b'];
                if ($discount_level === "42") $product_price = $rs[$i]['level_price_c'];
                if ($discount_level === "50") $product_price = $rs[$i]['level_price_d'];

                $discount_amount = $sale_price - $product_price;

                $database->query("UPDATE sales_products SET sale_price = ?, sold_price = ?, discount_applied = ? WHERE id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ?)");
                $database->bind(1, doubleval($sale_price));
                $database->bind(2, doubleval($product_price));
                $database->bind(3, doubleval($discount_amount));
                $database->bind(4, $cart);
                $database->execute();


            }


        } catch (Exception $exception) {
            error_log($exception);
        }

        return false;

    }

    public function load($unique_code)
    {
        global $charset;
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query("SELECT * FROM sales WHERE id_account = ? AND unique_code = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $unique_code);
            $result = $database->resultsetObject();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                foreach ($result as $key => $value) {
                    $charset->setString($value);
                    $this->$key = $charset->utf8();
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function finish($unique_code, $delivery, $payment_method = "M", $sale_price, $final_price)
    {
        global $charset;
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            if ($delivery === "TODAY") {
                $database->query("UPDATE sales SET sale_done_date = CURRENT_TIMESTAMP, payment_method = ?, is_closed = 'Y', delivery_date = CURRENT_TIMESTAMP, status = 3, final_price = ?, sale_price = ? WHERE id_account = ? AND unique_code = ?");
            } else {
                $database->query("UPDATE sales SET sale_done_date = CURRENT_TIMESTAMP, payment_method = ?, is_closed = 'Y', delivery_date = NULL, status = 2, final_price = ?, sale_price = ?  WHERE id_account = ? AND unique_code = ?");
            }
            $database->bind(1, $payment_method);
            $database->bind(2, $final_price);
            $database->bind(3, $sale_price);
            $database->bind(4, $id_account);
            $database->bind(5, $unique_code);
            $database->execute();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


    public function getSales()
    {
        $error = "";
        global $database;
        global $account;
        global $logger;
        try {
            $register_by = $account->isLogged();
            $database->query("SELECT sa.unique_code, sa.discount_level, sa.final_price, sa.sale_price, sa.payment_method, sa.is_closed, sa.status, ac.name FROM sales sa LEFT JOIN accounts ac ON ac.id_account = sa.id_account WHERE sa.id_account = ?");
            $database->bind(1, $register_by);
            return $database->resultset();
        } catch (Exception $exception) {
            $error = $exception;
        } finally {
            if ($error !== "") {
                $logger->error($error);
            }
        }
    }


    public function recalculeCart($unique_code)
    {
        global $charset;
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query("SELECT * FROM sales WHERE id_account = ? AND unique_code = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $unique_code);
            $result = $database->resultsetObject();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                foreach ($result as $key => $value) {
                    $charset->setString($value);
                    $this->$key = $charset->utf8();
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


    /**
     * @return mixed
     */
    public function getIdShoppingCart()
    {
        return $this->id_shopping_cart;
    }

    /**
     * @return mixed
     */
    public function getIdAccount()
    {
        return $this->id_account;
    }

    /**
     * @return mixed
     */
    public function getIdCustomer()
    {
        return $this->id_customer;
    }

    /**
     * @return mixed
     */
    public function getUniqueCode()
    {
        return $this->unique_code;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * @return mixed
     */
    public function getDiscountLevel()
    {
        return $this->discount_level;
    }

    /**
     * @return mixed
     */
    public function getAdditionalDiscount()
    {
        return $this->additional_discount;
    }

    /**
     * @return mixed
     */
    public function getFinalPrice()
    {
        return $this->final_price;
    }

    /**
     * @return mixed
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @return mixed
     */
    public function getSaleStartDate()
    {
        return $this->sale_start_date;
    }

    /**
     * @return mixed
     */
    public function getSaleDoneDate()
    {
        return $this->sale_done_date;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getIsClosed()
    {
        return $this->is_closed;
    }


}