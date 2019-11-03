<?php

class SalesProducts
{

    private $main_query = "SELECT pr.id_product, pr.sku, pr.product_name, pr.volume, pr.sale_price, pr.level_price_a, pr.level_price_b, pr.level_price_c, pr.level_price_d, pr.fractional_cost, pr.product_image, CASE WHEN st.quantity < 1 THEN 0 WHEN st.quantity IS NULL THEN 0 ELSE CASE WHEN rq.reserved_quantity IS NULL THEN st.quantity ELSE (st.quantity - rq.reserved_quantity) END END AS stock_quantity FROM products pr LEFT JOIN (SELECT id_product, quantity, id_account FROM stock WHERE avaiable = 'Y' GROUP BY id_product, id_account) st ON st.id_account = ? AND st.id_product = pr.id_product LEFT JOIN (SELECT sp.id_product, CASE WHEN sp.quantity IS NULL THEN 0 ELSE SUM(sp.quantity) END AS reserved_quantity FROM sales_products sp LEFT JOIN sales sa ON sa.id_shopping_cart = sp.id_sale WHERE is_closed = 'N' AND id_account = ? GROUP BY id_account, id_product) rq ON rq.id_product = pr.id_product WHERE (pr.id_account = 0 OR pr.id_account = ?) AND pr.is_active = 'Y'";

    private $id_product;
    private $sku;
    private $product_name;
    private $volume;
    private $sale_price;
    private $level_price_a;
    private $level_price_b;
    private $level_price_c;
    private $level_price_d;
    private $fractional_cost;
    private $stock_quantity;
    private $product_image;

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
                    } else {
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
            $database->query("SELECT sp.id_sale_product, sp.sale_price, sp.sold_price, sp.discount_applied, sp.quantity, pr.product_name, pr.product_image, pr.volume, pr.level_price_a, pr.level_price_b, pr.level_price_c, pr.level_price_d FROM sales_products sp LEFT JOIN products pr ON pr.id_product = sp.id_product WHERE sp.id_sale = (SELECT id_shopping_cart FROM sales WHERE unique_code = ? AND id_account = ?)");
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

    public function editCartProduct($id_sale_product, $quantity)
    {
        global $database;
        global $account;
        try {
            if ($quantity < 1) {
                $database->query("DELETE FROM sales_products WHERE id_sale_product = ?");
                $database->bind(1, $id_sale_product);
                $database->execute();
                return true;
            } else {
                $database->query("UPDATE sales_products SET quantity = ? WHERE id_sale_product = ?");
                $database->bind(1, $quantity);
                $database->bind(2, $id_sale_product);
                $database->execute();
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }

        return false;

    }

    public function loadCartProduct($id_sale_product)
    {
        global $charset;
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query($this->main_query . " AND pr.id_product = (SELECT id_product FROM sales_products WHERE id_sale_product = ?)");
            $database->bind(1, $id_account);
            $database->bind(2, $id_account);
            $database->bind(3, $id_account);
            $database->bind(4, $id_sale_product);
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
     * @return string
     */
    public function getMainQuery()
    {
        return $this->main_query;
    }

    /**
     * @return mixed
     */
    public function getIdProduct()
    {
        return $this->id_product;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
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
    public function getLevelPriceA()
    {
        return $this->level_price_a;
    }

    /**
     * @return mixed
     */
    public function getLevelPriceB()
    {
        return $this->level_price_b;
    }

    /**
     * @return mixed
     */
    public function getLevelPriceC()
    {
        return $this->level_price_c;
    }

    /**
     * @return mixed
     */
    public function getLevelPriceD()
    {
        return $this->level_price_d;
    }

    /**
     * @return mixed
     */
    public function getFractionalCost()
    {
        return $this->fractional_cost;
    }

    /**
     * @return mixed
     */
    public function getStockQuantity()
    {
        return $this->stock_quantity;
    }

    /**
     * @return mixed
     */
    public function getProductImage()
    {
        return $this->product_image;
    }




}