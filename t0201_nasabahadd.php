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

$t0201_nasabah_add = NULL; // Initialize page object first

class ct0201_nasabah_add extends ct0201_nasabah {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0201_nasabah';

	// Page object name
	var $PageObjName = 't0201_nasabah_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Nama->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->Pekerjaan->SetVisibility();
		$this->PekerjaanAlamat->SetVisibility();
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
					$this->Page_Terminate("t0201_nasabahlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t0201_nasabahlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t0201_nasabahview.php")
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
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
		$this->Alamat->CurrentValue = NULL;
		$this->Alamat->OldValue = $this->Alamat->CurrentValue;
		$this->NoTelpHp->CurrentValue = NULL;
		$this->NoTelpHp->OldValue = $this->NoTelpHp->CurrentValue;
		$this->Pekerjaan->CurrentValue = NULL;
		$this->Pekerjaan->OldValue = $this->Pekerjaan->CurrentValue;
		$this->PekerjaanAlamat->CurrentValue = NULL;
		$this->PekerjaanAlamat->OldValue = $this->PekerjaanAlamat->CurrentValue;
		$this->PekerjaanNoTelpHp->CurrentValue = NULL;
		$this->PekerjaanNoTelpHp->OldValue = $this->PekerjaanNoTelpHp->CurrentValue;
		$this->Status->CurrentValue = 0;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->koperasi_id->CurrentValue = NULL;
		$this->koperasi_id->OldValue = $this->koperasi_id->CurrentValue;
		$this->marketing_id->CurrentValue = NULL;
		$this->marketing_id->OldValue = $this->marketing_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Alamat->FldIsDetailKey) {
			$this->Alamat->setFormValue($objForm->GetValue("x_Alamat"));
		}
		if (!$this->NoTelpHp->FldIsDetailKey) {
			$this->NoTelpHp->setFormValue($objForm->GetValue("x_NoTelpHp"));
		}
		if (!$this->Pekerjaan->FldIsDetailKey) {
			$this->Pekerjaan->setFormValue($objForm->GetValue("x_Pekerjaan"));
		}
		if (!$this->PekerjaanAlamat->FldIsDetailKey) {
			$this->PekerjaanAlamat->setFormValue($objForm->GetValue("x_PekerjaanAlamat"));
		}
		if (!$this->PekerjaanNoTelpHp->FldIsDetailKey) {
			$this->PekerjaanNoTelpHp->setFormValue($objForm->GetValue("x_PekerjaanNoTelpHp"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->koperasi_id->FldIsDetailKey) {
			$this->koperasi_id->setFormValue($objForm->GetValue("x_koperasi_id"));
		}
		if (!$this->marketing_id->FldIsDetailKey) {
			$this->marketing_id->setFormValue($objForm->GetValue("x_marketing_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->NoTelpHp->CurrentValue = $this->NoTelpHp->FormValue;
		$this->Pekerjaan->CurrentValue = $this->Pekerjaan->FormValue;
		$this->PekerjaanAlamat->CurrentValue = $this->PekerjaanAlamat->FormValue;
		$this->PekerjaanNoTelpHp->CurrentValue = $this->PekerjaanNoTelpHp->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->koperasi_id->CurrentValue = $this->koperasi_id->FormValue;
		$this->marketing_id->CurrentValue = $this->marketing_id->FormValue;
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

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// NoTelpHp
		$this->NoTelpHp->ViewValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->ViewCustomAttributes = "";

		// Pekerjaan
		$this->Pekerjaan->ViewValue = $this->Pekerjaan->CurrentValue;
		$this->Pekerjaan->ViewCustomAttributes = "";

		// PekerjaanAlamat
		$this->PekerjaanAlamat->ViewValue = $this->PekerjaanAlamat->CurrentValue;
		$this->PekerjaanAlamat->ViewCustomAttributes = "";

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

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";
			$this->Alamat->TooltipValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";
			$this->NoTelpHp->TooltipValue = "";

			// Pekerjaan
			$this->Pekerjaan->LinkCustomAttributes = "";
			$this->Pekerjaan->HrefValue = "";
			$this->Pekerjaan->TooltipValue = "";

			// PekerjaanAlamat
			$this->PekerjaanAlamat->LinkCustomAttributes = "";
			$this->PekerjaanAlamat->HrefValue = "";
			$this->PekerjaanAlamat->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Alamat
			$this->Alamat->EditAttrs["class"] = "form-control";
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = ew_HtmlEncode($this->Alamat->CurrentValue);
			$this->Alamat->PlaceHolder = ew_RemoveHtml($this->Alamat->FldCaption());

			// NoTelpHp
			$this->NoTelpHp->EditAttrs["class"] = "form-control";
			$this->NoTelpHp->EditCustomAttributes = "";
			$this->NoTelpHp->EditValue = ew_HtmlEncode($this->NoTelpHp->CurrentValue);
			$this->NoTelpHp->PlaceHolder = ew_RemoveHtml($this->NoTelpHp->FldCaption());

			// Pekerjaan
			$this->Pekerjaan->EditAttrs["class"] = "form-control";
			$this->Pekerjaan->EditCustomAttributes = "";
			$this->Pekerjaan->EditValue = ew_HtmlEncode($this->Pekerjaan->CurrentValue);
			$this->Pekerjaan->PlaceHolder = ew_RemoveHtml($this->Pekerjaan->FldCaption());

			// PekerjaanAlamat
			$this->PekerjaanAlamat->EditAttrs["class"] = "form-control";
			$this->PekerjaanAlamat->EditCustomAttributes = "";
			$this->PekerjaanAlamat->EditValue = ew_HtmlEncode($this->PekerjaanAlamat->CurrentValue);
			$this->PekerjaanAlamat->PlaceHolder = ew_RemoveHtml($this->PekerjaanAlamat->FldCaption());

			// PekerjaanNoTelpHp
			$this->PekerjaanNoTelpHp->EditAttrs["class"] = "form-control";
			$this->PekerjaanNoTelpHp->EditCustomAttributes = "";
			$this->PekerjaanNoTelpHp->EditValue = ew_HtmlEncode($this->PekerjaanNoTelpHp->CurrentValue);
			$this->PekerjaanNoTelpHp->PlaceHolder = ew_RemoveHtml($this->PekerjaanNoTelpHp->FldCaption());

			// Status
			$this->Status->EditAttrs["class"] = "form-control";
			$this->Status->EditCustomAttributes = "";
			$this->Status->EditValue = ew_HtmlEncode($this->Status->CurrentValue);
			$this->Status->PlaceHolder = ew_RemoveHtml($this->Status->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// koperasi_id
			$this->koperasi_id->EditAttrs["class"] = "form-control";
			$this->koperasi_id->EditCustomAttributes = "";
			$this->koperasi_id->EditValue = ew_HtmlEncode($this->koperasi_id->CurrentValue);
			$this->koperasi_id->PlaceHolder = ew_RemoveHtml($this->koperasi_id->FldCaption());

			// marketing_id
			$this->marketing_id->EditAttrs["class"] = "form-control";
			$this->marketing_id->EditCustomAttributes = "";
			$this->marketing_id->EditValue = ew_HtmlEncode($this->marketing_id->CurrentValue);
			$this->marketing_id->PlaceHolder = ew_RemoveHtml($this->marketing_id->FldCaption());

			// Add refer script
			// Nama

			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";

			// Pekerjaan
			$this->Pekerjaan->LinkCustomAttributes = "";
			$this->Pekerjaan->HrefValue = "";

			// PekerjaanAlamat
			$this->PekerjaanAlamat->LinkCustomAttributes = "";
			$this->PekerjaanAlamat->HrefValue = "";

			// PekerjaanNoTelpHp
			$this->PekerjaanNoTelpHp->LinkCustomAttributes = "";
			$this->PekerjaanNoTelpHp->HrefValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// koperasi_id
			$this->koperasi_id->LinkCustomAttributes = "";
			$this->koperasi_id->HrefValue = "";

			// marketing_id
			$this->marketing_id->LinkCustomAttributes = "";
			$this->marketing_id->HrefValue = "";
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
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
		}
		if (!$this->Alamat->FldIsDetailKey && !is_null($this->Alamat->FormValue) && $this->Alamat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Alamat->FldCaption(), $this->Alamat->ReqErrMsg));
		}
		if (!$this->NoTelpHp->FldIsDetailKey && !is_null($this->NoTelpHp->FormValue) && $this->NoTelpHp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NoTelpHp->FldCaption(), $this->NoTelpHp->ReqErrMsg));
		}
		if (!$this->Pekerjaan->FldIsDetailKey && !is_null($this->Pekerjaan->FormValue) && $this->Pekerjaan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Pekerjaan->FldCaption(), $this->Pekerjaan->ReqErrMsg));
		}
		if (!$this->PekerjaanAlamat->FldIsDetailKey && !is_null($this->PekerjaanAlamat->FormValue) && $this->PekerjaanAlamat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PekerjaanAlamat->FldCaption(), $this->PekerjaanAlamat->ReqErrMsg));
		}
		if (!$this->PekerjaanNoTelpHp->FldIsDetailKey && !is_null($this->PekerjaanNoTelpHp->FormValue) && $this->PekerjaanNoTelpHp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PekerjaanNoTelpHp->FldCaption(), $this->PekerjaanNoTelpHp->ReqErrMsg));
		}
		if (!$this->Status->FldIsDetailKey && !is_null($this->Status->FormValue) && $this->Status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Status->FldCaption(), $this->Status->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Status->FormValue)) {
			ew_AddMessage($gsFormError, $this->Status->FldErrMsg());
		}
		if (!$this->koperasi_id->FldIsDetailKey && !is_null($this->koperasi_id->FormValue) && $this->koperasi_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->koperasi_id->FldCaption(), $this->koperasi_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->koperasi_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->koperasi_id->FldErrMsg());
		}
		if (!$this->marketing_id->FldIsDetailKey && !is_null($this->marketing_id->FormValue) && $this->marketing_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->marketing_id->FldCaption(), $this->marketing_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->marketing_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->marketing_id->FldErrMsg());
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

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

		// Alamat
		$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, "", FALSE);

		// NoTelpHp
		$this->NoTelpHp->SetDbValueDef($rsnew, $this->NoTelpHp->CurrentValue, "", FALSE);

		// Pekerjaan
		$this->Pekerjaan->SetDbValueDef($rsnew, $this->Pekerjaan->CurrentValue, "", FALSE);

		// PekerjaanAlamat
		$this->PekerjaanAlamat->SetDbValueDef($rsnew, $this->PekerjaanAlamat->CurrentValue, "", FALSE);

		// PekerjaanNoTelpHp
		$this->PekerjaanNoTelpHp->SetDbValueDef($rsnew, $this->PekerjaanNoTelpHp->CurrentValue, "", FALSE);

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, 0, strval($this->Status->CurrentValue) == "");

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// koperasi_id
		$this->koperasi_id->SetDbValueDef($rsnew, $this->koperasi_id->CurrentValue, 0, FALSE);

		// marketing_id
		$this->marketing_id->SetDbValueDef($rsnew, $this->marketing_id->CurrentValue, 0, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t0201_nasabahlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t0201_nasabah_add)) $t0201_nasabah_add = new ct0201_nasabah_add();

