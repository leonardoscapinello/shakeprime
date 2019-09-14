<?php

class Date
{

    private $additional;
    private $date;

    private function getAdditional()
    {
        global $account_settings;
        if ($this->additional == null || $this->additional == "") {
            return date($account_settings->getDateTimeFormat());
        }
        return $this->additional;
    }

    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }


    public function getDate()
    {
        global $account_settings;
        $newDate = date($account_settings->getDateFormat(), strtotime($this->getAdditional()));
        if ($this->date !== null) {
            $newDate = date($account_settings->getDateFormat(), strtotime($this->date));
        }
        $this->date = null;
        return $newDate;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDateTime()
    {
        global $account_settings;
        $newDate = date($account_settings->getDateTimeFormat(), strtotime($this->getAdditional()));
        if ($this->date !== null) {
            $newDate = date($account_settings->getDateTimeFormat(), strtotime($this->date));
        }
        $this->date = null;
        return $newDate;


    }
}
