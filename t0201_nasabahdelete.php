<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0201_nasabahinfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0201_nasabah_delete = NULL; // Initialize page object first

class ct0201_nasabah_delete extends ct0201_nasabah {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0201_nasabah';

	// Page object name
	var $PageObjName = 't0201_nasabah_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t0201_nasabah)
		if (!isset($GLOBALS["t0201_nasabah"]) || get_class($GLOBALS["t0201_nasabah"]) == "ct0201_nasabah") {
			$GLOBALS["t0201_nasabah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0201_nasabah"];
		}

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0201_nasabah', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t9901_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct9901_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t0201_nasabahlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Nama->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->Pekerjaan->SetVisibility();
		$this->PekerjaanNoTelpHp->SetVisibility();
		$this->Status->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->koperasi_id->SetVisibility();
		$this->marketing_id->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t0201_nasabah;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0201_nasabah);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t0201_nasabahlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t0201_nasabah class, t0201_nasabahinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t0201_nasabahlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->NoTelpHp->setDbValue($rs->fields('NoTelpHp'));
		$this->Pekerjaan->setDbValue($rs->fields('Pekerjaan'));
		$this->PekerjaanAlamat->setDbValue($rs->fields('PekerjaanAlamat'));
		$this->PekerjaanNoTelpHp->setDbValue($rs->fields('PekerjaanNoTelpHp'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->koperasi_id->setDbValue($rs->fields('koperasi_id'));
		$this->marketing_id->setDbValue($rs->fields('marketing_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->NoTelpHp->DbValue = $row['NoTelpHp'];
		$this->Pekerjaan->DbValue = $row['Pekerjaan'];
		$this->PekerjaanAlamat->DbValue = $row['PekerjaanAlamat'];
		$this->PekerjaanNoTelpHp->DbValue = $row['PekerjaanNoTelpHp'];
		$this->Status->DbValue = $row['Status'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->koperasi_id->DbValue = $row['koperasi_id'];
		$this->marketing_id->DbValue = $row['marketing_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Nama
		// Alamat
		// NoTelpHp
		// Pekerjaan
		// PekerjaanAlamat
		// PekerjaanNoTelpHp
		// Status
		// Keterangan
		// koperasi_id
		// marketing_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// NoTelpHp
		$this->NoTelpHp->ViewValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->ViewCustomAttributes = "";

		// Pekerjaan
		$this->Pekerjaan->ViewValue = $this->Pekerjaan->CurrentValue;
		$this->Pekerjaan->ViewCustomAttributes = "";

		// PekerjaanNoTelpHp
		$this->PekerjaanNoTelpHp->ViewValue = $this->PekerjaanNoTelpHp->CurrentValue;
		$this->PekerjaanNoTelpHp->ViewCustomAttributes = "";

		// Status
		$this->Status->ViewValue = $this->Status->CurrentValue;
		$this->Status->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// koperasi_id
		$this->koperasi_id->ViewValue = $this->koperasi_id->CurrentValue;
		$this->koperasi_id->ViewCustomAttributes = "";

		// marketing_id
		$this->marketing_id->ViewValue = $this->marketing_id->CurrentValue;
		$this->marketing_id->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";
			$this->NoTelpHp->TooltipValue = "";

			// Pekerjaan
			$this->Pekerjaan->LinkCustomAttributes = "";
			$this->Pekerjaan->HrefValue = "";
			$this->Pekerjaan->TooltipValue = "";

			// PekerjaanNoTelpHp
			$this->PekerjaanNoTelpHp->LinkCustomAttributes = "";
			$this->PekerjaanNoTelpHp->HrefValue = "";
			$this->PekerjaanNoTelpHp->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// koperasi_id
			$this->koperasi_id->LinkCustomAttributes = "";
			$this->koperasi_id->HrefValue = "";
			$this->koperasi_id->TooltipValue = "";

			// marketing_id
			$this->marketing_id->LinkCustomAttributes = "";
			$this->marketing_id->HrefValue = "";
			$this->marketing_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0201_nasabahlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t0201_nasabah_delete)) $t0201_nasabah_delete = new ct0201_nasabah_delete();

// Page init
$t0201_nasabah_delete->Page_Init();

// Page main
$t0201_nasabah_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0201_nasabah_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft0201_nasabahdelete = new ew_Form("ft0201_nasabahdelete", "delete");

// Form_CustomValidate event
ft0201_nasabahdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0201_nasabahdelete.ValidateRequired = true;
<?php } else { ?>
ft0201_nasabahdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t0201_nasabah_delete->ShowPageHeader(); ?>
<?php
$t0201_nasabah_delete->ShowMessage();
?>
<form name="ft0201_nasabahdelete" id="ft0201_nasabahdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0201_nasabah_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0201_nasabah_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0201_nasabah">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t0201_nasabah_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t0201_nasabah->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t0201_nasabah->id->Visible) { // id ?>
		<th><span id="elh_t0201_nasabah_id" class="t0201_nasabah_id"><?php echo $t0201_nasabah->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->Nama->Visible) { // Nama ?>
		<th><span id="elh_t0201_nasabah_Nama" class="t0201_nasabah_Nama"><?php echo $t0201_nasabah->Nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<th><span id="elh_t0201_nasabah_NoTelpHp" class="t0201_nasabah_NoTelpHp"><?php echo $t0201_nasabah->NoTelpHp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<th><span id="elh_t0201_nasabah_Pekerjaan" class="t0201_nasabah_Pekerjaan"><?php echo $t0201_nasabah->Pekerjaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->PekerjaanNoTelpHp->Visible) { // PekerjaanNoTelpHp ?>
		<th><span id="elh_t0201_nasabah_PekerjaanNoTelpHp" class="t0201_nasabah_PekerjaanNoTelpHp"><?php echo $t0201_nasabah->PekerjaanNoTelpHp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->Status->Visible) { // Status ?>
		<th><span id="elh_t0201_nasabah_Status" class="t0201_nasabah_Status"><?php echo $t0201_nasabah->Status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->Keterangan->Visible) { // Keterangan ?>
		<th><span id="elh_t0201_nasabah_Keterangan" class="t0201_nasabah_Keterangan"><?php echo $t0201_nasabah->Keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->koperasi_id->Visible) { // koperasi_id ?>
		<th><span id="elh_t0201_nasabah_koperasi_id" class="t0201_nasabah_koperasi_id"><?php echo $t0201_nasabah->koperasi_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0201_nasabah->marketing_id->Visible) { // marketing_id ?>
		<th><span id="elh_t0201_nasabah_marketing_id" class="t0201_nasabah_marketing_id"><?php echo $t0201_nasabah->marketing_id->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t0201_nasabah_delete->RecCnt = 0;
$i = 0;
while (!$t0201_nasabah_delete->Recordset->EOF) {
	$t0201_nasabah_delete->RecCnt++;
	$t0201_nasabah_delete->RowCnt++;

	// Set row properties
	$t0201_nasabah->ResetAttrs();
	$t0201_nasabah->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t0201_nasabah_delete->LoadRowValues($t0201_nasabah_delete->Recordset);

	// Render row
	$t0201_nasabah_delete->RenderRow();
?>
	<tr<?php echo $t0201_nasabah->RowAttributes() ?>>
<?php if ($t0201_nasabah->id->Visible) { // id ?>
		<td<?php echo $t0201_nasabah->id->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_id" class="t0201_nasabah_id">
<span<?php echo $t0201_nasabah->id->ViewAttributes() ?>>
<?php echo $t0201_nasabah->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->Nama->Visible) { // Nama ?>
		<td<?php echo $t0201_nasabah->Nama->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_Nama" class="t0201_nasabah_Nama">
<span<?php echo $t0201_nasabah->Nama->ViewAttributes() ?>>
<?php echo $t0201_nasabah->Nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<td<?php echo $t0201_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_NoTelpHp" class="t0201_nasabah_NoTelpHp">
<span<?php echo $t0201_nasabah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t0201_nasabah->NoTelpHp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<td<?php echo $t0201_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_Pekerjaan" class="t0201_nasabah_Pekerjaan">
<span<?php echo $t0201_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t0201_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->PekerjaanNoTelpHp->Visible) { // PekerjaanNoTelpHp ?>
		<td<?php echo $t0201_nasabah->PekerjaanNoTelpHp->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_PekerjaanNoTelpHp" class="t0201_nasabah_PekerjaanNoTelpHp">
<span<?php echo $t0201_nasabah->PekerjaanNoTelpHp->ViewAttributes() ?>>
<?php echo $t0201_nasabah->PekerjaanNoTelpHp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->Status->Visible) { // Status ?>
		<td<?php echo $t0201_nasabah->Status->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_Status" class="t0201_nasabah_Status">
<span<?php echo $t0201_nasabah->Status->ViewAttributes() ?>>
<?php echo $t0201_nasabah->Status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->Keterangan->Visible) { // Keterangan ?>
		<td<?php echo $t0201_nasabah->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_Keterangan" class="t0201_nasabah_Keterangan">
<span<?php echo $t0201_nasabah->Keterangan->ViewAttributes() ?>>
<?php echo $t0201_nasabah->Keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->koperasi_id->Visible) { // koperasi_id ?>
		<td<?php echo $t0201_nasabah->koperasi_id->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_koperasi_id" class="t0201_nasabah_koperasi_id">
<span<?php echo $t0201_nasabah->koperasi_id->ViewAttributes() ?>>
<?php echo $t0201_nasabah->koperasi_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0201_nasabah->marketing_id->Visible) { // marketing_id ?>
		<td<?php echo $t0201_nasabah->marketing_id->CellAttributes() ?>>
<span id="el<?php echo $t0201_nasabah_delete->RowCnt ?>_t0201_nasabah_marketing_id" class="t0201_nasabah_marketing_id">
<span<?php echo $t0201_nasabah->marketing_id->ViewAttributes() ?>>
<?php echo $t0201_nasabah->marketing_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t0201_nasabah_delete->Recordset->MoveNext();
}
$t0201_nasabah_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0201_nasabah_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft0201_nasabahdelete.Init();
</script>
<?php
$t0201_nasabah_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0201_nasabah_delete->Page_Terminate();
?>
