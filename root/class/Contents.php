<?php

class Contents
{

    private $id_content;
    private $content_title;
    private $content_load;
    private $content_url;
    private $content_exists;


    public function __construct()
    {
        global $database;
        global $charset;
        if ($this->getRequestModule()) {
            $module_url = $this->getRequestModule();
            try {
                $database->query("SELECT * FROM contents WHERE content_url = ?");
                $database->bind(1, $module_url);
                $result = $database->resultsetObject();
                $rowCount = $database->rowCount();
                if ($rowCount > 0) {
                    $this->content_exists = true;
                    foreach ($result as $key => $value) {
                        $charset->setString($value);
                        $this->$key = $charset->utf8();
                    }
                } else {
                    $this->content_exists = false;
                }
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    private function getRequestModule()
    {
        return get_request("module");
    }

    /**
     * @return mixed
     */
    public function getIdContent()
    {
        return $this->id_content;
    }

    /**
     * @return mixed
     */
    public function getContentTitle()
    {
        return $this->content_title;
    }

    /**
     * @return mixed
     */
    public function getContentLoad()
    {
        return $this->content_load;
    }

    /**
     * @return mixed
     */
    public function getContentUrl()
    {
        return $this->content_url;
    }

    public function getContentExists()
    {
        return $this->content_exists;
    }


}
