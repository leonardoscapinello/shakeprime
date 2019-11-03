<?php
if (get_request("user") !== null) {
    $user = get_request("user");
    $account->removePrime($user);
    header("location: " . $this->getModuleURLByKey("P00002") . "?prime=N&user=" . $user);
}
?>