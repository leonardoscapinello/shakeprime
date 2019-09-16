<?php

class Products
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

    public function getList()
    {
        $error = "";
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query($this->main_query);
            $database->bind(1, $id_account);
            $database->bind(2, $id_account);
            $database->bind(3, $id_account);
            return $database->resultset();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function getInStockList()
    {
        $error = "";
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
        $database->query("SELECT * FROM (".$this->main_query.") AS pr WHERE stock_quantity > 0");
            $database->bind(1, $id_account);
            $database->bind(2, $id_account);
            $database->bind(3, $id_account);
            return $database->resultset();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    /**
     * @return mixed
     */
    public function getProductImage()
    {
        return $this->product_image;
    }

    public function load($id_product)
    {
        global $charset;
        global $database;
        global $account;
        try {
            $id_account = $account->getIdAccount();
            $database->query($this->main_query . " AND pr.id_product = ?");
            $database->bind(1, $id_account);
            $database->bind(2, $id_account);
            $database->bind(3, $id_account);
            $database->bind(4, $id_product);
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




}