// Page init
$t0201_nasabah_add->Page_Init();

// Page main
$t0201_nasabah_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0201_nasabah_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft0201_nasabahadd = new ew_Form("ft0201_nasabahadd", "add");

// Validate form
ft0201_nasabahadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->Nama->FldCaption(), $t0201_nasabah->Nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Alamat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->Alamat->FldCaption(), $t0201_nasabah->Alamat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NoTelpHp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->NoTelpHp->FldCaption(), $t0201_nasabah->NoTelpHp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pekerjaan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->Pekerjaan->FldCaption(), $t0201_nasabah->Pekerjaan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PekerjaanAlamat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->PekerjaanAlamat->FldCaption(), $t0201_nasabah->PekerjaanAlamat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PekerjaanNoTelpHp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->PekerjaanNoTelpHp->FldCaption(), $t0201_nasabah->PekerjaanNoTelpHp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->Status->FldCaption(), $t0201_nasabah->Status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0201_nasabah->Status->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_koperasi_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->koperasi_id->FldCaption(), $t0201_nasabah->koperasi_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_koperasi_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0201_nasabah->koperasi_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_marketing_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t0201_nasabah->marketing_id->FldCaption(), $t0201_nasabah->marketing_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_marketing_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t0201_nasabah->marketing_id->FldErrMsg()) ?>");

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
ft0201_nasabahadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0201_nasabahadd.ValidateRequired = true;
<?php } else { ?>
ft0201_nasabahadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t0201_nasabah_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t0201_nasabah_add->ShowPageHeader(); ?>
<?php
$t0201_nasabah_add->ShowMessage();
?>
<form name="ft0201_nasabahadd" id="ft0201_nasabahadd" class="<?php echo $t0201_nasabah_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0201_nasabah_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0201_nasabah_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0201_nasabah">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t0201_nasabah_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t0201_nasabah->Nama->Visible) { // Nama ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_t0201_nasabah_Nama" for="x_Nama" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->Nama->CellAttributes() ?>>
<span id="el_t0201_nasabah_Nama">
<input type="text" data-table="t0201_nasabah" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->Nama->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->Nama->EditValue ?>"<?php echo $t0201_nasabah->Nama->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->Nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->Alamat->Visible) { // Alamat ?>
	<div id="r_Alamat" class="form-group">
		<label id="elh_t0201_nasabah_Alamat" for="x_Alamat" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->Alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t0201_nasabah_Alamat">
<textarea data-table="t0201_nasabah" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->Alamat->getPlaceHolder()) ?>"<?php echo $t0201_nasabah->Alamat->EditAttributes() ?>><?php echo $t0201_nasabah->Alamat->EditValue ?></textarea>
</span>
<?php echo $t0201_nasabah->Alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
	<div id="r_NoTelpHp" class="form-group">
		<label id="elh_t0201_nasabah_NoTelpHp" for="x_NoTelpHp" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->NoTelpHp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el_t0201_nasabah_NoTelpHp">
