<?php

class Account
{

    private $id_account;
    private $id_company;
    private $username;
    private $email;
    private $name;
    private $password;
    private $phone;
    private $insert_time;
    private $mobile;
    private $is_active;
    private $birthday;
    private $session_cookie_name = "meupags";
    private $profile_picture;
    private $discount_level;

    private $is_admin = "N";
    private $is_prime = "N";
    private $force_reset = "Y";

    private $auth_username;
    private $auth_password;


    public function __construct()
    {
        global $database;
        global $charset;
        $id_account = $this->isLogged();
        if ($id_account > 0) {
            try {
                $database->query("SELECT * FROM accounts WHERE id_account = ?");
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


    public function load($id_account)
    {
        global $database;
        try {
            $database->query("SELECT * FROM accounts WHERE id_account = ?");
            $database->bind(1, $id_account);
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

    public function setAuthUsername($auth_username)
    {
        $this->auth_username = $auth_username;
    }

    public function setAuthPassword($auth_password)
    {
        $this->auth_password = $auth_password;
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
    public function getDiscountLevel()
    {
        return $this->discount_level;
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
    public function getProfilePicture()
    {
        return PAGS_IMAGES . "profile/" . ($this->profile_picture !== null ? $this->profile_picture : "012391023912930129302031.png");
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }


    /**
     * @return mixed
     */
    public function getIdCompany()
    {
        return $this->id_company;
    }

    /**
     * @param mixed $id_company
     */
    public function setIdCompany($id_company)
    {
        $this->id_company = $id_company;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getInsertTime()
    {
        return $this->insert_time;
    }

    /**
     * @param mixed $insert_time
     */
    public function setInsertTime($insert_time)
    {
        $this->insert_time = $insert_time;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /*
        public function isLogged()
        {
            return false;
        }
    */
    public function isLogged()
    {
        try {
            if (isset($_COOKIE[$this->session_cookie_name])) {
                if ($_COOKIE[$this->session_cookie_name] !== null && $_COOKIE[$this->session_cookie_name] !== "") {
                    global $database;
                    $database->query("SELECT id_account FROM accounts_sessions WHERE session_token = ? AND is_active = 'Y'");
                    $database->bind(1, $_COOKIE[$this->session_cookie_name]);
                    $rs = $database->single();
                    if (count($rs) > 0) {
                        return $rs['id_account'];
                    }
                }
            }
        } catch (Exception $exception) {

        } finally {
        }
    }

    private function getAccountBySession()
    {
        global $database;
        if ($this->isLogged()) {
            $cookie_key = $_COOKIE[$this->session_cookie_name];
            $database->query("SELECT username FROM accounts WHERE id_account = (SELECT id_account FROM accounts_sessions WHERE session_token = ? AND is_active = 'Y')");
            $database->bind(1, $cookie_key);
            $resultSet = $database->resultset();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                return $resultSet[0]['username'];
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getAuthUsername()
    {
        return $this->auth_username;
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->auth_password;
    }

    /**
     * @return string
     */
    public function getSessionCookieName()
    {
        return $this->session_cookie_name;
    }

    /**
     * @param string $session_cookie_name
     */
    public function setSessionCookieName($session_cookie_name)
    {
        $this->session_cookie_name = $session_cookie_name;
    }

    /**
     * @return string
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param string $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return string
     */
    public function getIsPrime()
    {
        return $this->is_prime;
    }

    /**
     * @param string $is_prime
     */
    public function setIsPrime($is_prime)
    {
        $this->is_prime = $is_prime;
    }

    /**
     * @return string
     */
    public function getForceReset()
    {
        return $this->force_reset;
    }

    /**
     * @param string $force_reset
     */
    public function setForceReset($force_reset)
    {
        $this->force_reset = $force_reset;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $bithday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }


    public function login()
    {
        global $security;
        global $database;
        global $pagsMailer;
        if ($this->getAuthUsername() !== null && $this->getAuthUsername() !== "") {
            if ($this->getAuthPassword() !== null && $this->getAuthPassword() !== "") {


                $database->query("SELECT id_account, email, name FROM accounts WHERE email = ? OR username = ? AND is_prime = 'Y' AND is_active = 'Y'");
                $database->bind(1, $this->getAuthUsername());
                $database->bind(2, $this->getAuthUsername());
                $resultset = $database->resultset();

                if (count($resultset) > 0) {


                    $id_account = $resultset[0]["id_account"];
                    $email_address = $resultset[0]["email"];
                    $name = $resultset[0]["name"];


                    $this->setIdAccount($id_account);
                    $forceReset = $this->isForceReset();
                    error_log($forceReset);
                    if ($forceReset) {

                        $database->query("SELECT token, small_token FROM accounts_token WHERE id_account = ? AND is_active = 'Y'");
                        $database->bind(1, $id_account);
                        $rs = $database->resultset();
                        if (count($rs) > 0) {
                            $args = array(
                                "name" => $name,
                                "username" => $email_address,
                                "small_token" => substr($rs[0]['small_token'], 0, 3) . "-" . substr($rs[0]['small_token'], 3, 3)
                            );

                            $pagsMailer->send($email_address, "Chegou a hora de inovar! Bem-vindo ao ShakePrime 🤝", "new-prime-reset", $args);
                            header("location: " . REGISTER_PAGS . "/" . $forceReset);
                            die();
                        }
                    }


                    $security->setIdAccount($id_account);
                    $security->setString($this->getAuthPassword());
                    $security->isHash(true);
                    $password = $security->encrypt();

                    $database->query("SELECT id_account FROM accounts WHERE id_account = ? AND password = ? AND (password != '' AND password IS NOT NULL)");
                    $database->bind(1, $id_account);
                    $database->bind(2, $password);
                    $resultAccount = $database->resultset();
                    if (count($resultAccount) > 0) {
                        $this->createSession($id_account);
                        return true;
                    }


                }


            }
        }
        return false;
    }


    public function logout()
    {
        global $database;
        if ($this->isLogged()) {
            $cookie = $_COOKIE;
            if ($cookie && isset($cookie[$this->session_cookie_name]) && $cookie[$this->session_cookie_name] !== null && $cookie[$this->session_cookie_name] !== "") {
                $cookie_key = $cookie[$this->session_cookie_name];
                $database->query("UPDATE accounts_sessions SET is_active = 'N' WHERE session_token = ? AND is_active = 'Y'");
                $database->bind(1, $cookie_key);
                $database->execute();
                $this->clearAccountSession();
                return true;
            }
        }
        return false;
    }

    private function createSession($id_account)
    {
        global $database;
        $session_key = md5(uniqid(rand(), true));
        if (!$this->isLogged()) {
            $database->query("INSERT INTO accounts_sessions (id_account, session_token, is_active) VALUES (?,?, 'Y')");
            $database->bind(1, $id_account);
            $database->bind(2, $session_key);
            $database->execute();
            $session_id = $database->lastInsertId();
            if ($session_id) {
                setcookie($this->session_cookie_name, $session_key, time() + (86400 * 30), "/");

                /*
                                $database->query("SELECT setting_value FROM accounts_settings WHERE id_account = ? AND setting_key = ?");
                                $database->bind(1, $id_account);
                                $database->bind(2, "LAST_ACCESS_COMPANY");
                                $database->execute();
                                $rset = $database->resultset();
                                if (count($rset) > 0) {
                                    $company = $rset[0]['setting_value'];
                                    setcookie("WEICOM_SESSION", base64_encode($company), time() + (86400 * 30), "/");
                                }


                                //setcookie("WEIUSR_SESSION", $session_key, time() + (86400 * 30), "/", ".buzr.us");

                */
            }
        }

    }

    private function clearAccountSession()
    {

        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
        session_destroy();
    }

    public function register()
    {
        global $database;
        $id_account = 0;
        $logged = $this->isLogged();
        try {
            if ($this->getName() !== null && $this->getName() !== "") {
                if ($this->getPassword() !== null && $this->getPassword() !== "") {
                    if ($this->getEmail() !== null && $this->getEmail() !== "") {
                        if ($this->getUsername() !== null && $this->getUsername() !== "") {
                            $database->query("INSERT INTO accounts (name, phone, email, username, is_active, is_prime, is_admin, force_reset, register_by) VALUES (?,?,?,?,?,?,?,?,?) ");
                            $database->bind(1, $this->getName());
                            $database->bind(2, $this->getPhone());
                            $database->bind(3, $this->getEmail());
                            $database->bind(4, $this->getUsername());
                            $database->bind(5, "Y");
                            $database->bind(6, $this->getIsPrime());
                            $database->bind(7, $this->getIsAdmin());
                            $database->bind(8, $this->getForceReset());
                            $database->bind(9, $logged);
                            $database->execute();
                            $id_account = $database->lastInsertId();

                            $database->query("INSERT INTO address (id_account) VALUES (?) ");
                            $database->bind(1, $id_account);
                            $database->execute();

                            $this->changePassword($this->getPassword(), $id_account);

                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        } finally {
            return $id_account;
        }


    }


    public function update($id_account)
    {
        global $database;
        try {
            if ($id_account !== 0) {
                if ($this->getName() !== "") {
                    if ($this->getEmail() !== "") {
                        if ($this->getUsername() !== "") {

                            if ($this->getBirthday() !== null && $this->getBirthday() !== "") {
                                $myDateTime = DateTime::createFromFormat('d/m/Y', $this->getBirthday());
                                $birthday = $myDateTime->format('Y-m-d');
                            } else {
                                $birthday = null;
                            }

                            $database->query("UPDATE accounts SET username = ?, email = ?, name = ?, phone = ?, mobile = ?, birthday = ? WHERE id_account = ?");
                            $database->bind(1, $this->getUsername());
                            $database->bind(2, $this->getEmail());
                            $database->bind(3, $this->getName());
                            $database->bind(4, $this->toNumbers($this->getPhone()));
                            $database->bind(5, $this->toNumbers($this->getMobile()));
                            $database->bind(6, $birthday);
                            $database->bind(7, $id_account);
                            $database->execute();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
            return false;
        } finally {
            return $id_account;
        }
    }

    private function toNumbers($value)
    {
        if ($value !== "") {
            return preg_replace("/[^0-9]/", "", $value);
        }
        return null;
    }


    public function changePassword($password = false, $id = false)
    {
        global $security;
        global $database;
        if ($password && $password !== "") {
            if ($id) {
                if (!is_int($id)) {
                    $id = intval($id);
                }
                if (!is_numeric($id)) {
                    return false;
                }
                $security->setString($password);
                $security->setIdAccount($id);
                $security->isHash(true);
                $new_password = $security->encrypt();
                $database->query("UPDATE accounts SET password = ?, force_reset = 'N' WHERE id_account = ?");
                $database->bind(1, $new_password);
                $database->bind(2, $id);
                $database->execute();


            }

        }
    }

    public function getLanguage()
    {
        return "pt-BR";
    }

    public function getCustomers()
    {
        $error = "";
        global $database;
        global $logger;
        try {
            $register_by = $this->isLogged();
            $database->query("SELECT id_account, name, username, birthday FROM accounts WHERE register_by = ?");
            $database->bind(1, $register_by);
            return $database->resultset();
        } catch (Exception $exception) {
            $error = $exception;
        } finally {
            if ($error !== "") {
                $logger->error($error);
            }
        }
    }

    public function getCustomersWithFilter($filter)
    {
        $error = "";
        global $database;
        global $logger;
        try {
            $register_by = $this->isLogged();
            $database->query("SELECT id_account, name, username, birthday FROM accounts WHERE register_by = :register_by AND (LOWER(name) LIKE :term OR LOWER(email) LIKE :term OR LOWER(username) LIKE :term OR LOWER(phone) LIKE :term) ORDER BY name ASC");
            $database->bind(":register_by", $register_by);
            $database->bind(":term", "%" . strtolower($filter) . "%");
            return $database->resultset();
        } catch (Exception $exception) {
            $error = $exception;
        } finally {
            if ($error !== "") {
                $logger->error($error);
            }
        }
    }

    public function getProfilePictureById($id_account)
    {
        $error = "";
        global $database;
        global $logger;
        try {
            $database->query("SELECT profile_picture FROM accounts WHERE id_account = ?");
            $database->bind(1, $id_account);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                return $rs[0]['profile_picture'];
            }
        } catch (Exception $exception) {
            $error = $exception;
            echo $exception;
        } finally {
            if ($error !== "") {
                $logger->error($error);
            }
        }
    }


    public function getMostLikedProducts($id_customer)
    {
        global $database;
        try {
            $database->query("SELECT pr.product_name, COUNT(pr.id_product) AS purchase_time FROM sales sa LEFT JOIN sales_products sp ON sp.id_sale = sa.id_shopping_cart LEFT JOIN products pr ON pr.id_product = sp.id_product WHERE sa.id_customer = ? GROUP BY pr.product_name");
            $database->bind(1, $id_customer);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                return $rs;
            }
        } catch (Exception $exception) {
            echo $exception;
        }
    }


    public function getAnalysis($id_customer)
    {
        global $database;
        try {
            $database->query("SELECT * FROM physical_analysis WHERE id_account = ? ORDER BY insert_time DESC");
            $database->bind(1, $id_customer);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                return $rs;
            }
        } catch (Exception $exception) {
            echo $exception;
        }
    }

    public function setAsPrime($id_customer, $is_prime = "Y")
    {
        global $database;
        try {
            $database->query("UPDATE accounts SET is_prime = ?, force_reset = 'N' WHERE id_account = ?");
            $database->bind(1, $is_prime);
            $database->bind(2, $id_customer);
            $database->execute();

            $database->query("UPDATE accounts_token SET is_active = 'N' WHERE id_account = ?");
            $database->bind(1, $id_customer);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function requestPrime($id_customer)
    {
        global $database;
        global $pagsMailer;
        try {
            $database->query("UPDATE accounts SET is_prime = 'Y', force_reset = 'Y' WHERE id_account = ?");
            $database->bind(1, $id_customer);
            $database->execute();

            $database->query("SELECT name, email FROM accounts WHERE id_account = ?");
            $database->bind(1, $id_customer);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                $args = array(
                    "name" => $rs[0]['name'],
                    "email" => $rs[0]['email'],
                );

                $pagsMailer->send($rs[0]['email'], "Seja muito bem-vindo(a)!", "welcome-to-prime", $args);
            }
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function removePrime($id_customer)
    {
        global $database;
        global $pagsMailer;
        try {
            $database->query("UPDATE accounts SET is_prime = 'N', force_reset = 'N' WHERE id_account = ?");
            $database->bind(1, $id_customer);
            $database->execute();

            $database->query("SELECT name, email FROM accounts WHERE id_account = ?");
            $database->bind(1, $id_customer);
            $rs = $database->resultset();
            if (count($rs) > 0) {
                $args = array(
                    "name" => $rs[0]['name'],
                    "email" => $rs[0]['email'],
                );

                $pagsMailer->send($rs[0]['email'], "Você foi incrível todo esse tempo!", "remove-prime", $args);
            }
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function isForceReset()
    {
        global $database;
        try {
            $token = $this->generateRandom(256, false);
            $small_token = $this->generateRandom(6, true);

            $id_account = $this->isLogged();
            if ($id_account === null || strlen($id_account) < 1) {
                $id_account = $this->getIdAccount();
            }


            $database->query("SELECT force_reset FROM accounts WHERE force_reset = 'Y' AND id_account = ?");
            $database->bind(1, $id_account);
            error_log("force reset for id " . $id_account);
            $rsAcc = $database->resultset();
            if (count($rsAcc) > 0) {

                $database->query("SELECT token, small_token FROM accounts_token WHERE id_account = ? AND is_active = 'Y'");
                $database->bind(1, $id_account);
                $rs = $database->resultset();
                if (count($rs) < 1) {
                    $database->query("INSERT INTO accounts_token (id_account, token, small_token) VALUES (?,?,?)");
                    $database->bind(1, $id_account);
                    $database->bind(2, $token);
                    $database->bind(3, $small_token);
                    $database->execute();
                    return $token;
                } else {
                    return $rs[0]['token'];
                }
            }
        } catch (Exception $exception) {
            echo $exception;
        }
        return false;
    }

    private function generateRandom($length = 10, $onlyNumbers = false)
    {
        $characters = "0123456789";
        if (!$onlyNumbers) $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
