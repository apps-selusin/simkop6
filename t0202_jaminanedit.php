<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0202_jaminaninfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0202_jaminan_edit = NULL; // Initialize page object first

class ct0202_jaminan_edit extends ct0202_jaminan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0202_jaminan';

	// Page object name
	var $PageObjName = 't0202_jaminan_edit';

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

		// Table object (t0202_jaminan)
		if (!isset($GLOBALS["t0202_jaminan"]) || get_class($GLOBALS["t0202_jaminan"]) == "ct0202_jaminan") {
			$GLOBALS["t0202_jaminan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0202_jaminan"];
		}

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0202_jaminan', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t0202_jaminanlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nasabah_id->SetVisibility();
		$this->MerkType->SetVisibility();
		$this->NoRangka->SetVisibility();
		$this->NoMesin->SetVisibility();
		$this->Warna->SetVisibility();
		$this->NoPol->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->AtasNama->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $t0202_jaminan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0202_jaminan);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("t0202_jaminanlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t0202_jaminanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t0202_jaminanlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->nasabah_id->FldIsDetailKey) {
			$this->nasabah_id->setFormValue($objForm->GetValue("x_nasabah_id"));
		}
		if (!$this->MerkType->FldIsDetailKey) {
			$this->MerkType->setFormValue($objForm->GetValue("x_MerkType"));
		}
		if (!$this->NoRangka->FldIsDetailKey) {
			$this->NoRangka->setFormValue($objForm->GetValue("x_NoRangka"));
		}
		if (!$this->NoMesin->FldIsDetailKey) {
			$this->NoMesin->setFormValue($objForm->GetValue("x_NoMesin"));
		}
		if (!$this->Warna->FldIsDetailKey) {
			$this->Warna->setFormValue($objForm->GetValue("x_Warna"));
		}
		if (!$this->NoPol->FldIsDetailKey) {
			$this->NoPol->setFormValue($objForm->GetValue("x_NoPol"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->AtasNama->FldIsDetailKey) {
			$this->AtasNama->setFormValue($objForm->GetValue("x_AtasNama"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->nasabah_id->CurrentValue = $this->nasabah_id->FormValue;
		$this->MerkType->CurrentValue = $this->MerkType->FormValue;
		$this->NoRangka->CurrentValue = $this->NoRangka->FormValue;
		$this->NoMesin->CurrentValue = $this->NoMesin->FormValue;
		$this->Warna->CurrentValue = $this->Warna->FormValue;
		$this->NoPol->CurrentValue = $this->NoPol->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->AtasNama->CurrentValue = $this->AtasNama->FormValue;
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
		$this->nasabah_id->setDbValue($rs->fields('nasabah_id'));
		$this->MerkType->setDbValue($rs->fields('MerkType'));
		$this->NoRangka->setDbValue($rs->fields('NoRangka'));
		$this->NoMesin->setDbValue($rs->fields('NoMesin'));
		$this->Warna->setDbValue($rs->fields('Warna'));
		$this->NoPol->setDbValue($rs->fields('NoPol'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->AtasNama->setDbValue($rs->fields('AtasNama'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nasabah_id->DbValue = $row['nasabah_id'];
		$this->MerkType->DbValue = $row['MerkType'];
		$this->NoRangka->DbValue = $row['NoRangka'];
		$this->NoMesin->DbValue = $row['NoMesin'];
		$this->Warna->DbValue = $row['Warna'];
		$this->NoPol->DbValue = $row['NoPol'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->AtasNama->DbValue = $row['AtasNama'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nasabah_id
		// MerkType
		// NoRangka
		// NoMesin
		// Warna
		// NoPol
		// Keterangan
		// AtasNama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nasabah_id
		$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
		$this->nasabah_id->ViewCustomAttributes = "";

		// MerkType
		$this->MerkType->ViewValue = $this->MerkType->CurrentValue;
		$this->MerkType->ViewCustomAttributes = "";

		// NoRangka
		$this->NoRangka->ViewValue = $this->NoRangka->CurrentValue;
		$this->NoRangka->ViewCustomAttributes = "";

		// NoMesin
		$this->NoMesin->ViewValue = $this->NoMesin->CurrentValue;
		$this->NoMesin->ViewCustomAttributes = "";

		// Warna
		$this->Warna->ViewValue = $this->Warna->CurrentValue;
		$this->Warna->ViewCustomAttributes = "";

		// NoPol
		$this->NoPol->ViewValue = $this->NoPol->CurrentValue;
		$this->NoPol->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// AtasNama
		$this->AtasNama->ViewValue = $this->AtasNama->CurrentValue;
		$this->AtasNama->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";
			$this->nasabah_id->TooltipValue = "";

			// MerkType
			$this->MerkType->LinkCustomAttributes = "";
			$this->MerkType->HrefValue = "";
			$this->MerkType->TooltipValue = "";

			// NoRangka
			$this->NoRangka->LinkCustomAttributes = "";
			$this->NoRangka->HrefValue = "";
			$this->NoRangka->TooltipValue = "";

			// NoMesin
			$this->NoMesin->LinkCustomAttributes = "";
			$this->NoMesin->HrefValue = "";
			$this->NoMesin->TooltipValue = "";

			// Warna
			$this->Warna->LinkCustomAttributes = "";
			$this->Warna->HrefValue = "";
			$this->Warna->TooltipValue = "";

			// NoPol
			$this->NoPol->LinkCustomAttributes = "";
			$this->NoPol->HrefValue = "";
			$this->NoPol->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// AtasNama
			$this->AtasNama->LinkCustomAttributes = "";
			$this->AtasNama->HrefValue = "";
			$this->AtasNama->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// nasabah_id
			$this->nasabah_id->EditAttrs["class"] = "form-control";
			$this->nasabah_id->EditCustomAttributes = "";
			$this->nasabah_id->EditValue = ew_HtmlEncode($this->nasabah_id->CurrentValue);
			$this->nasabah_id->PlaceHolder = ew_RemoveHtml($this->nasabah_id->FldCaption());

			// MerkType
			$this->MerkType->EditAttrs["class"] = "form-control";
			$this->MerkType->EditCustomAttributes = "";
			$this->MerkType->EditValue = ew_HtmlEncode($this->MerkType->CurrentValue);
			$this->MerkType->PlaceHolder = ew_RemoveHtml($this->MerkType->FldCaption());

			// NoRangka
			$this->NoRangka->EditAttrs["class"] = "form-control";
			$this->NoRangka->EditCustomAttributes = "";
			$this->NoRangka->EditValue = ew_HtmlEncode($this->NoRangka->CurrentValue);
			$this->NoRangka->PlaceHolder = ew_RemoveHtml($this->NoRangka->FldCaption());

			// NoMesin
			$this->NoMesin->EditAttrs["class"] = "form-control";
			$this->NoMesin->EditCustomAttributes = "";
			$this->NoMesin->EditValue = ew_HtmlEncode($this->NoMesin->CurrentValue);
			$this->NoMesin->PlaceHolder = ew_RemoveHtml($this->NoMesin->FldCaption());

			// Warna
			$this->Warna->EditAttrs["class"] = "form-control";
			$this->Warna->EditCustomAttributes = "";
			$this->Warna->EditValue = ew_HtmlEncode($this->Warna->CurrentValue);
			$this->Warna->PlaceHolder = ew_RemoveHtml($this->Warna->FldCaption());

			// NoPol
			$this->NoPol->EditAttrs["class"] = "form-control";
			$this->NoPol->EditCustomAttributes = "";
			$this->NoPol->EditValue = ew_HtmlEncode($this->NoPol->CurrentValue);
			$this->NoPol->PlaceHolder = ew_RemoveHtml($this->NoPol->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// AtasNama
			$this->AtasNama->EditAttrs["class"] = "form-control";
			$this->AtasNama->EditCustomAttributes = "";
			$this->AtasNama->EditValue = ew_HtmlEncode($this->AtasNama->CurrentValue);
			$this->AtasNama->PlaceHolder = ew_RemoveHtml($this->AtasNama->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";

			// MerkType
			$this->MerkType->LinkCustomAttributes = "";
			$this->MerkType->HrefValue = "";

			// NoRangka
			$this->NoRangka->LinkCustomAttributes = "";
			$this->NoRangka->HrefValue = "";

			// NoMesin
			$this->NoMesin->LinkCustomAttributes = "";
			$this->NoMesin->HrefValue = "";

			// Warna
			$this->Warna->LinkCustomAttributes = "";
			$this->Warna->HrefValue = "";

			// NoPol
			$this->NoPol->LinkCustomAttributes = "";
			$this->NoPol->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// AtasNama
			$this->AtasNama->LinkCustomAttributes = "";
			$this->AtasNama->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->nasabah_id->FldIsDetailKey && !is_null($this->nasabah_id->FormValue) && $this->nasabah_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nasabah_id->FldCaption(), $this->nasabah_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nasabah_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->nasabah_id->FldErrMsg());
		}
		if (!$this->MerkType->FldIsDetailKey && !is_null($this->MerkType->FormValue) && $this->MerkType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MerkType->FldCaption(), $this->MerkType->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nasabah_id
			$this->nasabah_id->SetDbValueDef($rsnew, $this->nasabah_id->CurrentValue, 0, $this->nasabah_id->ReadOnly);

			// MerkType
			$this->MerkType->SetDbValueDef($rsnew, $this->MerkType->CurrentValue, "", $this->MerkType->ReadOnly);

			// NoRangka
			$this->NoRangka->SetDbValueDef($rsnew, $this->NoRangka->CurrentValue, NULL, $this->NoRangka->ReadOnly);

			// NoMesin
			$this->NoMesin->SetDbValueDef($rsnew, $this->NoMesin->CurrentValue, NULL, $this->NoMesin->ReadOnly);

			// Warna
			$this->Warna->SetDbValueDef($rsnew, $this->Warna->CurrentValue, NULL, $this->Warna->ReadOnly);

			// NoPol
			$this->NoPol->SetDbValueDef($rsnew, $this->NoPol->CurrentValue, NULL, $this->NoPol->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

			// AtasNama
			$this->AtasNama->SetDbValueDef($rsnew, $this->AtasNama->CurrentValue, NULL, $this->AtasNama->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0202_jaminanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t0202_jaminan_edit)) $t0202_jaminan_edit = new ct0202_jaminan_edit();

// Page init
$t0202_jaminan_edit->Page_Init();

// Page main
$t0202_jaminan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0202_jaminan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft0202_jaminanedit = new ew_Form("ft0202_jaminanedit", "edit");

// Validate form
ft0202_jaminanedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_nasabah_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0202_jaminan->nasabah_id->FldCaption(), $t0202_jaminan->nasabah_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nasabah_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0202_jaminan->nasabah_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_MerkType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0202_jaminan->MerkType->FldCaption(), $t0202_jaminan->MerkType->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft0202_jaminanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0202_jaminanedit.ValidateRequired = true;
<?php } else { ?>
ft0202_jaminanedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t0202_jaminan_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t0202_jaminan_edit->ShowPageHeader(); ?>
<?php
$t0202_jaminan_edit->ShowMessage();
?>
<form name="ft0202_jaminanedit" id="ft0202_jaminanedit" class="<?php echo $t0202_jaminan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0202_jaminan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0202_jaminan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0202_jaminan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t0202_jaminan_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t0202_jaminan->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_t0202_jaminan_id" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->id->CellAttributes() ?>>
<span id="el_t0202_jaminan_id">
<span<?php echo $t0202_jaminan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t0202_jaminan->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t0202_jaminan" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t0202_jaminan->id->CurrentValue) ?>">
<?php echo $t0202_jaminan->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->nasabah_id->Visible) { // nasabah_id ?>
	<div id="r_nasabah_id" class="form-group">
		<label id="elh_t0202_jaminan_nasabah_id" for="x_nasabah_id" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->nasabah_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->nasabah_id->CellAttributes() ?>>
<span id="el_t0202_jaminan_nasabah_id">
<input type="text" data-table="t0202_jaminan" data-field="x_nasabah_id" name="x_nasabah_id" id="x_nasabah_id" size="30" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->nasabah_id->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->nasabah_id->EditValue ?>"<?php echo $t0202_jaminan->nasabah_id->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->nasabah_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->MerkType->Visible) { // MerkType ?>
	<div id="r_MerkType" class="form-group">
		<label id="elh_t0202_jaminan_MerkType" for="x_MerkType" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->MerkType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->MerkType->CellAttributes() ?>>
<span id="el_t0202_jaminan_MerkType">
<input type="text" data-table="t0202_jaminan" data-field="x_MerkType" name="x_MerkType" id="x_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->MerkType->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->MerkType->EditValue ?>"<?php echo $t0202_jaminan->MerkType->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->MerkType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->NoRangka->Visible) { // NoRangka ?>
	<div id="r_NoRangka" class="form-group">
		<label id="elh_t0202_jaminan_NoRangka" for="x_NoRangka" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->NoRangka->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->NoRangka->CellAttributes() ?>>
<span id="el_t0202_jaminan_NoRangka">
<input type="text" data-table="t0202_jaminan" data-field="x_NoRangka" name="x_NoRangka" id="x_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->NoRangka->EditValue ?>"<?php echo $t0202_jaminan->NoRangka->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->NoRangka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->NoMesin->Visible) { // NoMesin ?>
	<div id="r_NoMesin" class="form-group">
		<label id="elh_t0202_jaminan_NoMesin" for="x_NoMesin" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->NoMesin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->NoMesin->CellAttributes() ?>>
<span id="el_t0202_jaminan_NoMesin">
<input type="text" data-table="t0202_jaminan" data-field="x_NoMesin" name="x_NoMesin" id="x_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->NoMesin->EditValue ?>"<?php echo $t0202_jaminan->NoMesin->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->NoMesin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->Warna->Visible) { // Warna ?>
	<div id="r_Warna" class="form-group">
		<label id="elh_t0202_jaminan_Warna" for="x_Warna" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->Warna->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->Warna->CellAttributes() ?>>
<span id="el_t0202_jaminan_Warna">
<input type="text" data-table="t0202_jaminan" data-field="x_Warna" name="x_Warna" id="x_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->Warna->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->Warna->EditValue ?>"<?php echo $t0202_jaminan->Warna->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->Warna->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->NoPol->Visible) { // NoPol ?>
	<div id="r_NoPol" class="form-group">
		<label id="elh_t0202_jaminan_NoPol" for="x_NoPol" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->NoPol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->NoPol->CellAttributes() ?>>
<span id="el_t0202_jaminan_NoPol">
<input type="text" data-table="t0202_jaminan" data-field="x_NoPol" name="x_NoPol" id="x_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->NoPol->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->NoPol->EditValue ?>"<?php echo $t0202_jaminan->NoPol->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->NoPol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t0202_jaminan_Keterangan" for="x_Keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->Keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->Keterangan->CellAttributes() ?>>
<span id="el_t0202_jaminan_Keterangan">
<textarea data-table="t0202_jaminan" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->Keterangan->getPlaceHolder()) ?>"<?php echo $t0202_jaminan->Keterangan->EditAttributes() ?>><?php echo $t0202_jaminan->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t0202_jaminan->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0202_jaminan->AtasNama->Visible) { // AtasNama ?>
	<div id="r_AtasNama" class="form-group">
		<label id="elh_t0202_jaminan_AtasNama" for="x_AtasNama" class="col-sm-2 control-label ewLabel"><?php echo $t0202_jaminan->AtasNama->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0202_jaminan->AtasNama->CellAttributes() ?>>
<span id="el_t0202_jaminan_AtasNama">
<input type="text" data-table="t0202_jaminan" data-field="x_AtasNama" name="x_AtasNama" id="x_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t0202_jaminan->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t0202_jaminan->AtasNama->EditValue ?>"<?php echo $t0202_jaminan->AtasNama->EditAttributes() ?>>
</span>
<?php echo $t0202_jaminan->AtasNama->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t0202_jaminan_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0202_jaminan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft0202_jaminanedit.Init();
</script>
<?php
$t0202_jaminan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0202_jaminan_edit->Page_Terminate();
?>
