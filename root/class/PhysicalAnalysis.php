<?php

class PhysicalAnalysis
{

    private $id_analysis;
    private $id_account;
    private $id_coach;
    private $body_mass;
    private $body_fat;
    private $muscle_mass;
    private $visceral_fat;
    private $insert_time;

    public function load($id_analysis)
    {
        global $database;
        global $account;
        try {
            $id_coach = $account = $account->getIdAccount();
            $database->query("SELECT * FROM physical_analysis WHERE id_analysis = ? AND id_coach = ?");
            $database->bind(1, $id_analysis);
            $database->bind(2, $id_coach);
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

    public function register()
    {
        global $database;
        global $account;
        try {

            if ($this->getIdAccount() !== "") {
                if ($this->getBodyMass() !== "") {
                    if ($this->getBodyFat() !== "") {
                        if ($this->getMuscleMass() !== "") {
                            if ($this->getVisceralFat() !== "") {

                                $id_coach = $account = $account->getIdAccount();
                                $database->query("INSERT INTO physical_analysis (id_account, id_coach, body_mass, body_fat, muscle_mass, visceral_fat) VALUES (?, ?, ?, ?, ?, ?)");
                                $database->bind(1, $this->getIdAccount());
                                $database->bind(2, $id_coach);
                                $database->bind(3, $this->getBodyMass());
                                $database->bind(4, $this->getBodyFat());
                                $database->bind(5, $this->getMuscleMass());
                                $database->bind(6, $this->getVisceralFat());
                                $database->execute();
                                return $database->lastInsertId();

                            }
                        }
                    }
                }
            }

            return false;

        } catch (Exception $exception) {
            echo $exception;
        }
    }

    /**
     * @return mixed
     */
    public function getIdAnalysis()
    {
        return $this->id_analysis;
    }

    /**
     * @param mixed $id_analysis
     */
    public function setIdAnalysis($id_analysis)
    {
        $this->id_analysis = $id_analysis;
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
    public function getBodyMass()
    {
        return $this->body_mass;
    }

    /**
     * @param mixed $body_mass
     */
    public function setBodyMass($body_mass)
    {
        $this->body_mass = $body_mass;
    }

    /**
     * @return mixed
     */
    public function getBodyFat()
    {
        return $this->body_fat;
    }

    /**
     * @param mixed $body_fat
     */
    public function setBodyFat($body_fat)
    {
        $this->body_fat = $body_fat;
    }

    /**
     * @return mixed
     */
    public function getMuscleMass()
    {
        return $this->muscle_mass;
    }

    /**
     * @param mixed $muscle_mass
     */
    public function setMuscleMass($muscle_mass)
    {
        $this->muscle_mass = $muscle_mass;
    }

    /**
     * @return mixed
     */
    public function getVisceralFat()
    {
        return $this->visceral_fat;
    }

    /**
     * @param mixed $visceral_fat
     */
    public function setVisceralFat($visceral_fat)
    {
        $this->visceral_fat = $visceral_fat;
    }


}