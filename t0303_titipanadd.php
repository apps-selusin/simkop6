<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0303_titipaninfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0303_titipan_add = NULL; // Initialize page object first

class ct0303_titipan_add extends ct0303_titipan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0303_titipan';

	// Page object name
	var $PageObjName = 't0303_titipan_add';

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

		// Table object (t0303_titipan)
		if (!isset($GLOBALS["t0303_titipan"]) || get_class($GLOBALS["t0303_titipan"]) == "ct0303_titipan") {
			$GLOBALS["t0303_titipan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0303_titipan"];
		}

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0303_titipan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t0303_titipanlist.php"));
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
		$this->pinjaman_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Masuk->SetVisibility();
		$this->Keluar->SetVisibility();
		$this->Sisa->SetVisibility();
		$this->Angsuran_Ke->SetVisibility();

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
		global $EW_EXPORT, $t0303_titipan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0303_titipan);
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
					$this->Page_Terminate("t0303_titipanlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t0303_titipanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t0303_titipanview.php")
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
		$this->pinjaman_id->CurrentValue = NULL;
		$this->pinjaman_id->OldValue = $this->pinjaman_id->CurrentValue;
		$this->Tanggal->CurrentValue = NULL;
		$this->Tanggal->OldValue = $this->Tanggal->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Masuk->CurrentValue = 0.00;
		$this->Keluar->CurrentValue = 0.00;
		$this->Sisa->CurrentValue = 0.00;
		$this->Angsuran_Ke->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->pinjaman_id->FldIsDetailKey) {
			$this->pinjaman_id->setFormValue($objForm->GetValue("x_pinjaman_id"));
		}
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->Masuk->FldIsDetailKey) {
			$this->Masuk->setFormValue($objForm->GetValue("x_Masuk"));
		}
		if (!$this->Keluar->FldIsDetailKey) {
			$this->Keluar->setFormValue($objForm->GetValue("x_Keluar"));
		}
		if (!$this->Sisa->FldIsDetailKey) {
			$this->Sisa->setFormValue($objForm->GetValue("x_Sisa"));
		}
		if (!$this->Angsuran_Ke->FldIsDetailKey) {
			$this->Angsuran_Ke->setFormValue($objForm->GetValue("x_Angsuran_Ke"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->pinjaman_id->CurrentValue = $this->pinjaman_id->FormValue;
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Masuk->CurrentValue = $this->Masuk->FormValue;
		$this->Keluar->CurrentValue = $this->Keluar->FormValue;
		$this->Sisa->CurrentValue = $this->Sisa->FormValue;
		$this->Angsuran_Ke->CurrentValue = $this->Angsuran_Ke->FormValue;
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
		$this->pinjaman_id->setDbValue($rs->fields('pinjaman_id'));
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Masuk->setDbValue($rs->fields('Masuk'));
		$this->Keluar->setDbValue($rs->fields('Keluar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
		$this->Angsuran_Ke->setDbValue($rs->fields('Angsuran_Ke'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pinjaman_id->DbValue = $row['pinjaman_id'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Masuk->DbValue = $row['Masuk'];
		$this->Keluar->DbValue = $row['Keluar'];
		$this->Sisa->DbValue = $row['Sisa'];
		$this->Angsuran_Ke->DbValue = $row['Angsuran_Ke'];
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

		if ($this->Masuk->FormValue == $this->Masuk->CurrentValue && is_numeric(ew_StrToFloat($this->Masuk->CurrentValue)))
			$this->Masuk->CurrentValue = ew_StrToFloat($this->Masuk->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Keluar->FormValue == $this->Keluar->CurrentValue && is_numeric(ew_StrToFloat($this->Keluar->CurrentValue)))
			$this->Keluar->CurrentValue = ew_StrToFloat($this->Keluar->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa->FormValue == $this->Sisa->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa->CurrentValue)))
			$this->Sisa->CurrentValue = ew_StrToFloat($this->Sisa->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// pinjaman_id
		// Tanggal
		// Keterangan
		// Masuk
		// Keluar
		// Sisa
		// Angsuran_Ke

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pinjaman_id
		$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
		$this->pinjaman_id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Masuk
		$this->Masuk->ViewValue = $this->Masuk->CurrentValue;
		$this->Masuk->ViewCustomAttributes = "";

		// Keluar
		$this->Keluar->ViewValue = $this->Keluar->CurrentValue;
		$this->Keluar->ViewCustomAttributes = "";

		// Sisa
		$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
		$this->Sisa->ViewCustomAttributes = "";

		// Angsuran_Ke
		$this->Angsuran_Ke->ViewValue = $this->Angsuran_Ke->CurrentValue;
		$this->Angsuran_Ke->ViewCustomAttributes = "";

			// pinjaman_id
			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";
			$this->pinjaman_id->TooltipValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Masuk
			$this->Masuk->LinkCustomAttributes = "";
			$this->Masuk->HrefValue = "";
			$this->Masuk->TooltipValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";
			$this->Keluar->TooltipValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
			$this->Sisa->TooltipValue = "";

			// Angsuran_Ke
			$this->Angsuran_Ke->LinkCustomAttributes = "";
			$this->Angsuran_Ke->HrefValue = "";
			$this->Angsuran_Ke->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pinjaman_id
			$this->pinjaman_id->EditAttrs["class"] = "form-control";
			$this->pinjaman_id->EditCustomAttributes = "";
			$this->pinjaman_id->EditValue = ew_HtmlEncode($this->pinjaman_id->CurrentValue);
			$this->pinjaman_id->PlaceHolder = ew_RemoveHtml($this->pinjaman_id->FldCaption());

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 8));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Masuk
			$this->Masuk->EditAttrs["class"] = "form-control";
			$this->Masuk->EditCustomAttributes = "";
			$this->Masuk->EditValue = ew_HtmlEncode($this->Masuk->CurrentValue);
			$this->Masuk->PlaceHolder = ew_RemoveHtml($this->Masuk->FldCaption());
			if (strval($this->Masuk->EditValue) <> "" && is_numeric($this->Masuk->EditValue)) $this->Masuk->EditValue = ew_FormatNumber($this->Masuk->EditValue, -2, -1, -2, 0);

			// Keluar
			$this->Keluar->EditAttrs["class"] = "form-control";
			$this->Keluar->EditCustomAttributes = "";
			$this->Keluar->EditValue = ew_HtmlEncode($this->Keluar->CurrentValue);
			$this->Keluar->PlaceHolder = ew_RemoveHtml($this->Keluar->FldCaption());
			if (strval($this->Keluar->EditValue) <> "" && is_numeric($this->Keluar->EditValue)) $this->Keluar->EditValue = ew_FormatNumber($this->Keluar->EditValue, -2, -1, -2, 0);

			// Sisa
			$this->Sisa->EditAttrs["class"] = "form-control";
			$this->Sisa->EditCustomAttributes = "";
			$this->Sisa->EditValue = ew_HtmlEncode($this->Sisa->CurrentValue);
			$this->Sisa->PlaceHolder = ew_RemoveHtml($this->Sisa->FldCaption());
			if (strval($this->Sisa->EditValue) <> "" && is_numeric($this->Sisa->EditValue)) $this->Sisa->EditValue = ew_FormatNumber($this->Sisa->EditValue, -2, -1, -2, 0);

			// Angsuran_Ke
			$this->Angsuran_Ke->EditAttrs["class"] = "form-control";
			$this->Angsuran_Ke->EditCustomAttributes = "";
			$this->Angsuran_Ke->EditValue = ew_HtmlEncode($this->Angsuran_Ke->CurrentValue);
			$this->Angsuran_Ke->PlaceHolder = ew_RemoveHtml($this->Angsuran_Ke->FldCaption());

			// Add refer script
			// pinjaman_id

			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Masuk
			$this->Masuk->LinkCustomAttributes = "";
			$this->Masuk->HrefValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";

			// Angsuran_Ke
			$this->Angsuran_Ke->LinkCustomAttributes = "";
			$this->Angsuran_Ke->HrefValue = "";
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
		if (!$this->pinjaman_id->FldIsDetailKey && !is_null($this->pinjaman_id->FormValue) && $this->pinjaman_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pinjaman_id->FldCaption(), $this->pinjaman_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->pinjaman_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->pinjaman_id->FldErrMsg());
		}
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!$this->Masuk->FldIsDetailKey && !is_null($this->Masuk->FormValue) && $this->Masuk->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Masuk->FldCaption(), $this->Masuk->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Masuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->Masuk->FldErrMsg());
		}
		if (!$this->Keluar->FldIsDetailKey && !is_null($this->Keluar->FormValue) && $this->Keluar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Keluar->FldCaption(), $this->Keluar->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Keluar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Keluar->FldErrMsg());
		}
		if (!$this->Sisa->FldIsDetailKey && !is_null($this->Sisa->FormValue) && $this->Sisa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sisa->FldCaption(), $this->Sisa->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Sisa->FormValue)) {
			ew_AddMessage($gsFormError, $this->Sisa->FldErrMsg());
		}
		if (!$this->Angsuran_Ke->FldIsDetailKey && !is_null($this->Angsuran_Ke->FormValue) && $this->Angsuran_Ke->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Ke->FldCaption(), $this->Angsuran_Ke->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Angsuran_Ke->FormValue)) {
			ew_AddMessage($gsFormError, $this->Angsuran_Ke->FldErrMsg());
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

		// pinjaman_id
		$this->pinjaman_id->SetDbValueDef($rsnew, $this->pinjaman_id->CurrentValue, 0, FALSE);

		// Tanggal
		$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// Masuk
		$this->Masuk->SetDbValueDef($rsnew, $this->Masuk->CurrentValue, 0, strval($this->Masuk->CurrentValue) == "");

		// Keluar
		$this->Keluar->SetDbValueDef($rsnew, $this->Keluar->CurrentValue, 0, strval($this->Keluar->CurrentValue) == "");

		// Sisa
		$this->Sisa->SetDbValueDef($rsnew, $this->Sisa->CurrentValue, 0, strval($this->Sisa->CurrentValue) == "");

		// Angsuran_Ke
		$this->Angsuran_Ke->SetDbValueDef($rsnew, $this->Angsuran_Ke->CurrentValue, 0, strval($this->Angsuran_Ke->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0303_titipanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t0303_titipan_add)) $t0303_titipan_add = new ct0303_titipan_add();

// Page init
$t0303_titipan_add->Page_Init();

// Page main
$t0303_titipan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0303_titipan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft0303_titipanadd = new ew_Form("ft0303_titipanadd", "add");

// Validate form
ft0303_titipanadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pinjaman_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->pinjaman_id->FldCaption(), $t0303_titipan->pinjaman_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pinjaman_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->pinjaman_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->Tanggal->FldCaption(), $t0303_titipan->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Masuk");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->Masuk->FldCaption(), $t0303_titipan->Masuk->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Masuk");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->Masuk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Keluar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->Keluar->FldCaption(), $t0303_titipan->Keluar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Keluar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->Keluar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Sisa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->Sisa->FldCaption(), $t0303_titipan->Sisa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sisa");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->Sisa->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Angsuran_Ke");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0303_titipan->Angsuran_Ke->FldCaption(), $t0303_titipan->Angsuran_Ke->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Angsuran_Ke");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0303_titipan->Angsuran_Ke->FldErrMsg()) ?>");

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
ft0303_titipanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0303_titipanadd.ValidateRequired = true;
<?php } else { ?>
ft0303_titipanadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t0303_titipan_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t0303_titipan_add->ShowPageHeader(); ?>
<?php
$t0303_titipan_add->ShowMessage();
?>
<form name="ft0303_titipanadd" id="ft0303_titipanadd" class="<?php echo $t0303_titipan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0303_titipan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0303_titipan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0303_titipan">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t0303_titipan_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t0303_titipan->pinjaman_id->Visible) { // pinjaman_id ?>
	<div id="r_pinjaman_id" class="form-group">
		<label id="elh_t0303_titipan_pinjaman_id" for="x_pinjaman_id" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->pinjaman_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->pinjaman_id->CellAttributes() ?>>
<span id="el_t0303_titipan_pinjaman_id">
<input type="text" data-table="t0303_titipan" data-field="x_pinjaman_id" name="x_pinjaman_id" id="x_pinjaman_id" size="30" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->pinjaman_id->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->pinjaman_id->EditValue ?>"<?php echo $t0303_titipan->pinjaman_id->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->pinjaman_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t0303_titipan_Tanggal" for="x_Tanggal" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Tanggal->CellAttributes() ?>>
<span id="el_t0303_titipan_Tanggal">
<input type="text" data-table="t0303_titipan" data-field="x_Tanggal" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->Tanggal->EditValue ?>"<?php echo $t0303_titipan->Tanggal->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t0303_titipan_Keterangan" for="x_Keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Keterangan->CellAttributes() ?>>
<span id="el_t0303_titipan_Keterangan">
<textarea data-table="t0303_titipan" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Keterangan->getPlaceHolder()) ?>"<?php echo $t0303_titipan->Keterangan->EditAttributes() ?>><?php echo $t0303_titipan->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t0303_titipan->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Masuk->Visible) { // Masuk ?>
	<div id="r_Masuk" class="form-group">
		<label id="elh_t0303_titipan_Masuk" for="x_Masuk" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Masuk->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Masuk->CellAttributes() ?>>
