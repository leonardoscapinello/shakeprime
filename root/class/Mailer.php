<?php


class Mailer
{

    private function getPage($url)
    {

        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
            CURLOPT_POST => false,        //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;

    }

    public function send($to, $title, $template, $args = array())
    {

        global $mailer;

        try {


            $mailer->IsSMTP();
            $mailer->SMTPAuth = true;
            $mailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mailer->CharSet = 'UTF-8';
            $mailer->Host = "mail.leonardosamara.com";
            $mailer->Port = "587";
            $mailer->IsHTML(true);
            $mailer->Username = "informativo@leonardosamara.com";
            $mailer->Password = "AJ#z]XjUaG-8";
            $mailer->Subject = $title;
            $mailer->SetFrom("informativo@leonardosamara.com", "ShakePrime Pags");
            $mailer->AddAddress("leonardo.scapinello@outlook.com");
            //$mailer->AddAddress($to);
            $template = $this->getPage(PAGS_NOTIFICATION_TEMPLATE . "/" . $template . ".php");
            $template = $template["content"];
            foreach ($args as $key => $value) {
                $template = str_replace("#" . $key, $value, $template);
            }


            $mailer->Body = $template;
            if ($mailer->send()) {
                return true;
            }
            $mailer->ClearAllRecipients();

        } catch (Exception $e) {
            echo $e;
        }
    }


}