<input type="text" data-table="t0201_nasabah" data-field="x_NoTelpHp" name="x_NoTelpHp" id="x_NoTelpHp" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->NoTelpHp->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->NoTelpHp->EditValue ?>"<?php echo $t0201_nasabah->NoTelpHp->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->NoTelpHp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
	<div id="r_Pekerjaan" class="form-group">
		<label id="elh_t0201_nasabah_Pekerjaan" for="x_Pekerjaan" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->Pekerjaan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t0201_nasabah_Pekerjaan">
<input type="text" data-table="t0201_nasabah" data-field="x_Pekerjaan" name="x_Pekerjaan" id="x_Pekerjaan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->Pekerjaan->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->Pekerjaan->EditValue ?>"<?php echo $t0201_nasabah->Pekerjaan->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->Pekerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->PekerjaanAlamat->Visible) { // PekerjaanAlamat ?>
	<div id="r_PekerjaanAlamat" class="form-group">
		<label id="elh_t0201_nasabah_PekerjaanAlamat" for="x_PekerjaanAlamat" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->PekerjaanAlamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->PekerjaanAlamat->CellAttributes() ?>>
<span id="el_t0201_nasabah_PekerjaanAlamat">
<textarea data-table="t0201_nasabah" data-field="x_PekerjaanAlamat" name="x_PekerjaanAlamat" id="x_PekerjaanAlamat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->PekerjaanAlamat->getPlaceHolder()) ?>"<?php echo $t0201_nasabah->PekerjaanAlamat->EditAttributes() ?>><?php echo $t0201_nasabah->PekerjaanAlamat->EditValue ?></textarea>
</span>
<?php echo $t0201_nasabah->PekerjaanAlamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->PekerjaanNoTelpHp->Visible) { // PekerjaanNoTelpHp ?>
	<div id="r_PekerjaanNoTelpHp" class="form-group">
		<label id="elh_t0201_nasabah_PekerjaanNoTelpHp" for="x_PekerjaanNoTelpHp" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->PekerjaanNoTelpHp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->PekerjaanNoTelpHp->CellAttributes() ?>>
<span id="el_t0201_nasabah_PekerjaanNoTelpHp">
<input type="text" data-table="t0201_nasabah" data-field="x_PekerjaanNoTelpHp" name="x_PekerjaanNoTelpHp" id="x_PekerjaanNoTelpHp" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->PekerjaanNoTelpHp->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->PekerjaanNoTelpHp->EditValue ?>"<?php echo $t0201_nasabah->PekerjaanNoTelpHp->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->PekerjaanNoTelpHp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->Status->Visible) { // Status ?>
	<div id="r_Status" class="form-group">
		<label id="elh_t0201_nasabah_Status" for="x_Status" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->Status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->Status->CellAttributes() ?>>
<span id="el_t0201_nasabah_Status">
<input type="text" data-table="t0201_nasabah" data-field="x_Status" name="x_Status" id="x_Status" size="30" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->Status->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->Status->EditValue ?>"<?php echo $t0201_nasabah->Status->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->Status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t0201_nasabah_Keterangan" for="x_Keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->Keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->Keterangan->CellAttributes() ?>>
<span id="el_t0201_nasabah_Keterangan">
<input type="text" data-table="t0201_nasabah" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->Keterangan->EditValue ?>"<?php echo $t0201_nasabah->Keterangan->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->koperasi_id->Visible) { // koperasi_id ?>
	<div id="r_koperasi_id" class="form-group">
		<label id="elh_t0201_nasabah_koperasi_id" for="x_koperasi_id" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->koperasi_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->koperasi_id->CellAttributes() ?>>
<span id="el_t0201_nasabah_koperasi_id">
<input type="text" data-table="t0201_nasabah" data-field="x_koperasi_id" name="x_koperasi_id" id="x_koperasi_id" size="30" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->koperasi_id->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->koperasi_id->EditValue ?>"<?php echo $t0201_nasabah->koperasi_id->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->koperasi_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t0201_nasabah->marketing_id->Visible) { // marketing_id ?>
	<div id="r_marketing_id" class="form-group">
		<label id="elh_t0201_nasabah_marketing_id" for="x_marketing_id" class="col-sm-2 control-label ewLabel"><?php echo $t0201_nasabah->marketing_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t0201_nasabah->marketing_id->CellAttributes() ?>>
<span id="el_t0201_nasabah_marketing_id">
<input type="text" data-table="t0201_nasabah" data-field="x_marketing_id" name="x_marketing_id" id="x_marketing_id" size="30" placeholder="<?php echo ew_HtmlEncode($t0201_nasabah->marketing_id->getPlaceHolder()) ?>" value="<?php echo $t0201_nasabah->marketing_id->EditValue ?>"<?php echo $t0201_nasabah->marketing_id->EditAttributes() ?>>
</span>
<?php echo $t0201_nasabah->marketing_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t0201_nasabah_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t0201_nasabah_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft0201_nasabahadd.Init();
</script>
<?php
$t0201_nasabah_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0201_nasabah_add->Page_Terminate();
?>
