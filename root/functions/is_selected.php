<?php

function is_selected($field_value, $request_index)
{
    global $logger;
    global $charset;
    $return = "";
    $error = "";

    try {
        if (isset($_REQUEST[$request_index]) && $_REQUEST[$request_index] !== "") {
            if (strlen($_REQUEST[$request_index]) > 0) {
                if ($field_value === $_REQUEST[$request_index]) {
                    $return = "selected=\"selected\"";
                }
            }
        }
    } catch (Exception $exception) {
        $error = $exception;
    } finally {        
        return $return;
    }
}


?>