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
            $database->query("SELECT unique_code FROM sales WHERE id_account = ? AND id_customer = ? AND is_closed = 'N' AND status != 4");
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
            $this->removeFromStock($unique_code);
        } catch (Exception $exception) {
            error_log($exception);
        }


    }

    private function removeFromStock($unique_code)
    {
        global $database;
        global $account;
        global $stock;
        try {
            $id_account = $account->getIdAccount();
            $database->query("select id_product, quantity from sales_products where id_sale = (select id_shopping_cart from sales where unique_code = ?)");
            $database->bind(1, $unique_code);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                for ($i = 0; $i < count($rs); $i++) {

                    $id_product = $rs[$i]['id_product'];
                    $quantity = $rs[$i]['quantity'];

                    $quantity = (abs($quantity) * -1);

                    $stock->addProduct2Stock($id_product, $quantity);
                }
            }
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
            $database->query("SELECT sa.unique_code, sa.discount_level, sa.final_price, sa.sale_price, sa.payment_method, sa.is_closed, sa.status, ac.name, sa.sale_start_date, CASE WHEN sp.id_sale IS NULL THEN 0 ELSE sp.id_sale END AS products, volume, product_purchase_price, profit  FROM sales sa LEFT JOIN accounts ac ON ac.id_account = sa.id_customer LEFT JOIN (SELECT id_sale, COUNT(id_sale) FROM sales_products GROUP BY id_sale) sp ON sp.id_sale = sa.id_shopping_cart WHERE sa.id_account = ? AND ((status = 1 AND is_closed = 'N') OR status = 2) AND sa.status != 4 ORDER BY sale_start_date DESC");
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

    public function getSalesWithFilter($filter)
    {
        $error = "";
        global $database;
        global $account;
        global $logger;
        try {
            $register_by = $account->isLogged();
            $database->query("SELECT sa.unique_code, sa.discount_level, sa.final_price, sa.sale_price, sa.payment_method, sa.is_closed, sa.status, ac.name, sa.sale_start_date, CASE WHEN sp.id_sale IS NULL THEN 0 ELSE sp.id_sale END AS products, volume, product_purchase_price, profit  FROM sales sa LEFT JOIN accounts ac ON ac.id_account = sa.id_customer LEFT JOIN (SELECT id_sale, COUNT(id_sale) FROM sales_products GROUP BY id_sale) sp ON sp.id_sale = sa.id_shopping_cart WHERE sa.id_account = :register_by AND (LOWER(sa.unique_code) LIKE :term OR LOWER(ac.name) LIKE :term) AND sa.status != 4 ORDER BY sale_start_date DESC");
            $database->bind(":register_by", $register_by);
            $database->bind(":term", "%" . strtolower($filter) . "%");
            return $database->resultset();
        } catch (Exception $exception) {
            $error = $exception;
        } finally {
            if ($error !== "") {
                $logger->error($error);
            }
        }
    }

    public function setTotals($unique_code, $sale_price, $final_price, $volume, $profit, $product_purchase_price)
    {
        global $database;
        global $account;
        global $logger;
        try {
            $register_by = $account->isLogged();
            $database->query("UPDATE sales SET sale_price = ?, final_price = ?, volume = ?, profit = ?, product_purchase_price = ? WHERE unique_code = ? AND id_account = ?");
            $database->bind(1, $sale_price);
            $database->bind(2, $final_price);
            $database->bind(3, $volume);
            $database->bind(4, $profit);
            $database->bind(5, $product_purchase_price);
            $database->bind(6, $unique_code);
            $database->bind(7, $register_by);
            $database->execute();
        } catch (Exception $exception) {
            error_log($exception);
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

    public function removeCart($unique_code)
    {
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query("UPDATE sales SET status = 4 WHERE id_account = ? AND unique_code = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $unique_code);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function deliveryCart($unique_code)
    {
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query("UPDATE sales SET status = 3, is_closed = 'Y' WHERE id_account = ? AND unique_code = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $unique_code);
            $database->execute();
            return true;
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