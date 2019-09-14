<?php
if (!$account->isLogged()) {
    header("location: " . LOGIN_PAGE);
    die;
} else {

    /*if (!$company->isCompanySet()) {
        if ($module->getRequest() !== $module->getModuleURLByKey("P00008", true)) {
            if ($module->getRequest() !== $settings->getValue("COMPANY_SELECTION_PAGE")) {
                header("location: " . SERVER_URL . $settings->getValue("COMPANY_SELECTION_PAGE"));
                die;
            }
        }
    }*/


}