<span id="el_t0303_titipan_Masuk">
<input type="text" data-table="t0303_titipan" data-field="x_Masuk" name="x_Masuk" id="x_Masuk" size="30" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Masuk->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->Masuk->EditValue ?>"<?php echo $t0303_titipan->Masuk->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->Masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Keluar->Visible) { // Keluar ?>
	<div id="r_Keluar" class="form-group">
		<label id="elh_t0303_titipan_Keluar" for="x_Keluar" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Keluar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Keluar->CellAttributes() ?>>
<span id="el_t0303_titipan_Keluar">
<input type="text" data-table="t0303_titipan" data-field="x_Keluar" name="x_Keluar" id="x_Keluar" size="30" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Keluar->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->Keluar->EditValue ?>"<?php echo $t0303_titipan->Keluar->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->Keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Sisa->Visible) { // Sisa ?>
	<div id="r_Sisa" class="form-group">
		<label id="elh_t0303_titipan_Sisa" for="x_Sisa" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Sisa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Sisa->CellAttributes() ?>>
<span id="el_t0303_titipan_Sisa">
<input type="text" data-table="t0303_titipan" data-field="x_Sisa" name="x_Sisa" id="x_Sisa" size="30" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Sisa->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->Sisa->EditValue ?>"<?php echo $t0303_titipan->Sisa->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->Sisa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0303_titipan->Angsuran_Ke->Visible) { // Angsuran_Ke ?>
	<div id="r_Angsuran_Ke" class="form-group">
		<label id="elh_t0303_titipan_Angsuran_Ke" for="x_Angsuran_Ke" class="col-sm-2 control-label ewLabel"><?php echo $t0303_titipan->Angsuran_Ke->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0303_titipan->Angsuran_Ke->CellAttributes() ?>>
<span id="el_t0303_titipan_Angsuran_Ke">
<input type="text" data-table="t0303_titipan" data-field="x_Angsuran_Ke" name="x_Angsuran_Ke" id="x_Angsuran_Ke" size="30" placeholder="<?php echo ew_HtmlEncode($t0303_titipan->Angsuran_Ke->getPlaceHolder()) ?>" value="<?php echo $t0303_titipan->Angsuran_Ke->EditValue ?>"<?php echo $t0303_titipan->Angsuran_Ke->EditAttributes() ?>>
</span>
<?php echo $t0303_titipan->Angsuran_Ke->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t0303_titipan_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0303_titipan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft0303_titipanadd.Init();
</script>
<?php
$t0303_titipan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0303_titipan_add->Page_Terminate();
?>
