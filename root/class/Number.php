<?php
setlocale(LC_MONETARY, 'en_US');

class Number
{

    private $number = 0;

    public function is_numeric()
    {
        if (is_numeric($this->number)) {
            return true;
        }
        return false;
    }

    public function money()
    {
        if ($this->is_numeric()) {
            return number_format($this->number, 2, ",", ".");
        }
        return number_format(0, 2);
    }

    public function singleMoney($money)
    {
        $this->setNumber($money);
        return $this->money();
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function noDecimal()
    {
        if ($this->is_numeric()) {
            return number_format($this->number, 0, ",", ".");
        }
        return number_format(0, 0, ",", ".");
    }


}