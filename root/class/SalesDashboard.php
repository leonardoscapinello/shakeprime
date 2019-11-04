<?php

class SalesDashboard
{


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

}