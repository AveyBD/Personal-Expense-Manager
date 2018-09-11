<?php
namespace CetraFramework\cetra_pem;

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(15, "mi_dashboard", $Language->MenuPhrase("15", "MenuText"), "dashboard.php", -1, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}dashboard.php'), FALSE, TRUE, "fa-dashboard", "", FALSE);
$sideMenu->addMenuItem(5, "mci_Money_Flow", $Language->MenuPhrase("5", "MenuText"), "", -1, "", TRUE, TRUE, TRUE, "fa-money", "", FALSE);
$sideMenu->addMenuItem(3, "mi_pem_expenses", $Language->MenuPhrase("3", "MenuText"), "pem_expenseslist.php", 5, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_expenses'), FALSE, FALSE, "fa-shopping-cart ", "", FALSE);
$sideMenu->addMenuItem(6, "mci_Options", $Language->MenuPhrase("6", "MenuText"), "", -1, "", TRUE, TRUE, TRUE, "fa-th-list", "", FALSE);
$sideMenu->addMenuItem(16, "mi_pem_accounts", $Language->MenuPhrase("16", "MenuText"), "pem_accountslist.php", 6, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_accounts'), FALSE, FALSE, "fa-vcard", "", FALSE);
$sideMenu->addMenuItem(1, "mi_pem_categories", $Language->MenuPhrase("1", "MenuText"), "pem_categorieslist.php", 6, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_categories'), FALSE, FALSE, "fa-list-alt ", "", FALSE);
$sideMenu->addMenuItem(2, "mi_pem_exp_source", $Language->MenuPhrase("2", "MenuText"), "pem_exp_sourcelist.php", 6, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_exp_source'), FALSE, FALSE, "fa-university", "", FALSE);
$sideMenu->addMenuItem(4, "mi_pem_payment_type", $Language->MenuPhrase("4", "MenuText"), "pem_payment_typelist.php", 6, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_payment_type'), FALSE, FALSE, "fa-cube", "", FALSE);
$sideMenu->addMenuItem(14, "mci_Admin", $Language->MenuPhrase("14", "MenuText"), "", -1, "", TRUE, TRUE, TRUE, "fa-cogs", "", FALSE);
$sideMenu->addMenuItem(7, "mi_users", $Language->MenuPhrase("7", "MenuText"), "userslist.php", 14, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}users'), FALSE, FALSE, "fa-users", "", FALSE);
$sideMenu->addMenuItem(8, "mi_userlevels", $Language->MenuPhrase("8", "MenuText"), "userlevelslist.php", 14, "", AllowListMenu('{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}userlevels'), FALSE, FALSE, "fa-flag", "", FALSE);
echo $sideMenu->toScript();
?>
