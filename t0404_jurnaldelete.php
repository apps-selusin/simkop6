<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0404_jurnalinfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0404_jurnal_delete = NULL; // Initialize page object first

class ct0404_jurnal_delete extends ct0404_jurnal {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0404_jurnal';

	// Page object name
	var $PageObjName = 't0404_jurnal_delete';

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

		// Table object (t0404_jurnal)
		if (!isset($GLOBALS["t0404_jurnal"]) || get_class($GLOBALS["t0404_jurnal"]) == "ct0404_jurnal") {
			$GLOBALS["t0404_jurnal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0404_jurnal"];
		}

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0404_jurnal', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t0404_jurnallist.php"));
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
		$this->Tanggal->SetVisibility();
		$this->Periode->SetVisibility();
		$this->NomorTransaksi->SetVisibility();
		$this->Rekening->SetVisibility();
		$this->Debet->SetVisibility();
		$this->Kredit->SetVisibility();
		$this->Keterangan->SetVisibility();

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
		global $EW_EXPORT, $t0404_jurnal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0404_jurnal);
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
			$this->Page_Terminate("t0404_jurnallist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t0404_jurnal class, t0404_jurnalinfo.php

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
				$this->Page_Terminate("t0404_jurnallist.php"); // Return to list
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
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->Periode->setDbValue($rs->fields('Periode'));
		$this->NomorTransaksi->setDbValue($rs->fields('NomorTransaksi'));
		$this->Rekening->setDbValue($rs->fields('Rekening'));
		$this->Debet->setDbValue($rs->fields('Debet'));
		$this->Kredit->setDbValue($rs->fields('Kredit'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->Periode->DbValue = $row['Periode'];
		$this->NomorTransaksi->DbValue = $row['NomorTransaksi'];
		$this->Rekening->DbValue = $row['Rekening'];
		$this->Debet->DbValue = $row['Debet'];
		$this->Kredit->DbValue = $row['Kredit'];
		$this->Keterangan->DbValue = $row['Keterangan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Debet->FormValue == $this->Debet->CurrentValue && is_numeric(ew_StrToFloat($this->Debet->CurrentValue)))
			$this->Debet->CurrentValue = ew_StrToFloat($this->Debet->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Kredit->FormValue == $this->Kredit->CurrentValue && is_numeric(ew_StrToFloat($this->Kredit->CurrentValue)))
			$this->Kredit->CurrentValue = ew_StrToFloat($this->Kredit->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Tanggal
		// Periode
		// NomorTransaksi
		// Rekening
		// Debet
		// Kredit
		// Keterangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

		// NomorTransaksi
		$this->NomorTransaksi->ViewValue = $this->NomorTransaksi->CurrentValue;
		$this->NomorTransaksi->ViewCustomAttributes = "";

		// Rekening
		$this->Rekening->ViewValue = $this->Rekening->CurrentValue;
		$this->Rekening->ViewCustomAttributes = "";

		// Debet
		$this->Debet->ViewValue = $this->Debet->CurrentValue;
		$this->Debet->ViewCustomAttributes = "";

		// Kredit
		$this->Kredit->ViewValue = $this->Kredit->CurrentValue;
		$this->Kredit->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// Periode
			$this->Periode->LinkCustomAttributes = "";
			$this->Periode->HrefValue = "";
			$this->Periode->TooltipValue = "";

			// NomorTransaksi
			$this->NomorTransaksi->LinkCustomAttributes = "";
			$this->NomorTransaksi->HrefValue = "";
			$this->NomorTransaksi->TooltipValue = "";

			// Rekening
			$this->Rekening->LinkCustomAttributes = "";
			$this->Rekening->HrefValue = "";
			$this->Rekening->TooltipValue = "";

			// Debet
			$this->Debet->LinkCustomAttributes = "";
			$this->Debet->HrefValue = "";
			$this->Debet->TooltipValue = "";

			// Kredit
			$this->Kredit->LinkCustomAttributes = "";
			$this->Kredit->HrefValue = "";
			$this->Kredit->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0404_jurnallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t0404_jurnal_delete)) $t0404_jurnal_delete = new ct0404_jurnal_delete();

// Page init
$t0404_jurnal_delete->Page_Init();

// Page main
$t0404_jurnal_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0404_jurnal_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft0404_jurnaldelete = new ew_Form("ft0404_jurnaldelete", "delete");

// Form_CustomValidate event
ft0404_jurnaldelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0404_jurnaldelete.ValidateRequired = true;
<?php } else { ?>
ft0404_jurnaldelete.ValidateRequired = false; 
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
<?php $t0404_jurnal_delete->ShowPageHeader(); ?>
<?php
$t0404_jurnal_delete->ShowMessage();
?>
<form name="ft0404_jurnaldelete" id="ft0404_jurnaldelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0404_jurnal_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0404_jurnal_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0404_jurnal">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t0404_jurnal_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t0404_jurnal->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t0404_jurnal->id->Visible) { // id ?>
		<th><span id="elh_t0404_jurnal_id" class="t0404_jurnal_id"><?php echo $t0404_jurnal->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Tanggal->Visible) { // Tanggal ?>
		<th><span id="elh_t0404_jurnal_Tanggal" class="t0404_jurnal_Tanggal"><?php echo $t0404_jurnal->Tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Periode->Visible) { // Periode ?>
		<th><span id="elh_t0404_jurnal_Periode" class="t0404_jurnal_Periode"><?php echo $t0404_jurnal->Periode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
		<th><span id="elh_t0404_jurnal_NomorTransaksi" class="t0404_jurnal_NomorTransaksi"><?php echo $t0404_jurnal->NomorTransaksi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Rekening->Visible) { // Rekening ?>
		<th><span id="elh_t0404_jurnal_Rekening" class="t0404_jurnal_Rekening"><?php echo $t0404_jurnal->Rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Debet->Visible) { // Debet ?>
		<th><span id="elh_t0404_jurnal_Debet" class="t0404_jurnal_Debet"><?php echo $t0404_jurnal->Debet->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Kredit->Visible) { // Kredit ?>
		<th><span id="elh_t0404_jurnal_Kredit" class="t0404_jurnal_Kredit"><?php echo $t0404_jurnal->Kredit->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t0404_jurnal->Keterangan->Visible) { // Keterangan ?>
		<th><span id="elh_t0404_jurnal_Keterangan" class="t0404_jurnal_Keterangan"><?php echo $t0404_jurnal->Keterangan->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t0404_jurnal_delete->RecCnt = 0;
$i = 0;
while (!$t0404_jurnal_delete->Recordset->EOF) {
	$t0404_jurnal_delete->RecCnt++;
	$t0404_jurnal_delete->RowCnt++;

	// Set row properties
	$t0404_jurnal->ResetAttrs();
	$t0404_jurnal->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t0404_jurnal_delete->LoadRowValues($t0404_jurnal_delete->Recordset);

	// Render row
	$t0404_jurnal_delete->RenderRow();
?>
	<tr<?php echo $t0404_jurnal->RowAttributes() ?>>
<?php if ($t0404_jurnal->id->Visible) { // id ?>
		<td<?php echo $t0404_jurnal->id->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_id" class="t0404_jurnal_id">
<span<?php echo $t0404_jurnal->id->ViewAttributes() ?>>
<?php echo $t0404_jurnal->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Tanggal->Visible) { // Tanggal ?>
		<td<?php echo $t0404_jurnal->Tanggal->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Tanggal" class="t0404_jurnal_Tanggal">
<span<?php echo $t0404_jurnal->Tanggal->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Periode->Visible) { // Periode ?>
		<td<?php echo $t0404_jurnal->Periode->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Periode" class="t0404_jurnal_Periode">
<span<?php echo $t0404_jurnal->Periode->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Periode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
		<td<?php echo $t0404_jurnal->NomorTransaksi->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_NomorTransaksi" class="t0404_jurnal_NomorTransaksi">
<span<?php echo $t0404_jurnal->NomorTransaksi->ViewAttributes() ?>>
<?php echo $t0404_jurnal->NomorTransaksi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Rekening->Visible) { // Rekening ?>
		<td<?php echo $t0404_jurnal->Rekening->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Rekening" class="t0404_jurnal_Rekening">
<span<?php echo $t0404_jurnal->Rekening->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Debet->Visible) { // Debet ?>
		<td<?php echo $t0404_jurnal->Debet->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Debet" class="t0404_jurnal_Debet">
<span<?php echo $t0404_jurnal->Debet->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Debet->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Kredit->Visible) { // Kredit ?>
		<td<?php echo $t0404_jurnal->Kredit->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Kredit" class="t0404_jurnal_Kredit">
<span<?php echo $t0404_jurnal->Kredit->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Kredit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t0404_jurnal->Keterangan->Visible) { // Keterangan ?>
		<td<?php echo $t0404_jurnal->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t0404_jurnal_delete->RowCnt ?>_t0404_jurnal_Keterangan" class="t0404_jurnal_Keterangan">
<span<?php echo $t0404_jurnal->Keterangan->ViewAttributes() ?>>
<?php echo $t0404_jurnal->Keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t0404_jurnal_delete->Recordset->MoveNext();
}
$t0404_jurnal_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0404_jurnal_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft0404_jurnaldelete.Init();
</script>
<?php
$t0404_jurnal_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0404_jurnal_delete->Page_Terminate();
?>
