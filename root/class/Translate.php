<?php

class Translate
{

    private $language = 'en';
    private $lang = array();

    public function __construct()
    {
        $language = "en";
        try {
            global $account;
            $language = $account->getLanguage();
        } catch (Exception $exception) {

        } finally {
            $this->language = $language;
        }
    }

    private function search($str, $replaces = array())
    {
        $var_pattern = "%s";
        $translated = $str;


        if (array_key_exists($str, $this->lang[$this->language])) {
            $translated = $this->lang[$this->language][$str];

            if (count($replaces) > 0) {
                $count_patterns = substr_count($translated, $var_pattern);
                if ($count_patterns == count($replaces)) {
                    return vsprintf($translated, $replaces);
                } else {
                    if ($count_patterns > count($replaces)) {
                        return "Too much arguments";
                    } else {
                        return "Too low arguments";
                    }
                }

            }
        }
        return $translated;
    }


    private function replaceOccurence($search, $replace, $subject, $occurrence)
    {
        return substr_replace($search, $replace, $occurrence);
    }

    private function getLanguageDocument()
    {
        $default_path = DIRNAME;
        $default_path .= "../language/" . $this->language . ".lang";

        return $default_path;
    }


    private function splitStrings($str)
    {
        return explode('=', trim($str));
    }

    public function __($str, $replaces = array())
    {
        global $charset;
        if (!array_key_exists($this->language, $this->lang)) {

            $l_doc = $this->getLanguageDocument();

            if (file_exists($l_doc)) {
                $strings = array_map(array($this, 'splitStrings'), file($l_doc));
                foreach ($strings as $k => $v) {
                    if (substr($v[0], 0, 1) !== "#" && substr($v[0], 0, 1) !== "") {
                        if (array_key_exists(1, $v)) {
                            $this->lang[$this->language][$v[0]] = $v[1];
                        }
                    }
                }
                return $this->search($str, $replaces);
            } else {
                $charset->setString($str);
                return $charset->utf8();
            }
        } else {
            return $this->search($str, $replaces);
        }
    }


}
