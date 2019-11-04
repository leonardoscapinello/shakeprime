<?php

class Module
{

    private $id_module;
    private $id_account;
    private $id_category;
    private $module_key;
    private $module_icon;
    private $module_title;
    private $module_url;
    private $module_page;
    private $is_enabled;
    private $is_navigation_visible;
    private $is_new;
    private $category_name;
    private $nav_order;
    private $template_path = DIRNAME . "../pags/modules/containers/";
    private $toolbar_path = DIRNAME . "../pags/modules/toolbars/";
    private $module_exists = false;
    private $header_visible = true;
    private $sidebar_visible = true;
    private $toolbar = false;

    public function __construct()
    {
        global $database;
        global $charset;
        try {
            $database->query("SELECT * FROM modules m LEFT JOIN modules_category mc ON mc.id_category = m.id_category WHERE m.module_url = ?");
            $database->bind(1, $this->getRequest());
            $result = $database->resultsetObject();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                $this->module_exists = true;
                foreach ($result as $key => $value) {
                    $charset->setString($value);
                    $this->$key = $charset->utf8();
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getToolbar()
    {
        global $settings;
        global $date;
        global $database;
        global $charset;
        global $translate;
        global $account;
        global $account_settings;
        if ($this->getModuleExists()) {
            $toolbar = $this->toolbar_path . $this->getToolbarContent();
            if ($this->hasToolbar()) {
                if (file_exists($toolbar)) {
                    require_once($toolbar);
                }
            }
        }
        return null;
    }

    public function getContent()
    {
        global $customer;
        global $settings;
        global $database;
        global $charset;
        global $translate;
        global $account;
        global $account_settings;
        global $address;
        global $products;
        global $number;
        global $sales;
        global $salesProducts;
        global $stock;
        global $physicalAnalysis;
        global $pagsMailer;
        global $salesDashboard;
        try {
            if ($this->getModuleExists()) {
                $file = $this->template_path . $this->getModulePage();
                if (!file_exists($file)) {
                    $file = $this->template_path . "error/404.php";
                }
            } else {
                $file = $this->template_path . "error/404.php";
            }
        } catch (Exception $exception) {
            $file = $this->template_path . "error/500.php";
        } finally {

            require_once($file);

        }
    }

    private function getModuleExists()
    {
        return $this->module_exists;
    }

    public function getHeaderVisible()
    {
        return $this->header_visible;
    }

    public function setHeaderVisible($state)
    {
        $this->header_visible = $state;
    }

    public function getSidebarVisible()
    {
        return $this->sidebar_visible;
    }

    public function setSidebarVisible($state)
    {
        $this->sidebar_visible = $state;
    }

    public function getIdModule()
    {
        return $this->id_module;
    }

    public function getIdAccount()
    {
        return $this->id_account;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

    public function getModuleKey()
    {
        return $this->module_key;
    }

    public function getModuleIcon()
    {
        return $this->module_icon;
    }

    public function getModuleTitle()
    {
        return translate($this->module_title);
    }

    public function getModuleUrl()
    {
        return $this->module_url;
    }

    public function hasToolbar()
    {
        return $this->toolbar == "Y" ? true : false;
    }

    public function getModulePage()
    {
        return $this->module_page;
    }

    public function getToolbarContent()
    {
        return $this->module_page;
    }

    public function getisEnabled()
    {
        return $this->is_enabled;
    }

    public function getisNavigationVisible()
    {
        return $this->is_navigation_visible;
    }

    public function getisNew()
    {
        return $this->is_new;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getNavOrder()
    {
        return $this->nav_order;
    }

    public function getRequest()
    {
        $requested = "index";
        try {
            if (isset($_REQUEST['module']) && $_REQUEST['module'] !== "") {
                $requested = $_REQUEST['module'];


            }
        } catch (Exception $exception) {

        } finally {
            return $requested;
        }
    }

    private function getModuleInfo($id_module, $column_name)
    {
        try {
            global $database;
            global $charset;
            $database->query("SELECT * FROM modules m LEFT JOIN modules_category mc ON mc.id_category = m.id_category WHERE m.id_module = ?");
            $database->bind(1, $id_module);
            $resultSet = $database->resultset();
            $rowCount = $database->rowCount();
            if ($rowCount > 0) {
                if (array_key_exists($column_name, $resultSet[0])) {
                    $charset->setString($resultSet[0][$column_name]);
                    return translate($charset->utf8());
                }
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function getCategoryInfo($id_category, $column_name)
    {
        try {
            global $database;
            global $charset;
            $database->query("SELECT * FROM modules_category mc WHERE mc.id_category = ?");
            $database->bind(1, $id_category);
            $resultSet = $database->resultset();
            $rowCount = $database->rowCount();


            if ($rowCount > 0) {
                if (array_key_exists($column_name, $resultSet[0])) {
                    $charset->setString($resultSet[0][$column_name]);
                    return translate($charset->utf8());
                }
            }
        } catch (Exception $exception) {
            echo $exception;
        }
    }


    public function getSidebarNavigation()
    {
        global $database;
        global $settings;
        $database->query("SELECT m.id_category, GROUP_CONCAT(m.id_module SEPARATOR ',') module_result FROM modules m LEFT JOIN modules_category mc ON mc.id_category = m.id_category WHERE mc.is_enabled = 'Y' AND m.is_enabled = 'Y' AND m.is_navigation_visible = 'Y' GROUP BY m.id_category");
        $resultSet = $database->resultset();
        $rowCount = $database->rowCount();
        $menu = "<ul class=\"navigation\">";
        if ($rowCount > 0) {
            for ($i = 0; $i < $rowCount; $i++) {
                $category = $resultSet[$i]['id_category'];
                $modules = $resultSet[$i]['module_result'];
                $modules_split = explode(",", $modules);
                if (count($modules_split) > 0) {
                    $menu .= "<li class=\"c-sidebar__title\"><span>" . $this->getCategoryInfo($category, "category_name") . "</span></li>";
                    //$menu .= "<ul>";
                    for ($j = 0; $j < count($modules_split); $j++) {
                        $module_url = SERVER_PAGS;
                        $module_url .= $this->getModuleInfo($modules_split[$j], "module_url");
                        $menu .= "<li class='c-sidebar__item'><a class='c-sidebar__link' href='" . $module_url . "'><i class=\"fa " . $this->getModuleInfo($modules_split[$j], "module_icon") . "  u-mr-xsmall\"></i>" . translate($this->getModuleInfo($modules_split[$j], "module_title")) . ($this->getModuleInfo($modules_split[$j], "is_new") === "Y" ? "<span class=\"c-badge c-badge--success c-badge--xsmall u-ml-xsmall\">" . translate("@badge.new") . "</span>" : "") . "</a></li>";
                    }
                    //$menu .= "</ul>";
                    $menu .= "</li>";


                }
            }
            $menu .= "</ul>";
            return $menu;
        }


    }


    public function getModuleURLByKey($module_key, $simple_url = false)
    {

        global $database;
        global $settings;

        $database->query("SELECT module_url FROM modules WHERE module_key = ?");
        $database->bind(1, $module_key);
        $resultSet = $database->resultset();
        if (count($resultSet) > 0) {
            $module_url = $resultSet[0]['module_url'];
            if ($simple_url) {
                return $module_url;
            } else {
                return $settings->getValue('DASHBOARD_URL') . $module_url;
            }
        }
        return $settings->getValue('DASHBOARD_URL');

    }

}

