<?php


class Security
{

    private $block_size = 256;
    private $id_account;
    private $string;
    private $aes;
    private $hash = false;

    public function __construct()
    {
        //global $account;
        //$this->id_account = $account->getIdAccount();
    }

    public function encrypt()
    {
        $this->aes = new AES($this->string, $this->getMasterKey(), $this->block_size);
        if ($this->hash) return strtoupper(md5($this->aes->encrypt()));
        return $this->aes->encrypt();
    }

    public function decrypt()
    {
        $this->aes = new AES($this->string, $this->getMasterKey(), $this->block_size);
        return $this->aes->decrypt();
    }

    public function setString($string)
    {
        $this->string = $string;
    }

    public function setIdAccount($id_account)
    {
        $this->id_account = $id_account;
    }

    public function isHash($hash)
    {
        if ($hash) {
            $this->hash = true;
        } else {
            $this->hash = false;
        }
    }


    private function getMasterKey()
    {

        global $database;
        global $account;
        if ($this->id_account !== "") {
            if (is_numeric($this->id_account)) {
                $account->load($this->id_account);
                $insert_time = $account->getInsertTime();
                $day = date("d", strtotime($insert_time));
                $month = date("m", strtotime($insert_time));
                $year = date("Y", strtotime($insert_time));
                $hour = date("H", strtotime($insert_time));
                $minute = date("i", strtotime($insert_time));
                $hash_day = $this->getMasterPiece("days", $day);
                $hash_month = $this->getMasterPiece("days", $month);
                $hash_year = $this->getMasterPiece("days", $year);
                $hash_hour = $this->getMasterPiece("days", $hour);
                $hash_minute = $this->getMasterPiece("days", $minute);
                $master_key = $hash_day . $hash_month . $hash_year . $hash_hour . $hash_minute;
                $master_key = md5($master_key);
                return $master_key;
            }
        }


    }

    private function getMasterPiece($master, $secondary)
    {

        $buffer = file_get_contents(DIRNAME . "../properties/security.xml");
        $xml = simplexml_load_string($buffer);
        $security = XML2Array($xml);
        $security = array(
            $xml->getName() => $security
        );
        if ($security !== null && is_array($security)) {
            $security_master = $security["security"][$master];
            if ($security_master !== null && is_array($security_master)) {
                if (array_key_exists("P" . $secondary, $security_master)) {
                    $security_secondary = $security_master["P" . $secondary];
                    if ($security_secondary !== null && $security_secondary !== "") {
                        return ($security_secondary);
                    }
                }
            }
            return null;
        }
    }

}

?>