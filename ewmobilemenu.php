<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(20, "mmci_Menu_Utama", $Language->MenuPhrase("20", "MenuText"), "", -1, "", TRUE, TRUE, TRUE);
$RootMenu->AddMenuItem(19, "mmi_cf01_home_php", $Language->MenuPhrase("19", "MenuText"), "cf01_home.php", 20, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}cf01_home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(21, "mmci_Koperasi", $Language->MenuPhrase("21", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(1, "mmi_t0101_koperasi", $Language->MenuPhrase("1", "MenuText"), "t0101_koperasilist.php", 21, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0101_koperasi'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t0102_marketing", $Language->MenuPhrase("2", "MenuText"), "t0102_marketinglist.php", 21, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0102_marketing'), FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mmci_Nasabah", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(3, "mmi_t0201_nasabah", $Language->MenuPhrase("3", "MenuText"), "t0201_nasabahlist.php", 22, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0201_nasabah'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_t0202_jaminan", $Language->MenuPhrase("4", "MenuText"), "t0202_jaminanlist.php", 22, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0202_jaminan'), FALSE, FALSE);
$RootMenu->AddMenuItem(23, "mmci_Pinjaman", $Language->MenuPhrase("23", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(5, "mmi_t0301_pinjaman", $Language->MenuPhrase("5", "MenuText"), "t0301_pinjamanlist.php", 23, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0301_pinjaman'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_t0302_angsuran", $Language->MenuPhrase("6", "MenuText"), "t0302_angsuranlist.php", 23, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0302_angsuran'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmi_t0303_titipan", $Language->MenuPhrase("7", "MenuText"), "t0303_titipanlist.php", 23, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0303_titipan'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_t0304_potongan", $Language->MenuPhrase("8", "MenuText"), "t0304_potonganlist.php", 23, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0304_potongan'), FALSE, FALSE);
$RootMenu->AddMenuItem(24, "mmci_Akuntansi", $Language->MenuPhrase("24", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(9, "mmi_t0401_periode", $Language->MenuPhrase("9", "MenuText"), "t0401_periodelist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0401_periode'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_t0402_rekening", $Language->MenuPhrase("10", "MenuText"), "t0402_rekeninglist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0402_rekening'), FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mmi_t0403_rektran", $Language->MenuPhrase("11", "MenuText"), "t0403_rektranlist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0403_rektran'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mmi_t0404_jurnal", $Language->MenuPhrase("12", "MenuText"), "t0404_jurnallist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0404_jurnal'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mmi_t0405_neraca", $Language->MenuPhrase("13", "MenuText"), "t0405_neracalist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0405_neraca'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_t0406_labarugi", $Language->MenuPhrase("14", "MenuText"), "t0406_labarugilist.php", 24, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t0406_labarugi'), FALSE, FALSE);
$RootMenu->AddMenuItem(25, "mmci_Setup", $Language->MenuPhrase("25", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(15, "mmi_t9901_employees", $Language->MenuPhrase("15", "MenuText"), "t9901_employeeslist.php", 25, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9901_employees'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mmi_t9902_userlevels", $Language->MenuPhrase("16", "MenuText"), "t9902_userlevelslist.php", 25, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(17, "mmi_t9903_userlevelpermissions", $Language->MenuPhrase("17", "MenuText"), "t9903_userlevelpermissionslist.php", 25, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(18, "mmi_t9904_audittrail", $Language->MenuPhrase("18", "MenuText"), "t9904_audittraillist.php", 25, "", AllowListMenu('{723112A7-6795-416E-B2AF-D90AA7A8CCFB}t9904_audittrail'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
