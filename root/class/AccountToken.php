<?php

class AccountsToken
{

    private $id_account;
    private $token;
    private $small_token;
    private $name;


    public function load($token)
    {
        global $database;
        try {
            $database->query("SELECT * FROM accounts_token at LEFT JOIN accounts ac ON ac.id_account = at.id_account WHERE at.token = ?");
            $database->bind(1, $token);
            $result = $database->resultsetObject();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                foreach ($result as $key => $value) {
                    $this->$key = $value;
                }
            }
        } catch (Exception $exception) {
            echo $exception;
        }
    }

    /**
     * @return mixed
     */
    public function getIdAccount()
    {
        return $this->id_account;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getSmallToken()
    {
        return $this->small_token;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



}
