<?php

class Logger
{

    private $log_path = DIRNAME . "../logs/";
    private $logfile = "grupowei.log";

    public function info($message)
    {
        $this->write($message, "INFO");
    }

    public function error($message)
    {
        $this->write($message, "ERROR");
    }


    public function init($message)
    {
        $this->write($message, "INIT");
    }


    private function write($message, $type)
    {
        $file = $this->log_path . $this->logfile;
        $content = "";
        if ($this->checkDirectory()) {
            if ($this->checkLogFile()) {
                $file_contents = file_get_contents($file);
                $fp = fopen($file, "wb");
                if (strlen($file_contents) > 10) {
                    $content = $file_contents . PHP_EOL;
                }
                $content .= $this->getDate();
                $content .= "\t[" . $type . "]";
                $content .= "\t" . $message;
                fwrite($fp, $content);
                fclose($fp);
            }
        }
    }

    private function getDate()
    {

        $date = "[" . date("d") . date("-m-Y H:i:s:u e +I") . "(" . date("l") . ")" . "]";
        return $date;
    }

    private function checkDirectory()
    {
        if (is_dir($this->log_path)) {
            return true;
        } else {
            return $this->createDirectory($this->log_path);
        }
    }


    private function checkLogFile()
    {

        if ($this->checkDirectory()) {
            if (file_exists($this->log_path . $this->logfile)) {
                return true;
            } else {
                return fopen($this->log_path . $this->logfile, "wb");
            }
        }
        return false;
    }

    private function createDirectory($dir)
    {
        if ($dir !== null) {
            if (!is_dir($dir)) {
                if (mkdir($dir, 0777, TRUE)) {
                    return true;
                }
            }
        }
        return false;
    }

}