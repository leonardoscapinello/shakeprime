<?php

class SalesDashboard
{

    public function getMonthName($substract_month)
    {
        $month = date('m', strtotime('-' . $substract_month . ' month'));
        $caption = "Janeiro";
        if ($month === "01") $caption = "Janeiro";
        if ($month === "02") $caption = "Fevereiro";
        if ($month === "03") $caption = "Março";
        if ($month === "04") $caption = "Abril";
        if ($month === "05") $caption = "Maio";
        if ($month === "06") $caption = "Junho";
        if ($month === "07") $caption = "Julho";
        if ($month === "08") $caption = "Agosto";
        if ($month === "09") $caption = "Setembro";
        if ($month === "10") $caption = "Outubro";
        if ($month === "11") $caption = "Novembro";
        if ($month === "12") $caption = "Dezembro";
        return $caption;
    }

    public function getTotalSalesFinished()
    {
        global $account;
        global $database;
        $id_account = $account->isLogged();
        $database->query("SELECT SUM(sale_price) result FROM sales WHERE id_account = ? AND status IN (2,3) AND (sale_start_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW())");
        $database->bind(1, $id_account);
        $rs = $database->resultset();
        if (count($rs) > 0) {
            return $rs[0]['result'];
        }
        return 0;
    }

    public function getTotalSalesNotFinished()
    {
        global $account;
        global $database;
        $id_account = $account->isLogged();
        $database->query("SELECT SUM(sale_price) result FROM sales WHERE id_account = ? AND status = 1 AND (sale_start_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW())");
        $database->bind(1, $id_account);
        $rs = $database->resultset();
        if (count($rs) > 0) {
            return $rs[0]['result'];
        }
        return 0;
    }

    public function getTotalVolumeFinished()
    {
        global $account;
        global $database;
        $id_account = $account->isLogged();
        $database->query("SELECT SUM(volume) result FROM sales WHERE id_account = ? AND status IN (2,3) AND (sale_start_date BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW())");
        $database->bind(1, $id_account);
        $rs = $database->resultset();
        if (count($rs) > 0) {
            return $rs[0]['result'];
        }
        return 0;
    }

    public function getTotalFromPastMonth($substract_months)
    {
        global $account;
        global $database;
        $id_account = $account->isLogged();
        $database->query("SELECT SUM(sa.profit) profit, SUM(sa.sale_price) sale_price, SUM(sa.final_price) final_price FROM   sales sa WHERE  sa.id_account = ? AND MONTH(sa.sale_done_date) = (MONTH(Now()) - ?) GROUP  BY MONTH(sa.sale_done_date), YEAR(sa.sale_done_date) ");
        $database->bind(1, $id_account);
        $database->bind(2, $substract_months);
        $rs = $database->resultset();
        $profit = 0;
        $sale_price = 0;
        $final_price = 0;
        if (count($rs) > 0) {
            $profit = $rs[0]['profit'];
            $sale_price = $rs[0]['sale_price'];
            $final_price = $rs[0]['final_price'];
        }
        $array = array(
            "profit" => $profit,
            "sale_price" => $sale_price,
            "final_price" => $final_price,
        );
        return $array;
    }

    public function getConvertionRate()
    {
        global $account;
        global $database;
        $id_account = $account->isLogged();
        $database->query("SELECT * FROM ( SELECT 'done' AS caption, COUNT(id_shopping_cart) AS value FROM sales WHERE id_account = ? AND MONTH(sale_done_date) = MONTH(NOW()) AND YEAR(sale_done_date) = YEAR(NOW()) AND is_closed = 'Y' UNION ALL SELECT 'total' AS caption, COUNT(id_shopping_cart) AS value FROM sales WHERE id_account = ? AND MONTH(sale_done_date) = MONTH(NOW()) AND YEAR(sale_done_date) = YEAR(NOW()) ) tb");
        $database->bind(1, $id_account);
        $database->bind(2, $id_account);
        $rs = $database->resultset();
        $sales_done = 0;
        $sales_total = 0;
        if (count($rs) > 0) {
            for ($i = 0; $i < count($rs); $i++) {
                if($rs[$i]['caption'] === "done") $sales_done = $rs[$i]['value'];
                if($rs[$i]['caption'] === "total") $sales_total = $rs[$i]['value'];
            }
        }
        $percent = ($sales_done / $sales_total) * 100;
        return $percent;
    }

}