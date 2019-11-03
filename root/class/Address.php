<?php

use http\Client\Curl\User;

class Address
{

    private $id_address;
    private $id_account;
    private $address;
    private $neighborhood;
    private $state;
    private $number;
    private $complement;
    private $zipcode;
    private $city;


    public function load($id_account)
    {
        global $database;
        global $charset;
        try {
            $database->query("SELECT * FROM address WHERE id_account = ?");
            $database->bind(1, $id_account);
            $result = $database->resultsetObject();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                foreach ($result as $key => $value) {
                    if ($value !== null && $value !== "") {
                        if ($key !== "id_address" && $key !== "id_account") {
                            $value = base64_decode($value);
                        }
                        $charset->setString($value);
                        $this->$key = $charset->utf8();
                    }
                }
            }
        } catch (Exception $exception) {
            echo $exception;
        }
    }

    public function update($id_account)
    {
        global $database;
        global $charset;
        try {


            if ($id_account !== 0) {
                $database->query("UPDATE address SET address = ?, neighborhood = ?, state = ?, number = ?, complement = ?, zipcode = ?, city = ? WHERE id_account = ?");
                $database->bind(1, base64_encode($this->getAddress()));
                $database->bind(2, base64_encode($this->getNeighborhood()));
                $database->bind(3, base64_encode($this->getState()));
                $database->bind(4, base64_encode($this->getNumber()));
                $database->bind(5, base64_encode($this->getComplement()));
                $database->bind(6, base64_encode($this->getZipcode()));
                $database->bind(7, base64_encode($this->getCity()));
                $database->bind(8, $id_account);
                $database->execute();
                return $id_account;
            }
        } catch (Exception $e) {
            error_log($e);

        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getIdAddress()
    {
        return $this->id_address;
    }

    /**
     * @param mixed $id_address
     */
    public function setIdAddress($id_address)
    {
        $this->id_address = $id_address;
    }

    /**
     * @return mixed
     */
    public function getIdAccount()
    {
        return $this->id_account;
    }

    /**
     * @param mixed $id_account
     */
    public function setIdAccount($id_account)
    {
        $this->id_account = $id_account;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * @param mixed $neighborhood
     */
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $complement
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


}
