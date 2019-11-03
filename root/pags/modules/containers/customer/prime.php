<?php
if (get_request("user") !== null) {
    $user = get_request("user");
    $account->requestPrime($user);
    header("location: " . $this->getModuleURLByKey("P00002") . "?prime=Y&user=" . $user);
}
?>