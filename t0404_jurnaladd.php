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

$t0404_jurnal_add = NULL; // Initialize page object first

class ct0404_jurnal_add extends ct0404_jurnal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0404_jurnal';

	// Page object name
	var $PageObjName = 't0404_jurnal_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t0404_jurnallist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t0404_jurnallist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t0404_jurnalview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Tanggal->CurrentValue = NULL;
		$this->Tanggal->OldValue = $this->Tanggal->CurrentValue;
		$this->Periode->CurrentValue = NULL;
		$this->Periode->OldValue = $this->Periode->CurrentValue;
		$this->NomorTransaksi->CurrentValue = NULL;
		$this->NomorTransaksi->OldValue = $this->NomorTransaksi->CurrentValue;
		$this->Rekening->CurrentValue = NULL;
		$this->Rekening->OldValue = $this->Rekening->CurrentValue;
		$this->Debet->CurrentValue = NULL;
		$this->Debet->OldValue = $this->Debet->CurrentValue;
		$this->Kredit->CurrentValue = NULL;
		$this->Kredit->OldValue = $this->Kredit->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		}
		if (!$this->Periode->FldIsDetailKey) {
			$this->Periode->setFormValue($objForm->GetValue("x_Periode"));
		}
		if (!$this->NomorTransaksi->FldIsDetailKey) {
			$this->NomorTransaksi->setFormValue($objForm->GetValue("x_NomorTransaksi"));
		}
		if (!$this->Rekening->FldIsDetailKey) {
			$this->Rekening->setFormValue($objForm->GetValue("x_Rekening"));
		}
		if (!$this->Debet->FldIsDetailKey) {
			$this->Debet->setFormValue($objForm->GetValue("x_Debet"));
		}
		if (!$this->Kredit->FldIsDetailKey) {
			$this->Kredit->setFormValue($objForm->GetValue("x_Kredit"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		$this->Periode->CurrentValue = $this->Periode->FormValue;
		$this->NomorTransaksi->CurrentValue = $this->NomorTransaksi->FormValue;
		$this->Rekening->CurrentValue = $this->Rekening->FormValue;
		$this->Debet->CurrentValue = $this->Debet->FormValue;
		$this->Kredit->CurrentValue = $this->Kredit->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 8));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// Periode
			$this->Periode->EditAttrs["class"] = "form-control";
			$this->Periode->EditCustomAttributes = "";
			$this->Periode->EditValue = ew_HtmlEncode($this->Periode->CurrentValue);
			$this->Periode->PlaceHolder = ew_RemoveHtml($this->Periode->FldCaption());

			// NomorTransaksi
			$this->NomorTransaksi->EditAttrs["class"] = "form-control";
			$this->NomorTransaksi->EditCustomAttributes = "";
			$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->CurrentValue);
			$this->NomorTransaksi->PlaceHolder = ew_RemoveHtml($this->NomorTransaksi->FldCaption());

			// Rekening
			$this->Rekening->EditAttrs["class"] = "form-control";
			$this->Rekening->EditCustomAttributes = "";
			$this->Rekening->EditValue = ew_HtmlEncode($this->Rekening->CurrentValue);
			$this->Rekening->PlaceHolder = ew_RemoveHtml($this->Rekening->FldCaption());

			// Debet
			$this->Debet->EditAttrs["class"] = "form-control";
			$this->Debet->EditCustomAttributes = "";
			$this->Debet->EditValue = ew_HtmlEncode($this->Debet->CurrentValue);
			$this->Debet->PlaceHolder = ew_RemoveHtml($this->Debet->FldCaption());
			if (strval($this->Debet->EditValue) <> "" && is_numeric($this->Debet->EditValue)) $this->Debet->EditValue = ew_FormatNumber($this->Debet->EditValue, -2, -1, -2, 0);

			// Kredit
			$this->Kredit->EditAttrs["class"] = "form-control";
			$this->Kredit->EditCustomAttributes = "";
			$this->Kredit->EditValue = ew_HtmlEncode($this->Kredit->CurrentValue);
			$this->Kredit->PlaceHolder = ew_RemoveHtml($this->Kredit->FldCaption());
			if (strval($this->Kredit->EditValue) <> "" && is_numeric($this->Kredit->EditValue)) $this->Kredit->EditValue = ew_FormatNumber($this->Kredit->EditValue, -2, -1, -2, 0);

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Add refer script
			// Tanggal

			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// Periode
			$this->Periode->LinkCustomAttributes = "";
			$this->Periode->HrefValue = "";

			// NomorTransaksi
			$this->NomorTransaksi->LinkCustomAttributes = "";
			$this->NomorTransaksi->HrefValue = "";

			// Rekening
			$this->Rekening->LinkCustomAttributes = "";
			$this->Rekening->HrefValue = "";

			// Debet
			$this->Debet->LinkCustomAttributes = "";
			$this->Debet->HrefValue = "";

			// Kredit
			$this->Kredit->LinkCustomAttributes = "";
			$this->Kredit->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
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
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!$this->Periode->FldIsDetailKey && !is_null($this->Periode->FormValue) && $this->Periode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Periode->FldCaption(), $this->Periode->ReqErrMsg));
		}
		if (!$this->NomorTransaksi->FldIsDetailKey && !is_null($this->NomorTransaksi->FormValue) && $this->NomorTransaksi->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NomorTransaksi->FldCaption(), $this->NomorTransaksi->ReqErrMsg));
		}
		if (!$this->Rekening->FldIsDetailKey && !is_null($this->Rekening->FormValue) && $this->Rekening->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Rekening->FldCaption(), $this->Rekening->ReqErrMsg));
		}
		if (!$this->Debet->FldIsDetailKey && !is_null($this->Debet->FormValue) && $this->Debet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Debet->FldCaption(), $this->Debet->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Debet->FormValue)) {
			ew_AddMessage($gsFormError, $this->Debet->FldErrMsg());
		}
		if (!$this->Kredit->FldIsDetailKey && !is_null($this->Kredit->FormValue) && $this->Kredit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Kredit->FldCaption(), $this->Kredit->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Kredit->FormValue)) {
			ew_AddMessage($gsFormError, $this->Kredit->FldErrMsg());
		}
		if (!$this->Keterangan->FldIsDetailKey && !is_null($this->Keterangan->FormValue) && $this->Keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Keterangan->FldCaption(), $this->Keterangan->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Tanggal
		$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// Periode
		$this->Periode->SetDbValueDef($rsnew, $this->Periode->CurrentValue, "", FALSE);

		// NomorTransaksi
		$this->NomorTransaksi->SetDbValueDef($rsnew, $this->NomorTransaksi->CurrentValue, "", FALSE);

		// Rekening
		$this->Rekening->SetDbValueDef($rsnew, $this->Rekening->CurrentValue, "", FALSE);

		// Debet
		$this->Debet->SetDbValueDef($rsnew, $this->Debet->CurrentValue, 0, FALSE);

		// Kredit
		$this->Kredit->SetDbValueDef($rsnew, $this->Kredit->CurrentValue, 0, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0404_jurnallist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($t0404_jurnal_add)) $t0404_jurnal_add = new ct0404_jurnal_add();

// Page init
$t0404_jurnal_add->Page_Init();

// Page main
$t0404_jurnal_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0404_jurnal_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft0404_jurnaladd = new ew_Form("ft0404_jurnaladd", "add");

// Validate form
ft0404_jurnaladd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Tanggal->FldCaption(), $t0404_jurnal->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0404_jurnal->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Periode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Periode->FldCaption(), $t0404_jurnal->Periode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NomorTransaksi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->NomorTransaksi->FldCaption(), $t0404_jurnal->NomorTransaksi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Rekening");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Rekening->FldCaption(), $t0404_jurnal->Rekening->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Debet->FldCaption(), $t0404_jurnal->Debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0404_jurnal->Debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Kredit->FldCaption(), $t0404_jurnal->Kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0404_jurnal->Kredit->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0404_jurnal->Keterangan->FldCaption(), $t0404_jurnal->Keterangan->ReqErrMsg)) ?>");

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
ft0404_jurnaladd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0404_jurnaladd.ValidateRequired = true;
<?php } else { ?>
ft0404_jurnaladd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t0404_jurnal_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t0404_jurnal_add->ShowPageHeader(); ?>
<?php
$t0404_jurnal_add->ShowMessage();
?>
<form name="ft0404_jurnaladd" id="ft0404_jurnaladd" class="<?php echo $t0404_jurnal_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0404_jurnal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0404_jurnal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0404_jurnal">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t0404_jurnal_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t0404_jurnal->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t0404_jurnal_Tanggal" for="x_Tanggal" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Tanggal->CellAttributes() ?>>
<span id="el_t0404_jurnal_Tanggal">
<input type="text" data-table="t0404_jurnal" data-field="x_Tanggal" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Tanggal->EditValue ?>"<?php echo $t0404_jurnal->Tanggal->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->Periode->Visible) { // Periode ?>
	<div id="r_Periode" class="form-group">
		<label id="elh_t0404_jurnal_Periode" for="x_Periode" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Periode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Periode->CellAttributes() ?>>
<span id="el_t0404_jurnal_Periode">
<input type="text" data-table="t0404_jurnal" data-field="x_Periode" name="x_Periode" id="x_Periode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Periode->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Periode->EditValue ?>"<?php echo $t0404_jurnal->Periode->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Periode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
	<div id="r_NomorTransaksi" class="form-group">
		<label id="elh_t0404_jurnal_NomorTransaksi" for="x_NomorTransaksi" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->NomorTransaksi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->NomorTransaksi->CellAttributes() ?>>
<span id="el_t0404_jurnal_NomorTransaksi">
<input type="text" data-table="t0404_jurnal" data-field="x_NomorTransaksi" name="x_NomorTransaksi" id="x_NomorTransaksi" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->NomorTransaksi->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->NomorTransaksi->EditValue ?>"<?php echo $t0404_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->NomorTransaksi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->Rekening->Visible) { // Rekening ?>
	<div id="r_Rekening" class="form-group">
		<label id="elh_t0404_jurnal_Rekening" for="x_Rekening" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Rekening->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Rekening->CellAttributes() ?>>
<span id="el_t0404_jurnal_Rekening">
<input type="text" data-table="t0404_jurnal" data-field="x_Rekening" name="x_Rekening" id="x_Rekening" size="30" maxlength="35" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Rekening->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Rekening->EditValue ?>"<?php echo $t0404_jurnal->Rekening->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->Debet->Visible) { // Debet ?>
	<div id="r_Debet" class="form-group">
		<label id="elh_t0404_jurnal_Debet" for="x_Debet" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Debet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Debet->CellAttributes() ?>>
<span id="el_t0404_jurnal_Debet">
<input type="text" data-table="t0404_jurnal" data-field="x_Debet" name="x_Debet" id="x_Debet" size="30" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Debet->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Debet->EditValue ?>"<?php echo $t0404_jurnal->Debet->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Debet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->Kredit->Visible) { // Kredit ?>
	<div id="r_Kredit" class="form-group">
		<label id="elh_t0404_jurnal_Kredit" for="x_Kredit" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Kredit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Kredit->CellAttributes() ?>>
<span id="el_t0404_jurnal_Kredit">
<input type="text" data-table="t0404_jurnal" data-field="x_Kredit" name="x_Kredit" id="x_Kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Kredit->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Kredit->EditValue ?>"<?php echo $t0404_jurnal->Kredit->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Kredit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0404_jurnal->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t0404_jurnal_Keterangan" for="x_Keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t0404_jurnal->Keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0404_jurnal->Keterangan->CellAttributes() ?>>
<span id="el_t0404_jurnal_Keterangan">
<input type="text" data-table="t0404_jurnal" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t0404_jurnal->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t0404_jurnal->Keterangan->EditValue ?>"<?php echo $t0404_jurnal->Keterangan->EditAttributes() ?>>
</span>
<?php echo $t0404_jurnal->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t0404_jurnal_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0404_jurnal_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft0404_jurnaladd.Init();
</script>
<?php
$t0404_jurnal_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0404_jurnal_add->Page_Terminate();
?>
