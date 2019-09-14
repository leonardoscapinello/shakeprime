<?php

class Browser
{

    private $user_agent = "";

    public function setAgent($agent = false)
    {
        if ($agent) {
            $this->user_agent = $agent;
        } else {
            $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        }
    }


    private function getAgent()
    {
        if ($this->user_agent == null) $this->setAgent();
        return $this->user_agent;
    }


    private function getBrowser()
    {


        $u_agent = $this->getAgent();
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match("/Trident/i", $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "Trident";
        } elseif (preg_match("/Edge/i", $u_agent)) {
            $bname = 'Microsoft Edge';
            $ub = "Edge";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        if ($ub === "Trident") {
            $known = array('Version', "rv", 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[: ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $u_agent, $matches)) {
                // we have no matching number just continue
            }
        } else {
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $u_agent, $matches)) {
                // we have no matching number just continue
            }
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern,
            'icon' => 'fa fa-' . strtolower($ub)
        );
    }


    public function getBrowserName()
    {
        $browser = $this->getBrowser();
        if ($browser !== null) {
            return $browser['name'];
        }
    }

    public function getPlatform()
    {
        $browser = $this->getBrowser();
        if ($browser !== null) {
            return ucwords($browser['platform']);
        }
    }

    public function getPattern()
    {
        $browser = $this->getBrowser();
        if ($browser !== null) {
            return ucwords($browser['pattern']);
        }
    }


    public function getVersion()
    {
        $browser = $this->getBrowser();
        if ($browser !== null) {
            return ucwords($browser['version']);
        }
    }

    public function getIcon()
    {
        $browser = $this->getBrowser();
        if ($browser !== null) {
            if ($browser['icon'] === "fa fa-trident" || $browser['icon'] === "fa fa-msie") {
                $icon = "fa fa-internet-explorer";
            } else {
                $icon = $browser['icon'];
            }
            return "<i class=\"" . $icon . " list-icon-browser\" style=\"margin-right:10px;\"></i>";

        }
    }

    public function getOperatingSystem()
    {

        $user_agent = $this->getAgent();

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }

        }

        return $os_platform;

    }


}