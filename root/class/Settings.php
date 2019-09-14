<?php

class Settings
{


    public function getValue($settings_key)
    {
        global $database;
        $database->query("SELECT setting_value FROM settings WHERE setting_key = ?");
        $database->bind(1, $settings_key);
        $resultset = $database->resultset();
        if (count($resultset) > 0) {
            $rs = $resultset[0];
            return $rs['setting_value'];
        }
        return null;
    }


    public function getServerURL()
    {
        return $this->getValue("SERVER_URL");
    }

    public function getDashboardURL()
    {
        return $this->getValue("DASHBOARD_URL");
    }

    public function getDate($timeMath)
    {
        global $account_settings;
        return date($account_settings->getDateFormat(), strtotime($timeMath));

    }

    public function getDateTime($timeMath)
    {
        global $account_settings;
        return date($account_settings->getDateTimeFormat(), strtotime($timeMath));

    }

}