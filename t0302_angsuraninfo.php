<?php

// Global variable for table object
$t0302_angsuran = NULL;

//
// Table class for t0302_angsuran
//
class ct0302_angsuran extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $pinjaman_id;
	var $Angsuran_Ke;
	var $Angsuran_Tanggal;
	var $Angsuran_Pokok;
	var $Angsuran_Bunga;
	var $Angsuran_Total;
	var $Sisa_Hutang;
	var $Tanggal_Bayar;
	var $Terlambat;
	var $Total_Denda;
	var $Bayar_Titipan;
	var $Bayar_Non_Titipan;
	var $Bayar_Total;
	var $Keterangan;
	var $Periode;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't0302_angsuran';
		$this->TableName = 't0302_angsuran';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t0302_angsuran`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t0302_angsuran', 't0302_angsuran', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// pinjaman_id
		$this->pinjaman_id = new cField('t0302_angsuran', 't0302_angsuran', 'x_pinjaman_id', 'pinjaman_id', '`pinjaman_id`', '`pinjaman_id`', 3, -1, FALSE, '`pinjaman_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pinjaman_id->Sortable = TRUE; // Allow sort
		$this->pinjaman_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pinjaman_id'] = &$this->pinjaman_id;

		// Angsuran_Ke
		$this->Angsuran_Ke = new cField('t0302_angsuran', 't0302_angsuran', 'x_Angsuran_Ke', 'Angsuran_Ke', '`Angsuran_Ke`', '`Angsuran_Ke`', 16, -1, FALSE, '`Angsuran_Ke`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Ke->Sortable = TRUE; // Allow sort
		$this->Angsuran_Ke->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Angsuran_Ke'] = &$this->Angsuran_Ke;

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal = new cField('t0302_angsuran', 't0302_angsuran', 'x_Angsuran_Tanggal', 'Angsuran_Tanggal', '`Angsuran_Tanggal`', ew_CastDateFieldForLike('`Angsuran_Tanggal`', 0, "DB"), 133, 0, FALSE, '`Angsuran_Tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Tanggal->Sortable = TRUE; // Allow sort
		$this->Angsuran_Tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Angsuran_Tanggal'] = &$this->Angsuran_Tanggal;

		// Angsuran_Pokok
		$this->Angsuran_Pokok = new cField('t0302_angsuran', 't0302_angsuran', 'x_Angsuran_Pokok', 'Angsuran_Pokok', '`Angsuran_Pokok`', '`Angsuran_Pokok`', 4, -1, FALSE, '`Angsuran_Pokok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Pokok->Sortable = TRUE; // Allow sort
		$this->Angsuran_Pokok->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Pokok'] = &$this->Angsuran_Pokok;

		// Angsuran_Bunga
		$this->Angsuran_Bunga = new cField('t0302_angsuran', 't0302_angsuran', 'x_Angsuran_Bunga', 'Angsuran_Bunga', '`Angsuran_Bunga`', '`Angsuran_Bunga`', 4, -1, FALSE, '`Angsuran_Bunga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Bunga->Sortable = TRUE; // Allow sort
		$this->Angsuran_Bunga->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Bunga'] = &$this->Angsuran_Bunga;

		// Angsuran_Total
		$this->Angsuran_Total = new cField('t0302_angsuran', 't0302_angsuran', 'x_Angsuran_Total', 'Angsuran_Total', '`Angsuran_Total`', '`Angsuran_Total`', 4, -1, FALSE, '`Angsuran_Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Total->Sortable = TRUE; // Allow sort
		$this->Angsuran_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Total'] = &$this->Angsuran_Total;

		// Sisa_Hutang
		$this->Sisa_Hutang = new cField('t0302_angsuran', 't0302_angsuran', 'x_Sisa_Hutang', 'Sisa_Hutang', '`Sisa_Hutang`', '`Sisa_Hutang`', 4, -1, FALSE, '`Sisa_Hutang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sisa_Hutang->Sortable = TRUE; // Allow sort
		$this->Sisa_Hutang->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Sisa_Hutang'] = &$this->Sisa_Hutang;

		// Tanggal_Bayar
		$this->Tanggal_Bayar = new cField('t0302_angsuran', 't0302_angsuran', 'x_Tanggal_Bayar', 'Tanggal_Bayar', '`Tanggal_Bayar`', ew_CastDateFieldForLike('`Tanggal_Bayar`', 0, "DB"), 133, 0, FALSE, '`Tanggal_Bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tanggal_Bayar->Sortable = TRUE; // Allow sort
		$this->Tanggal_Bayar->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Tanggal_Bayar'] = &$this->Tanggal_Bayar;

		// Terlambat
		$this->Terlambat = new cField('t0302_angsuran', 't0302_angsuran', 'x_Terlambat', 'Terlambat', '`Terlambat`', '`Terlambat`', 2, -1, FALSE, '`Terlambat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Terlambat->Sortable = TRUE; // Allow sort
		$this->Terlambat->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Terlambat'] = &$this->Terlambat;

		// Total_Denda
		$this->Total_Denda = new cField('t0302_angsuran', 't0302_angsuran', 'x_Total_Denda', 'Total_Denda', '`Total_Denda`', '`Total_Denda`', 4, -1, FALSE, '`Total_Denda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Total_Denda->Sortable = TRUE; // Allow sort
		$this->Total_Denda->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Total_Denda'] = &$this->Total_Denda;

		// Bayar_Titipan
		$this->Bayar_Titipan = new cField('t0302_angsuran', 't0302_angsuran', 'x_Bayar_Titipan', 'Bayar_Titipan', '`Bayar_Titipan`', '`Bayar_Titipan`', 4, -1, FALSE, '`Bayar_Titipan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bayar_Titipan->Sortable = TRUE; // Allow sort
		$this->Bayar_Titipan->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Bayar_Titipan'] = &$this->Bayar_Titipan;

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan = new cField('t0302_angsuran', 't0302_angsuran', 'x_Bayar_Non_Titipan', 'Bayar_Non_Titipan', '`Bayar_Non_Titipan`', '`Bayar_Non_Titipan`', 4, -1, FALSE, '`Bayar_Non_Titipan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bayar_Non_Titipan->Sortable = TRUE; // Allow sort
		$this->Bayar_Non_Titipan->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Bayar_Non_Titipan'] = &$this->Bayar_Non_Titipan;

		// Bayar_Total
		$this->Bayar_Total = new cField('t0302_angsuran', 't0302_angsuran', 'x_Bayar_Total', 'Bayar_Total', '`Bayar_Total`', '`Bayar_Total`', 4, -1, FALSE, '`Bayar_Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bayar_Total->Sortable = TRUE; // Allow sort
		$this->Bayar_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Bayar_Total'] = &$this->Bayar_Total;

		// Keterangan
		$this->Keterangan = new cField('t0302_angsuran', 't0302_angsuran', 'x_Keterangan', 'Keterangan', '`Keterangan`', '`Keterangan`', 201, -1, FALSE, '`Keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Keterangan->Sortable = TRUE; // Allow sort
		$this->fields['Keterangan'] = &$this->Keterangan;

		// Periode
		$this->Periode = new cField('t0302_angsuran', 't0302_angsuran', 'x_Periode', 'Periode', '`Periode`', '`Periode`', 200, -1, FALSE, '`Periode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Periode->Sortable = TRUE; // Allow sort
		$this->fields['Periode'] = &$this->Periode;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t0302_angsuran`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t0302_angsuranlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t0302_angsuranlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t0302_angsuranview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t0302_angsuranview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t0302_angsuranadd.php?" . $this->UrlParm($parm);
		else
			$url = "t0302_angsuranadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t0302_angsuranedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t0302_angsuranadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t0302_angsurandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKeys[] = ew_StripSlashes($_GET["id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->pinjaman_id->setDbValue($rs->fields('pinjaman_id'));
		$this->Angsuran_Ke->setDbValue($rs->fields('Angsuran_Ke'));
		$this->Angsuran_Tanggal->setDbValue($rs->fields('Angsuran_Tanggal'));
		$this->Angsuran_Pokok->setDbValue($rs->fields('Angsuran_Pokok'));
		$this->Angsuran_Bunga->setDbValue($rs->fields('Angsuran_Bunga'));
		$this->Angsuran_Total->setDbValue($rs->fields('Angsuran_Total'));
		$this->Sisa_Hutang->setDbValue($rs->fields('Sisa_Hutang'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Terlambat->setDbValue($rs->fields('Terlambat'));
		$this->Total_Denda->setDbValue($rs->fields('Total_Denda'));
		$this->Bayar_Titipan->setDbValue($rs->fields('Bayar_Titipan'));
		$this->Bayar_Non_Titipan->setDbValue($rs->fields('Bayar_Non_Titipan'));
		$this->Bayar_Total->setDbValue($rs->fields('Bayar_Total'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Periode->setDbValue($rs->fields('Periode'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// pinjaman_id
		// Angsuran_Ke
		// Angsuran_Tanggal
		// Angsuran_Pokok
		// Angsuran_Bunga
		// Angsuran_Total
		// Sisa_Hutang
		// Tanggal_Bayar
		// Terlambat
		// Total_Denda
		// Bayar_Titipan
		// Bayar_Non_Titipan
		// Bayar_Total
		// Keterangan
		// Periode
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pinjaman_id
		$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
		$this->pinjaman_id->ViewCustomAttributes = "";

		// Angsuran_Ke
		$this->Angsuran_Ke->ViewValue = $this->Angsuran_Ke->CurrentValue;
		$this->Angsuran_Ke->ViewCustomAttributes = "";

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal->ViewValue = $this->Angsuran_Tanggal->CurrentValue;
		$this->Angsuran_Tanggal->ViewValue = ew_FormatDateTime($this->Angsuran_Tanggal->ViewValue, 0);
		$this->Angsuran_Tanggal->ViewCustomAttributes = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->ViewValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->ViewCustomAttributes = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->ViewValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->ViewCustomAttributes = "";

		// Angsuran_Total
		$this->Angsuran_Total->ViewValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->ViewCustomAttributes = "";

		// Sisa_Hutang
		$this->Sisa_Hutang->ViewValue = $this->Sisa_Hutang->CurrentValue;
		$this->Sisa_Hutang->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 0);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Terlambat
		$this->Terlambat->ViewValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->ViewCustomAttributes = "";

		// Total_Denda
		$this->Total_Denda->ViewValue = $this->Total_Denda->CurrentValue;
		$this->Total_Denda->ViewCustomAttributes = "";

		// Bayar_Titipan
		$this->Bayar_Titipan->ViewValue = $this->Bayar_Titipan->CurrentValue;
		$this->Bayar_Titipan->ViewCustomAttributes = "";

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->ViewValue = $this->Bayar_Non_Titipan->CurrentValue;
		$this->Bayar_Non_Titipan->ViewCustomAttributes = "";

		// Bayar_Total
		$this->Bayar_Total->ViewValue = $this->Bayar_Total->CurrentValue;
		$this->Bayar_Total->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// pinjaman_id
		$this->pinjaman_id->LinkCustomAttributes = "";
		$this->pinjaman_id->HrefValue = "";
		$this->pinjaman_id->TooltipValue = "";

		// Angsuran_Ke
		$this->Angsuran_Ke->LinkCustomAttributes = "";
		$this->Angsuran_Ke->HrefValue = "";
		$this->Angsuran_Ke->TooltipValue = "";

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal->LinkCustomAttributes = "";
		$this->Angsuran_Tanggal->HrefValue = "";
		$this->Angsuran_Tanggal->TooltipValue = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->LinkCustomAttributes = "";
		$this->Angsuran_Pokok->HrefValue = "";
		$this->Angsuran_Pokok->TooltipValue = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->LinkCustomAttributes = "";
		$this->Angsuran_Bunga->HrefValue = "";
		$this->Angsuran_Bunga->TooltipValue = "";

		// Angsuran_Total
		$this->Angsuran_Total->LinkCustomAttributes = "";
		$this->Angsuran_Total->HrefValue = "";
		$this->Angsuran_Total->TooltipValue = "";

		// Sisa_Hutang
		$this->Sisa_Hutang->LinkCustomAttributes = "";
		$this->Sisa_Hutang->HrefValue = "";
		$this->Sisa_Hutang->TooltipValue = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->LinkCustomAttributes = "";
		$this->Tanggal_Bayar->HrefValue = "";
		$this->Tanggal_Bayar->TooltipValue = "";

		// Terlambat
		$this->Terlambat->LinkCustomAttributes = "";
		$this->Terlambat->HrefValue = "";
		$this->Terlambat->TooltipValue = "";

		// Total_Denda
		$this->Total_Denda->LinkCustomAttributes = "";
		$this->Total_Denda->HrefValue = "";
		$this->Total_Denda->TooltipValue = "";

		// Bayar_Titipan
		$this->Bayar_Titipan->LinkCustomAttributes = "";
		$this->Bayar_Titipan->HrefValue = "";
		$this->Bayar_Titipan->TooltipValue = "";

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->LinkCustomAttributes = "";
		$this->Bayar_Non_Titipan->HrefValue = "";
		$this->Bayar_Non_Titipan->TooltipValue = "";

		// Bayar_Total
		$this->Bayar_Total->LinkCustomAttributes = "";
		$this->Bayar_Total->HrefValue = "";
		$this->Bayar_Total->TooltipValue = "";

		// Keterangan
		$this->Keterangan->LinkCustomAttributes = "";
		$this->Keterangan->HrefValue = "";
		$this->Keterangan->TooltipValue = "";

		// Periode
		$this->Periode->LinkCustomAttributes = "";
		$this->Periode->HrefValue = "";
		$this->Periode->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pinjaman_id
		$this->pinjaman_id->EditAttrs["class"] = "form-control";
		$this->pinjaman_id->EditCustomAttributes = "";
		$this->pinjaman_id->EditValue = $this->pinjaman_id->CurrentValue;
		$this->pinjaman_id->PlaceHolder = ew_RemoveHtml($this->pinjaman_id->FldCaption());

		// Angsuran_Ke
		$this->Angsuran_Ke->EditAttrs["class"] = "form-control";
		$this->Angsuran_Ke->EditCustomAttributes = "";
		$this->Angsuran_Ke->EditValue = $this->Angsuran_Ke->CurrentValue;
		$this->Angsuran_Ke->PlaceHolder = ew_RemoveHtml($this->Angsuran_Ke->FldCaption());

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal->EditAttrs["class"] = "form-control";
		$this->Angsuran_Tanggal->EditCustomAttributes = "";
		$this->Angsuran_Tanggal->EditValue = ew_FormatDateTime($this->Angsuran_Tanggal->CurrentValue, 8);
		$this->Angsuran_Tanggal->PlaceHolder = ew_RemoveHtml($this->Angsuran_Tanggal->FldCaption());

		// Angsuran_Pokok
		$this->Angsuran_Pokok->EditAttrs["class"] = "form-control";
		$this->Angsuran_Pokok->EditCustomAttributes = "";
		$this->Angsuran_Pokok->EditValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->PlaceHolder = ew_RemoveHtml($this->Angsuran_Pokok->FldCaption());
		if (strval($this->Angsuran_Pokok->EditValue) <> "" && is_numeric($this->Angsuran_Pokok->EditValue)) $this->Angsuran_Pokok->EditValue = ew_FormatNumber($this->Angsuran_Pokok->EditValue, -2, -1, -2, 0);

		// Angsuran_Bunga
		$this->Angsuran_Bunga->EditAttrs["class"] = "form-control";
		$this->Angsuran_Bunga->EditCustomAttributes = "";
		$this->Angsuran_Bunga->EditValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->PlaceHolder = ew_RemoveHtml($this->Angsuran_Bunga->FldCaption());
		if (strval($this->Angsuran_Bunga->EditValue) <> "" && is_numeric($this->Angsuran_Bunga->EditValue)) $this->Angsuran_Bunga->EditValue = ew_FormatNumber($this->Angsuran_Bunga->EditValue, -2, -1, -2, 0);

		// Angsuran_Total
		$this->Angsuran_Total->EditAttrs["class"] = "form-control";
		$this->Angsuran_Total->EditCustomAttributes = "";
		$this->Angsuran_Total->EditValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->PlaceHolder = ew_RemoveHtml($this->Angsuran_Total->FldCaption());
		if (strval($this->Angsuran_Total->EditValue) <> "" && is_numeric($this->Angsuran_Total->EditValue)) $this->Angsuran_Total->EditValue = ew_FormatNumber($this->Angsuran_Total->EditValue, -2, -1, -2, 0);

		// Sisa_Hutang
		$this->Sisa_Hutang->EditAttrs["class"] = "form-control";
		$this->Sisa_Hutang->EditCustomAttributes = "";
		$this->Sisa_Hutang->EditValue = $this->Sisa_Hutang->CurrentValue;
		$this->Sisa_Hutang->PlaceHolder = ew_RemoveHtml($this->Sisa_Hutang->FldCaption());
		if (strval($this->Sisa_Hutang->EditValue) <> "" && is_numeric($this->Sisa_Hutang->EditValue)) $this->Sisa_Hutang->EditValue = ew_FormatNumber($this->Sisa_Hutang->EditValue, -2, -1, -2, 0);

		// Tanggal_Bayar
		$this->Tanggal_Bayar->EditAttrs["class"] = "form-control";
		$this->Tanggal_Bayar->EditCustomAttributes = "";
		$this->Tanggal_Bayar->EditValue = ew_FormatDateTime($this->Tanggal_Bayar->CurrentValue, 8);
		$this->Tanggal_Bayar->PlaceHolder = ew_RemoveHtml($this->Tanggal_Bayar->FldCaption());

		// Terlambat
		$this->Terlambat->EditAttrs["class"] = "form-control";
		$this->Terlambat->EditCustomAttributes = "";
		$this->Terlambat->EditValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

		// Total_Denda
		$this->Total_Denda->EditAttrs["class"] = "form-control";
		$this->Total_Denda->EditCustomAttributes = "";
		$this->Total_Denda->EditValue = $this->Total_Denda->CurrentValue;
		$this->Total_Denda->PlaceHolder = ew_RemoveHtml($this->Total_Denda->FldCaption());
		if (strval($this->Total_Denda->EditValue) <> "" && is_numeric($this->Total_Denda->EditValue)) $this->Total_Denda->EditValue = ew_FormatNumber($this->Total_Denda->EditValue, -2, -1, -2, 0);

		// Bayar_Titipan
		$this->Bayar_Titipan->EditAttrs["class"] = "form-control";
		$this->Bayar_Titipan->EditCustomAttributes = "";
		$this->Bayar_Titipan->EditValue = $this->Bayar_Titipan->CurrentValue;
		$this->Bayar_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Titipan->FldCaption());
		if (strval($this->Bayar_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Titipan->EditValue)) $this->Bayar_Titipan->EditValue = ew_FormatNumber($this->Bayar_Titipan->EditValue, -2, -1, -2, 0);

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->EditAttrs["class"] = "form-control";
		$this->Bayar_Non_Titipan->EditCustomAttributes = "";
		$this->Bayar_Non_Titipan->EditValue = $this->Bayar_Non_Titipan->CurrentValue;
		$this->Bayar_Non_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Non_Titipan->FldCaption());
		if (strval($this->Bayar_Non_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Non_Titipan->EditValue)) $this->Bayar_Non_Titipan->EditValue = ew_FormatNumber($this->Bayar_Non_Titipan->EditValue, -2, -1, -2, 0);

		// Bayar_Total
		$this->Bayar_Total->EditAttrs["class"] = "form-control";
		$this->Bayar_Total->EditCustomAttributes = "";
		$this->Bayar_Total->EditValue = $this->Bayar_Total->CurrentValue;
		$this->Bayar_Total->PlaceHolder = ew_RemoveHtml($this->Bayar_Total->FldCaption());
		if (strval($this->Bayar_Total->EditValue) <> "" && is_numeric($this->Bayar_Total->EditValue)) $this->Bayar_Total->EditValue = ew_FormatNumber($this->Bayar_Total->EditValue, -2, -1, -2, 0);

		// Keterangan
		$this->Keterangan->EditAttrs["class"] = "form-control";
		$this->Keterangan->EditCustomAttributes = "";
		$this->Keterangan->EditValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

		// Periode
		$this->Periode->EditAttrs["class"] = "form-control";
		$this->Periode->EditCustomAttributes = "";
		$this->Periode->EditValue = $this->Periode->CurrentValue;
		$this->Periode->PlaceHolder = ew_RemoveHtml($this->Periode->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->pinjaman_id->Exportable) $Doc->ExportCaption($this->pinjaman_id);
					if ($this->Angsuran_Ke->Exportable) $Doc->ExportCaption($this->Angsuran_Ke);
					if ($this->Angsuran_Tanggal->Exportable) $Doc->ExportCaption($this->Angsuran_Tanggal);
					if ($this->Angsuran_Pokok->Exportable) $Doc->ExportCaption($this->Angsuran_Pokok);
					if ($this->Angsuran_Bunga->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga);
					if ($this->Angsuran_Total->Exportable) $Doc->ExportCaption($this->Angsuran_Total);
					if ($this->Sisa_Hutang->Exportable) $Doc->ExportCaption($this->Sisa_Hutang);
					if ($this->Tanggal_Bayar->Exportable) $Doc->ExportCaption($this->Tanggal_Bayar);
					if ($this->Terlambat->Exportable) $Doc->ExportCaption($this->Terlambat);
					if ($this->Total_Denda->Exportable) $Doc->ExportCaption($this->Total_Denda);
					if ($this->Bayar_Titipan->Exportable) $Doc->ExportCaption($this->Bayar_Titipan);
					if ($this->Bayar_Non_Titipan->Exportable) $Doc->ExportCaption($this->Bayar_Non_Titipan);
					if ($this->Bayar_Total->Exportable) $Doc->ExportCaption($this->Bayar_Total);
					if ($this->Keterangan->Exportable) $Doc->ExportCaption($this->Keterangan);
					if ($this->Periode->Exportable) $Doc->ExportCaption($this->Periode);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->pinjaman_id->Exportable) $Doc->ExportCaption($this->pinjaman_id);
					if ($this->Angsuran_Ke->Exportable) $Doc->ExportCaption($this->Angsuran_Ke);
					if ($this->Angsuran_Tanggal->Exportable) $Doc->ExportCaption($this->Angsuran_Tanggal);
					if ($this->Angsuran_Pokok->Exportable) $Doc->ExportCaption($this->Angsuran_Pokok);
					if ($this->Angsuran_Bunga->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga);
					if ($this->Angsuran_Total->Exportable) $Doc->ExportCaption($this->Angsuran_Total);
					if ($this->Sisa_Hutang->Exportable) $Doc->ExportCaption($this->Sisa_Hutang);
					if ($this->Tanggal_Bayar->Exportable) $Doc->ExportCaption($this->Tanggal_Bayar);
					if ($this->Terlambat->Exportable) $Doc->ExportCaption($this->Terlambat);
					if ($this->Total_Denda->Exportable) $Doc->ExportCaption($this->Total_Denda);
					if ($this->Bayar_Titipan->Exportable) $Doc->ExportCaption($this->Bayar_Titipan);
					if ($this->Bayar_Non_Titipan->Exportable) $Doc->ExportCaption($this->Bayar_Non_Titipan);
					if ($this->Bayar_Total->Exportable) $Doc->ExportCaption($this->Bayar_Total);
					if ($this->Periode->Exportable) $Doc->ExportCaption($this->Periode);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->pinjaman_id->Exportable) $Doc->ExportField($this->pinjaman_id);
						if ($this->Angsuran_Ke->Exportable) $Doc->ExportField($this->Angsuran_Ke);
						if ($this->Angsuran_Tanggal->Exportable) $Doc->ExportField($this->Angsuran_Tanggal);
						if ($this->Angsuran_Pokok->Exportable) $Doc->ExportField($this->Angsuran_Pokok);
						if ($this->Angsuran_Bunga->Exportable) $Doc->ExportField($this->Angsuran_Bunga);
						if ($this->Angsuran_Total->Exportable) $Doc->ExportField($this->Angsuran_Total);
						if ($this->Sisa_Hutang->Exportable) $Doc->ExportField($this->Sisa_Hutang);
						if ($this->Tanggal_Bayar->Exportable) $Doc->ExportField($this->Tanggal_Bayar);
						if ($this->Terlambat->Exportable) $Doc->ExportField($this->Terlambat);
						if ($this->Total_Denda->Exportable) $Doc->ExportField($this->Total_Denda);
						if ($this->Bayar_Titipan->Exportable) $Doc->ExportField($this->Bayar_Titipan);
						if ($this->Bayar_Non_Titipan->Exportable) $Doc->ExportField($this->Bayar_Non_Titipan);
						if ($this->Bayar_Total->Exportable) $Doc->ExportField($this->Bayar_Total);
						if ($this->Keterangan->Exportable) $Doc->ExportField($this->Keterangan);
						if ($this->Periode->Exportable) $Doc->ExportField($this->Periode);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->pinjaman_id->Exportable) $Doc->ExportField($this->pinjaman_id);
						if ($this->Angsuran_Ke->Exportable) $Doc->ExportField($this->Angsuran_Ke);
						if ($this->Angsuran_Tanggal->Exportable) $Doc->ExportField($this->Angsuran_Tanggal);
						if ($this->Angsuran_Pokok->Exportable) $Doc->ExportField($this->Angsuran_Pokok);
						if ($this->Angsuran_Bunga->Exportable) $Doc->ExportField($this->Angsuran_Bunga);
						if ($this->Angsuran_Total->Exportable) $Doc->ExportField($this->Angsuran_Total);
						if ($this->Sisa_Hutang->Exportable) $Doc->ExportField($this->Sisa_Hutang);
						if ($this->Tanggal_Bayar->Exportable) $Doc->ExportField($this->Tanggal_Bayar);
						if ($this->Terlambat->Exportable) $Doc->ExportField($this->Terlambat);
						if ($this->Total_Denda->Exportable) $Doc->ExportField($this->Total_Denda);
						if ($this->Bayar_Titipan->Exportable) $Doc->ExportField($this->Bayar_Titipan);
						if ($this->Bayar_Non_Titipan->Exportable) $Doc->ExportField($this->Bayar_Non_Titipan);
						if ($this->Bayar_Total->Exportable) $Doc->ExportField($this->Bayar_Total);
						if ($this->Periode->Exportable) $Doc->ExportField($this->Periode);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't0302_angsuran';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't0302_angsuran';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't0302_angsuran';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't0302_angsuran';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
