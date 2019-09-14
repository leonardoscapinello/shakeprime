<?php

class License
{
    private $id_license;
    private $id_account;
    private $serial_number;
    private $insert_time;
    private $expire_date;
    private $property_key;
    private $property_value;
    private $is_active;
    private $template_name;

    public function __construct()
    {
        global $account;
        global $database;
        global $charset;
        if ($account->isLogged()) {
            $id_account = $account->getIdAccount();
            try {
                $database->query("SELECT lc.id_license, lc.id_account, lc.insert_time, lc.template_name, lc.serial_number, lc.expire_date, lc.is_active from accounts2licenses a2l LEFT JOIN licenses lc ON lc.id_license = a2l.id_license WHERE a2l.id_account = ?");
                $database->bind(1, $id_account);
                $result = $database->resultsetObject();
                $rowCount = $database->rowCount();
                if ($rowCount > 0) {
                    foreach ($result as $key => $value) {
                        $charset->setString($value);
                        $this->$key = $charset->utf8();
                    }
                }
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    public function generateSerialNumber()
    {
        global $charset;
        $hash = uniqid('PAGS');
        $charset->setString($hash);
        return $charset->uppercase();
    }



}