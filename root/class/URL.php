<?php

class URL
{
    private $url;

    public function setURL($url)
    {
        $this->url = $url;
    }

    private function getURL()
    {
        return $this->url;
    }

    private function getURLStatus()
    {
        $url = $this->getURL();
        $headers = $this->getHeaders($url);
        if ($headers !== 0 && $headers !== "0") {
            return true;
        }
        return false;
    }


    public function getTitle()
    {
        $url = $url = $this->getURL();
        $str = @file_get_contents($url);

        if ($str === FALSE) return null;

        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title); // ignore case
            if (isset($title[1])) {
                return $title[1];
            }
        }
    }

    private function getHeaders($url)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_NOBODY, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($c);
        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);
        return $status;
    }


    public function URLExists()
    {

        if ($this->getURLStatus()) {
            return true;
        }
        return false;
    }

    public function getURLContents()
    {

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $this->url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $jsonData = curl_exec($curlSession);
        curl_close($curlSession);
        return $jsonData;

    }


    public function getActualURL()
    {
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("?", $actual_link);
        if (count($actual_link) > 0) {
            return $actual_link[0];
        }
        return $actual_link;
    }


    public function getMetaTags($meta_tag_name)
    {

        $url = $this->getURL();
        $tags = @get_meta_tags($url);

        if ($tags === FALSE) return null;

        if (array_key_exists($meta_tag_name, $tags)) {
            return $tags[$meta_tag_name];
        }
        return null;


    }

    private function getInfoFromDomain()
    {
        $url = $this->getURL();
        $parse = parse_url($url);
        return $parse;
    }

    public function getHost()
    {
        $r = $this->getInfoFromDomain();
        if ($r !== null && array_key_exists("host", $r)) {
            return $r['host'];
        }
    }

    public function getHostWithoutHTTP()
    {
        $url = $this->getHost();
        $url = str_replace("http://", "", $url);
        $url = str_replace("https://", "", $url);
        return $url;
    }

    public function getScheme()
    {
        try {
            $r = $this->getInfoFromDomain();
            if ($r !== null && array_key_exists("scheme", $r)) {
                return $r['scheme'];
            }
        } catch (Exception $e) {
            return null;
        }

    }

    public function getPath()
    {
        $r = $this->getInfoFromDomain();
        if ($r !== null && array_key_exists("path", $r)) {
            return $r['path'];
        }
    }

    public function externalFileExist()
    {
        $url = $this->getURL();
        $header_response = @get_headers($url, 1);
        if ($header_response === FALSE) return false;
        if (strpos($header_response[0], "200") !== false) return true;

        // IF NOT HTTP, TRY HTTPS

        $url = str_replace("http://", "https://", $url);
        $header_response = @get_headers($url, 1);
        if ($header_response === FALSE) return false;
        if (strpos($header_response[0], "200") !== false) return true;

        return false;

    }

}