<?php

class Encoding
{

    public function encode($data)
    {
        if (!$this->is_encoded($data)) {
            return base64_encode($data);
        }
        return $data;
    }

    public function decode($data)
    {
        if ($this->is_encoded($data)) {
            return base64_decode($data);
        }
        return $data;
    }

    function is_encoded($s)
    {
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if (false === $decoded) return false;

        // Encode the string again
        if (base64_encode($decoded) != $s) return false;

        return true;
    }

    function convertDate($date)
    {
        return date("Y/m/d H:i", strtotime($date));
    }

}