<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0302_angsuraninfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0302_angsuran_list = NULL; // Initialize page object first

class ct0302_angsuran_list extends ct0302_angsuran {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0302_angsuran';

	// Page object name
	var $PageObjName = 't0302_angsuran_list';

	// Grid form hidden field names
	var $FormName = 'ft0302_angsuranlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (t0302_angsuran)
		if (!isset($GLOBALS["t0302_angsuran"]) || get_class($GLOBALS["t0302_angsuran"]) == "ct0302_angsuran") {
			$GLOBALS["t0302_angsuran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0302_angsuran"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t0302_angsuranadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t0302_angsurandelete.php";
		$this->MultiUpdateUrl = "t0302_angsuranupdate.php";

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0302_angsuran', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t9901_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct9901_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft0302_angsuranlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->pinjaman_id->SetVisibility();
		$this->Angsuran_Ke->SetVisibility();
		$this->Angsuran_Tanggal->SetVisibility();
		$this->Angsuran_Pokok->SetVisibility();
		$this->Angsuran_Bunga->SetVisibility();
		$this->Angsuran_Total->SetVisibility();
		$this->Sisa_Hutang->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Terlambat->SetVisibility();
		$this->Total_Denda->SetVisibility();
		$this->Bayar_Titipan->SetVisibility();
		$this->Bayar_Non_Titipan->SetVisibility();
		$this->Bayar_Total->SetVisibility();
		$this->Periode->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $t0302_angsuran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0302_angsuran);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft0302_angsuranlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->pinjaman_id->AdvancedSearch->ToJSON(), ","); // Field pinjaman_id
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Ke->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Ke
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Tanggal->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Tanggal
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Pokok->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Pokok
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Bunga->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Bunga
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Total->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Total
		$sFilterList = ew_Concat($sFilterList, $this->Sisa_Hutang->AdvancedSearch->ToJSON(), ","); // Field Sisa_Hutang
		$sFilterList = ew_Concat($sFilterList, $this->Tanggal_Bayar->AdvancedSearch->ToJSON(), ","); // Field Tanggal_Bayar
		$sFilterList = ew_Concat($sFilterList, $this->Terlambat->AdvancedSearch->ToJSON(), ","); // Field Terlambat
		$sFilterList = ew_Concat($sFilterList, $this->Total_Denda->AdvancedSearch->ToJSON(), ","); // Field Total_Denda
		$sFilterList = ew_Concat($sFilterList, $this->Bayar_Titipan->AdvancedSearch->ToJSON(), ","); // Field Bayar_Titipan
		$sFilterList = ew_Concat($sFilterList, $this->Bayar_Non_Titipan->AdvancedSearch->ToJSON(), ","); // Field Bayar_Non_Titipan
		$sFilterList = ew_Concat($sFilterList, $this->Bayar_Total->AdvancedSearch->ToJSON(), ","); // Field Bayar_Total
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJSON(), ","); // Field Keterangan
		$sFilterList = ew_Concat($sFilterList, $this->Periode->AdvancedSearch->ToJSON(), ","); // Field Periode
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft0302_angsuranlistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field pinjaman_id
		$this->pinjaman_id->AdvancedSearch->SearchValue = @$filter["x_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchOperator = @$filter["z_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchCondition = @$filter["v_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchValue2 = @$filter["y_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchOperator2 = @$filter["w_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->Save();

		// Field Angsuran_Ke
		$this->Angsuran_Ke->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Ke"];
		$this->Angsuran_Ke->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Ke"];
		$this->Angsuran_Ke->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Ke"];
		$this->Angsuran_Ke->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Ke"];
		$this->Angsuran_Ke->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Ke"];
		$this->Angsuran_Ke->AdvancedSearch->Save();

		// Field Angsuran_Tanggal
		$this->Angsuran_Tanggal->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Tanggal"];
		$this->Angsuran_Tanggal->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Tanggal"];
		$this->Angsuran_Tanggal->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Tanggal"];
		$this->Angsuran_Tanggal->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Tanggal"];
		$this->Angsuran_Tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Tanggal"];
		$this->Angsuran_Tanggal->AdvancedSearch->Save();

		// Field Angsuran_Pokok
		$this->Angsuran_Pokok->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Pokok"];
		$this->Angsuran_Pokok->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Pokok"];
		$this->Angsuran_Pokok->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Pokok"];
		$this->Angsuran_Pokok->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Pokok"];
		$this->Angsuran_Pokok->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Pokok"];
		$this->Angsuran_Pokok->AdvancedSearch->Save();

		// Field Angsuran_Bunga
		$this->Angsuran_Bunga->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Bunga"];
		$this->Angsuran_Bunga->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Bunga"];
		$this->Angsuran_Bunga->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Bunga"];
		$this->Angsuran_Bunga->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Bunga"];
		$this->Angsuran_Bunga->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Bunga"];
		$this->Angsuran_Bunga->AdvancedSearch->Save();

		// Field Angsuran_Total
		$this->Angsuran_Total->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Total"];
		$this->Angsuran_Total->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Total"];
		$this->Angsuran_Total->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Total"];
		$this->Angsuran_Total->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Total"];
		$this->Angsuran_Total->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Total"];
		$this->Angsuran_Total->AdvancedSearch->Save();

		// Field Sisa_Hutang
		$this->Sisa_Hutang->AdvancedSearch->SearchValue = @$filter["x_Sisa_Hutang"];
		$this->Sisa_Hutang->AdvancedSearch->SearchOperator = @$filter["z_Sisa_Hutang"];
		$this->Sisa_Hutang->AdvancedSearch->SearchCondition = @$filter["v_Sisa_Hutang"];
		$this->Sisa_Hutang->AdvancedSearch->SearchValue2 = @$filter["y_Sisa_Hutang"];
		$this->Sisa_Hutang->AdvancedSearch->SearchOperator2 = @$filter["w_Sisa_Hutang"];
		$this->Sisa_Hutang->AdvancedSearch->Save();

		// Field Tanggal_Bayar
		$this->Tanggal_Bayar->AdvancedSearch->SearchValue = @$filter["x_Tanggal_Bayar"];
		$this->Tanggal_Bayar->AdvancedSearch->SearchOperator = @$filter["z_Tanggal_Bayar"];
		$this->Tanggal_Bayar->AdvancedSearch->SearchCondition = @$filter["v_Tanggal_Bayar"];
		$this->Tanggal_Bayar->AdvancedSearch->SearchValue2 = @$filter["y_Tanggal_Bayar"];
		$this->Tanggal_Bayar->AdvancedSearch->SearchOperator2 = @$filter["w_Tanggal_Bayar"];
		$this->Tanggal_Bayar->AdvancedSearch->Save();

		// Field Terlambat
		$this->Terlambat->AdvancedSearch->SearchValue = @$filter["x_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchOperator = @$filter["z_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchCondition = @$filter["v_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchValue2 = @$filter["y_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchOperator2 = @$filter["w_Terlambat"];
		$this->Terlambat->AdvancedSearch->Save();

		// Field Total_Denda
		$this->Total_Denda->AdvancedSearch->SearchValue = @$filter["x_Total_Denda"];
		$this->Total_Denda->AdvancedSearch->SearchOperator = @$filter["z_Total_Denda"];
		$this->Total_Denda->AdvancedSearch->SearchCondition = @$filter["v_Total_Denda"];
		$this->Total_Denda->AdvancedSearch->SearchValue2 = @$filter["y_Total_Denda"];
		$this->Total_Denda->AdvancedSearch->SearchOperator2 = @$filter["w_Total_Denda"];
		$this->Total_Denda->AdvancedSearch->Save();

		// Field Bayar_Titipan
		$this->Bayar_Titipan->AdvancedSearch->SearchValue = @$filter["x_Bayar_Titipan"];
		$this->Bayar_Titipan->AdvancedSearch->SearchOperator = @$filter["z_Bayar_Titipan"];
		$this->Bayar_Titipan->AdvancedSearch->SearchCondition = @$filter["v_Bayar_Titipan"];
		$this->Bayar_Titipan->AdvancedSearch->SearchValue2 = @$filter["y_Bayar_Titipan"];
		$this->Bayar_Titipan->AdvancedSearch->SearchOperator2 = @$filter["w_Bayar_Titipan"];
		$this->Bayar_Titipan->AdvancedSearch->Save();

		// Field Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->AdvancedSearch->SearchValue = @$filter["x_Bayar_Non_Titipan"];
		$this->Bayar_Non_Titipan->AdvancedSearch->SearchOperator = @$filter["z_Bayar_Non_Titipan"];
		$this->Bayar_Non_Titipan->AdvancedSearch->SearchCondition = @$filter["v_Bayar_Non_Titipan"];
		$this->Bayar_Non_Titipan->AdvancedSearch->SearchValue2 = @$filter["y_Bayar_Non_Titipan"];
		$this->Bayar_Non_Titipan->AdvancedSearch->SearchOperator2 = @$filter["w_Bayar_Non_Titipan"];
		$this->Bayar_Non_Titipan->AdvancedSearch->Save();

		// Field Bayar_Total
		$this->Bayar_Total->AdvancedSearch->SearchValue = @$filter["x_Bayar_Total"];
		$this->Bayar_Total->AdvancedSearch->SearchOperator = @$filter["z_Bayar_Total"];
		$this->Bayar_Total->AdvancedSearch->SearchCondition = @$filter["v_Bayar_Total"];
		$this->Bayar_Total->AdvancedSearch->SearchValue2 = @$filter["y_Bayar_Total"];
		$this->Bayar_Total->AdvancedSearch->SearchOperator2 = @$filter["w_Bayar_Total"];
		$this->Bayar_Total->AdvancedSearch->Save();

		// Field Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = @$filter["x_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator = @$filter["z_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchCondition = @$filter["v_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchValue2 = @$filter["y_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_Keterangan"];
		$this->Keterangan->AdvancedSearch->Save();

		// Field Periode
		$this->Periode->AdvancedSearch->SearchValue = @$filter["x_Periode"];
		$this->Periode->AdvancedSearch->SearchOperator = @$filter["z_Periode"];
		$this->Periode->AdvancedSearch->SearchCondition = @$filter["v_Periode"];
		$this->Periode->AdvancedSearch->SearchValue2 = @$filter["y_Periode"];
		$this->Periode->AdvancedSearch->SearchOperator2 = @$filter["w_Periode"];
		$this->Periode->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Keterangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Periode, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->pinjaman_id, $bCtrl); // pinjaman_id
			$this->UpdateSort($this->Angsuran_Ke, $bCtrl); // Angsuran_Ke
			$this->UpdateSort($this->Angsuran_Tanggal, $bCtrl); // Angsuran_Tanggal
			$this->UpdateSort($this->Angsuran_Pokok, $bCtrl); // Angsuran_Pokok
			$this->UpdateSort($this->Angsuran_Bunga, $bCtrl); // Angsuran_Bunga
			$this->UpdateSort($this->Angsuran_Total, $bCtrl); // Angsuran_Total
			$this->UpdateSort($this->Sisa_Hutang, $bCtrl); // Sisa_Hutang
			$this->UpdateSort($this->Tanggal_Bayar, $bCtrl); // Tanggal_Bayar
			$this->UpdateSort($this->Terlambat, $bCtrl); // Terlambat
			$this->UpdateSort($this->Total_Denda, $bCtrl); // Total_Denda
			$this->UpdateSort($this->Bayar_Titipan, $bCtrl); // Bayar_Titipan
			$this->UpdateSort($this->Bayar_Non_Titipan, $bCtrl); // Bayar_Non_Titipan
			$this->UpdateSort($this->Bayar_Total, $bCtrl); // Bayar_Total
			$this->UpdateSort($this->Periode, $bCtrl); // Periode
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->pinjaman_id->setSort("");
				$this->Angsuran_Ke->setSort("");
				$this->Angsuran_Tanggal->setSort("");
				$this->Angsuran_Pokok->setSort("");
				$this->Angsuran_Bunga->setSort("");
				$this->Angsuran_Total->setSort("");
				$this->Sisa_Hutang->setSort("");
				$this->Tanggal_Bayar->setSort("");
				$this->Terlambat->setSort("");
				$this->Total_Denda->setSort("");
				$this->Bayar_Titipan->setSort("");
				$this->Bayar_Non_Titipan->setSort("");
				$this->Bayar_Total->setSort("");
				$this->Periode->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft0302_angsuranlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft0302_angsuranlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft0302_angsuranlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft0302_angsuranlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pinjaman_id->DbValue = $row['pinjaman_id'];
		$this->Angsuran_Ke->DbValue = $row['Angsuran_Ke'];
		$this->Angsuran_Tanggal->DbValue = $row['Angsuran_Tanggal'];
		$this->Angsuran_Pokok->DbValue = $row['Angsuran_Pokok'];
		$this->Angsuran_Bunga->DbValue = $row['Angsuran_Bunga'];
		$this->Angsuran_Total->DbValue = $row['Angsuran_Total'];
		$this->Sisa_Hutang->DbValue = $row['Sisa_Hutang'];
		$this->Tanggal_Bayar->DbValue = $row['Tanggal_Bayar'];
		$this->Terlambat->DbValue = $row['Terlambat'];
		$this->Total_Denda->DbValue = $row['Total_Denda'];
		$this->Bayar_Titipan->DbValue = $row['Bayar_Titipan'];
		$this->Bayar_Non_Titipan->DbValue = $row['Bayar_Non_Titipan'];
		$this->Bayar_Total->DbValue = $row['Bayar_Total'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Periode->DbValue = $row['Periode'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->Angsuran_Pokok->FormValue == $this->Angsuran_Pokok->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Pokok->CurrentValue)))
			$this->Angsuran_Pokok->CurrentValue = ew_StrToFloat($this->Angsuran_Pokok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Bunga->FormValue == $this->Angsuran_Bunga->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Bunga->CurrentValue)))
			$this->Angsuran_Bunga->CurrentValue = ew_StrToFloat($this->Angsuran_Bunga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Total->FormValue == $this->Angsuran_Total->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Total->CurrentValue)))
			$this->Angsuran_Total->CurrentValue = ew_StrToFloat($this->Angsuran_Total->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa_Hutang->FormValue == $this->Sisa_Hutang->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa_Hutang->CurrentValue)))
			$this->Sisa_Hutang->CurrentValue = ew_StrToFloat($this->Sisa_Hutang->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Total_Denda->FormValue == $this->Total_Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Total_Denda->CurrentValue)))
			$this->Total_Denda->CurrentValue = ew_StrToFloat($this->Total_Denda->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Titipan->FormValue == $this->Bayar_Titipan->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Titipan->CurrentValue)))
			$this->Bayar_Titipan->CurrentValue = ew_StrToFloat($this->Bayar_Titipan->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Non_Titipan->FormValue == $this->Bayar_Non_Titipan->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Non_Titipan->CurrentValue)))
			$this->Bayar_Non_Titipan->CurrentValue = ew_StrToFloat($this->Bayar_Non_Titipan->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Total->FormValue == $this->Bayar_Total->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Total->CurrentValue)))
			$this->Bayar_Total->CurrentValue = ew_StrToFloat($this->Bayar_Total->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// Periode
			$this->Periode->LinkCustomAttributes = "";
			$this->Periode->HrefValue = "";
			$this->Periode->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t0302_angsuran_list)) $t0302_angsuran_list = new ct0302_angsuran_list();

// Page init
$t0302_angsuran_list->Page_Init();

// Page main
$t0302_angsuran_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0302_angsuran_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft0302_angsuranlist = new ew_Form("ft0302_angsuranlist", "list");
ft0302_angsuranlist.FormKeyCountName = '<?php echo $t0302_angsuran_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft0302_angsuranlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0302_angsuranlist.ValidateRequired = true;
<?php } else { ?>
ft0302_angsuranlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft0302_angsuranlistsrch = new ew_Form("ft0302_angsuranlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($t0302_angsuran_list->TotalRecs > 0 && $t0302_angsuran_list->ExportOptions->Visible()) { ?>
<?php $t0302_angsuran_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t0302_angsuran_list->SearchOptions->Visible()) { ?>
<?php $t0302_angsuran_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t0302_angsuran_list->FilterOptions->Visible()) { ?>
<?php $t0302_angsuran_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t0302_angsuran_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t0302_angsuran_list->TotalRecs <= 0)
			$t0302_angsuran_list->TotalRecs = $t0302_angsuran->SelectRecordCount();
	} else {
		if (!$t0302_angsuran_list->Recordset && ($t0302_angsuran_list->Recordset = $t0302_angsuran_list->LoadRecordset()))
			$t0302_angsuran_list->TotalRecs = $t0302_angsuran_list->Recordset->RecordCount();
	}
	$t0302_angsuran_list->StartRec = 1;
	if ($t0302_angsuran_list->DisplayRecs <= 0 || ($t0302_angsuran->Export <> "" && $t0302_angsuran->ExportAll)) // Display all records
		$t0302_angsuran_list->DisplayRecs = $t0302_angsuran_list->TotalRecs;
	if (!($t0302_angsuran->Export <> "" && $t0302_angsuran->ExportAll))
		$t0302_angsuran_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t0302_angsuran_list->Recordset = $t0302_angsuran_list->LoadRecordset($t0302_angsuran_list->StartRec-1, $t0302_angsuran_list->DisplayRecs);

	// Set no record found message
	if ($t0302_angsuran->CurrentAction == "" && $t0302_angsuran_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t0302_angsuran_list->setWarningMessage(ew_DeniedMsg());
		if ($t0302_angsuran_list->SearchWhere == "0=101")
			$t0302_angsuran_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t0302_angsuran_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t0302_angsuran_list->AuditTrailOnSearch && $t0302_angsuran_list->Command == "search" && !$t0302_angsuran_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t0302_angsuran_list->getSessionWhere();
		$t0302_angsuran_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$t0302_angsuran_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t0302_angsuran->Export == "" && $t0302_angsuran->CurrentAction == "") { ?>
<form name="ft0302_angsuranlistsrch" id="ft0302_angsuranlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t0302_angsuran_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft0302_angsuranlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t0302_angsuran">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t0302_angsuran_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t0302_angsuran_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t0302_angsuran_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t0302_angsuran_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t0302_angsuran_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t0302_angsuran_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t0302_angsuran_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t0302_angsuran_list->ShowPageHeader(); ?>
<?php
$t0302_angsuran_list->ShowMessage();
?>
<?php if ($t0302_angsuran_list->TotalRecs > 0 || $t0302_angsuran->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t0302_angsuran">
<form name="ft0302_angsuranlist" id="ft0302_angsuranlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0302_angsuran_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0302_angsuran_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0302_angsuran">
<div id="gmp_t0302_angsuran" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t0302_angsuran_list->TotalRecs > 0 || $t0302_angsuran->CurrentAction == "gridedit") { ?>
<table id="tbl_t0302_angsuranlist" class="table ewTable">
<?php echo $t0302_angsuran->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t0302_angsuran_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t0302_angsuran_list->RenderListOptions();

// Render list options (header, left)
$t0302_angsuran_list->ListOptions->Render("header", "left");
?>
<?php if ($t0302_angsuran->id->Visible) { // id ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->id) == "") { ?>
		<th data-name="id"><div id="elh_t0302_angsuran_id" class="t0302_angsuran_id"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->id) ?>',2);"><div id="elh_t0302_angsuran_id" class="t0302_angsuran_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->pinjaman_id->Visible) { // pinjaman_id ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->pinjaman_id) == "") { ?>
		<th data-name="pinjaman_id"><div id="elh_t0302_angsuran_pinjaman_id" class="t0302_angsuran_pinjaman_id"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->pinjaman_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pinjaman_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->pinjaman_id) ?>',2);"><div id="elh_t0302_angsuran_pinjaman_id" class="t0302_angsuran_pinjaman_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->pinjaman_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->pinjaman_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->pinjaman_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Angsuran_Ke->Visible) { // Angsuran_Ke ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Ke) == "") { ?>
		<th data-name="Angsuran_Ke"><div id="elh_t0302_angsuran_Angsuran_Ke" class="t0302_angsuran_Angsuran_Ke"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Ke->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Ke"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Ke) ?>',2);"><div id="elh_t0302_angsuran_Angsuran_Ke" class="t0302_angsuran_Angsuran_Ke">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Ke->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Angsuran_Ke->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Angsuran_Ke->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Angsuran_Tanggal->Visible) { // Angsuran_Tanggal ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Tanggal) == "") { ?>
		<th data-name="Angsuran_Tanggal"><div id="elh_t0302_angsuran_Angsuran_Tanggal" class="t0302_angsuran_Angsuran_Tanggal"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Tanggal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Tanggal) ?>',2);"><div id="elh_t0302_angsuran_Angsuran_Tanggal" class="t0302_angsuran_Angsuran_Tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Angsuran_Tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Angsuran_Tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Pokok) == "") { ?>
		<th data-name="Angsuran_Pokok"><div id="elh_t0302_angsuran_Angsuran_Pokok" class="t0302_angsuran_Angsuran_Pokok"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Pokok->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Pokok"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Pokok) ?>',2);"><div id="elh_t0302_angsuran_Angsuran_Pokok" class="t0302_angsuran_Angsuran_Pokok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Pokok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Angsuran_Pokok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Angsuran_Pokok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Bunga) == "") { ?>
		<th data-name="Angsuran_Bunga"><div id="elh_t0302_angsuran_Angsuran_Bunga" class="t0302_angsuran_Angsuran_Bunga"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Bunga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Bunga"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Bunga) ?>',2);"><div id="elh_t0302_angsuran_Angsuran_Bunga" class="t0302_angsuran_Angsuran_Bunga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Bunga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Angsuran_Bunga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Angsuran_Bunga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Angsuran_Total->Visible) { // Angsuran_Total ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Total) == "") { ?>
		<th data-name="Angsuran_Total"><div id="elh_t0302_angsuran_Angsuran_Total" class="t0302_angsuran_Angsuran_Total"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Total"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Angsuran_Total) ?>',2);"><div id="elh_t0302_angsuran_Angsuran_Total" class="t0302_angsuran_Angsuran_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Angsuran_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Angsuran_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Angsuran_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Sisa_Hutang->Visible) { // Sisa_Hutang ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Sisa_Hutang) == "") { ?>
		<th data-name="Sisa_Hutang"><div id="elh_t0302_angsuran_Sisa_Hutang" class="t0302_angsuran_Sisa_Hutang"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Sisa_Hutang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sisa_Hutang"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Sisa_Hutang) ?>',2);"><div id="elh_t0302_angsuran_Sisa_Hutang" class="t0302_angsuran_Sisa_Hutang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Sisa_Hutang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Sisa_Hutang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Sisa_Hutang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Tanggal_Bayar) == "") { ?>
		<th data-name="Tanggal_Bayar"><div id="elh_t0302_angsuran_Tanggal_Bayar" class="t0302_angsuran_Tanggal_Bayar"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Tanggal_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal_Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Tanggal_Bayar) ?>',2);"><div id="elh_t0302_angsuran_Tanggal_Bayar" class="t0302_angsuran_Tanggal_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Tanggal_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Tanggal_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Tanggal_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Terlambat->Visible) { // Terlambat ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Terlambat) == "") { ?>
		<th data-name="Terlambat"><div id="elh_t0302_angsuran_Terlambat" class="t0302_angsuran_Terlambat"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Terlambat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Terlambat"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Terlambat) ?>',2);"><div id="elh_t0302_angsuran_Terlambat" class="t0302_angsuran_Terlambat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Terlambat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Terlambat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Terlambat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Total_Denda->Visible) { // Total_Denda ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Total_Denda) == "") { ?>
		<th data-name="Total_Denda"><div id="elh_t0302_angsuran_Total_Denda" class="t0302_angsuran_Total_Denda"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Total_Denda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Denda"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Total_Denda) ?>',2);"><div id="elh_t0302_angsuran_Total_Denda" class="t0302_angsuran_Total_Denda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Total_Denda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Total_Denda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Total_Denda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Bayar_Titipan->Visible) { // Bayar_Titipan ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Titipan) == "") { ?>
		<th data-name="Bayar_Titipan"><div id="elh_t0302_angsuran_Bayar_Titipan" class="t0302_angsuran_Bayar_Titipan"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Titipan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bayar_Titipan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Titipan) ?>',2);"><div id="elh_t0302_angsuran_Bayar_Titipan" class="t0302_angsuran_Bayar_Titipan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Titipan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Bayar_Titipan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Bayar_Titipan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Bayar_Non_Titipan->Visible) { // Bayar_Non_Titipan ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Non_Titipan) == "") { ?>
		<th data-name="Bayar_Non_Titipan"><div id="elh_t0302_angsuran_Bayar_Non_Titipan" class="t0302_angsuran_Bayar_Non_Titipan"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Non_Titipan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bayar_Non_Titipan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Non_Titipan) ?>',2);"><div id="elh_t0302_angsuran_Bayar_Non_Titipan" class="t0302_angsuran_Bayar_Non_Titipan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Non_Titipan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Bayar_Non_Titipan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Bayar_Non_Titipan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Bayar_Total->Visible) { // Bayar_Total ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Total) == "") { ?>
		<th data-name="Bayar_Total"><div id="elh_t0302_angsuran_Bayar_Total" class="t0302_angsuran_Bayar_Total"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bayar_Total"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Bayar_Total) ?>',2);"><div id="elh_t0302_angsuran_Bayar_Total" class="t0302_angsuran_Bayar_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Bayar_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Bayar_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Bayar_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0302_angsuran->Periode->Visible) { // Periode ?>
	<?php if ($t0302_angsuran->SortUrl($t0302_angsuran->Periode) == "") { ?>
		<th data-name="Periode"><div id="elh_t0302_angsuran_Periode" class="t0302_angsuran_Periode"><div class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Periode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0302_angsuran->SortUrl($t0302_angsuran->Periode) ?>',2);"><div id="elh_t0302_angsuran_Periode" class="t0302_angsuran_Periode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0302_angsuran->Periode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t0302_angsuran->Periode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0302_angsuran->Periode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t0302_angsuran_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t0302_angsuran->ExportAll && $t0302_angsuran->Export <> "") {
	$t0302_angsuran_list->StopRec = $t0302_angsuran_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t0302_angsuran_list->TotalRecs > $t0302_angsuran_list->StartRec + $t0302_angsuran_list->DisplayRecs - 1)
		$t0302_angsuran_list->StopRec = $t0302_angsuran_list->StartRec + $t0302_angsuran_list->DisplayRecs - 1;
	else
		$t0302_angsuran_list->StopRec = $t0302_angsuran_list->TotalRecs;
}
$t0302_angsuran_list->RecCnt = $t0302_angsuran_list->StartRec - 1;
if ($t0302_angsuran_list->Recordset && !$t0302_angsuran_list->Recordset->EOF) {
	$t0302_angsuran_list->Recordset->MoveFirst();
	$bSelectLimit = $t0302_angsuran_list->UseSelectLimit;
	if (!$bSelectLimit && $t0302_angsuran_list->StartRec > 1)
		$t0302_angsuran_list->Recordset->Move($t0302_angsuran_list->StartRec - 1);
} elseif (!$t0302_angsuran->AllowAddDeleteRow && $t0302_angsuran_list->StopRec == 0) {
	$t0302_angsuran_list->StopRec = $t0302_angsuran->GridAddRowCount;
}

// Initialize aggregate
$t0302_angsuran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t0302_angsuran->ResetAttrs();
$t0302_angsuran_list->RenderRow();
while ($t0302_angsuran_list->RecCnt < $t0302_angsuran_list->StopRec) {
	$t0302_angsuran_list->RecCnt++;
	if (intval($t0302_angsuran_list->RecCnt) >= intval($t0302_angsuran_list->StartRec)) {
		$t0302_angsuran_list->RowCnt++;

		// Set up key count
		$t0302_angsuran_list->KeyCount = $t0302_angsuran_list->RowIndex;

		// Init row class and style
		$t0302_angsuran->ResetAttrs();
		$t0302_angsuran->CssClass = "";
		if ($t0302_angsuran->CurrentAction == "gridadd") {
		} else {
			$t0302_angsuran_list->LoadRowValues($t0302_angsuran_list->Recordset); // Load row values
		}
		$t0302_angsuran->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t0302_angsuran->RowAttrs = array_merge($t0302_angsuran->RowAttrs, array('data-rowindex'=>$t0302_angsuran_list->RowCnt, 'id'=>'r' . $t0302_angsuran_list->RowCnt . '_t0302_angsuran', 'data-rowtype'=>$t0302_angsuran->RowType));

		// Render row
		$t0302_angsuran_list->RenderRow();

		// Render list options
		$t0302_angsuran_list->RenderListOptions();
?>
	<tr<?php echo $t0302_angsuran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t0302_angsuran_list->ListOptions->Render("body", "left", $t0302_angsuran_list->RowCnt);
?>
	<?php if ($t0302_angsuran->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t0302_angsuran->id->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_id" class="t0302_angsuran_id">
<span<?php echo $t0302_angsuran->id->ViewAttributes() ?>>
<?php echo $t0302_angsuran->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $t0302_angsuran_list->PageObjName . "_row_" . $t0302_angsuran_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t0302_angsuran->pinjaman_id->Visible) { // pinjaman_id ?>
		<td data-name="pinjaman_id"<?php echo $t0302_angsuran->pinjaman_id->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_pinjaman_id" class="t0302_angsuran_pinjaman_id">
<span<?php echo $t0302_angsuran->pinjaman_id->ViewAttributes() ?>>
<?php echo $t0302_angsuran->pinjaman_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Angsuran_Ke->Visible) { // Angsuran_Ke ?>
		<td data-name="Angsuran_Ke"<?php echo $t0302_angsuran->Angsuran_Ke->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Angsuran_Ke" class="t0302_angsuran_Angsuran_Ke">
<span<?php echo $t0302_angsuran->Angsuran_Ke->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Angsuran_Ke->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Angsuran_Tanggal->Visible) { // Angsuran_Tanggal ?>
		<td data-name="Angsuran_Tanggal"<?php echo $t0302_angsuran->Angsuran_Tanggal->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Angsuran_Tanggal" class="t0302_angsuran_Angsuran_Tanggal">
<span<?php echo $t0302_angsuran->Angsuran_Tanggal->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Angsuran_Tanggal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
		<td data-name="Angsuran_Pokok"<?php echo $t0302_angsuran->Angsuran_Pokok->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Angsuran_Pokok" class="t0302_angsuran_Angsuran_Pokok">
<span<?php echo $t0302_angsuran->Angsuran_Pokok->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Angsuran_Pokok->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
		<td data-name="Angsuran_Bunga"<?php echo $t0302_angsuran->Angsuran_Bunga->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Angsuran_Bunga" class="t0302_angsuran_Angsuran_Bunga">
<span<?php echo $t0302_angsuran->Angsuran_Bunga->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Angsuran_Bunga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Angsuran_Total->Visible) { // Angsuran_Total ?>
		<td data-name="Angsuran_Total"<?php echo $t0302_angsuran->Angsuran_Total->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Angsuran_Total" class="t0302_angsuran_Angsuran_Total">
<span<?php echo $t0302_angsuran->Angsuran_Total->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Angsuran_Total->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Sisa_Hutang->Visible) { // Sisa_Hutang ?>
		<td data-name="Sisa_Hutang"<?php echo $t0302_angsuran->Sisa_Hutang->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Sisa_Hutang" class="t0302_angsuran_Sisa_Hutang">
<span<?php echo $t0302_angsuran->Sisa_Hutang->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Sisa_Hutang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar"<?php echo $t0302_angsuran->Tanggal_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Tanggal_Bayar" class="t0302_angsuran_Tanggal_Bayar">
<span<?php echo $t0302_angsuran->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Tanggal_Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Terlambat->Visible) { // Terlambat ?>
		<td data-name="Terlambat"<?php echo $t0302_angsuran->Terlambat->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Terlambat" class="t0302_angsuran_Terlambat">
<span<?php echo $t0302_angsuran->Terlambat->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Terlambat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Total_Denda->Visible) { // Total_Denda ?>
		<td data-name="Total_Denda"<?php echo $t0302_angsuran->Total_Denda->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Total_Denda" class="t0302_angsuran_Total_Denda">
<span<?php echo $t0302_angsuran->Total_Denda->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Total_Denda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Bayar_Titipan->Visible) { // Bayar_Titipan ?>
		<td data-name="Bayar_Titipan"<?php echo $t0302_angsuran->Bayar_Titipan->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Bayar_Titipan" class="t0302_angsuran_Bayar_Titipan">
<span<?php echo $t0302_angsuran->Bayar_Titipan->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Bayar_Titipan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Bayar_Non_Titipan->Visible) { // Bayar_Non_Titipan ?>
		<td data-name="Bayar_Non_Titipan"<?php echo $t0302_angsuran->Bayar_Non_Titipan->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Bayar_Non_Titipan" class="t0302_angsuran_Bayar_Non_Titipan">
<span<?php echo $t0302_angsuran->Bayar_Non_Titipan->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Bayar_Non_Titipan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Bayar_Total->Visible) { // Bayar_Total ?>
		<td data-name="Bayar_Total"<?php echo $t0302_angsuran->Bayar_Total->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Bayar_Total" class="t0302_angsuran_Bayar_Total">
<span<?php echo $t0302_angsuran->Bayar_Total->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Bayar_Total->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0302_angsuran->Periode->Visible) { // Periode ?>
		<td data-name="Periode"<?php echo $t0302_angsuran->Periode->CellAttributes() ?>>
<span id="el<?php echo $t0302_angsuran_list->RowCnt ?>_t0302_angsuran_Periode" class="t0302_angsuran_Periode">
<span<?php echo $t0302_angsuran->Periode->ViewAttributes() ?>>
<?php echo $t0302_angsuran->Periode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t0302_angsuran_list->ListOptions->Render("body", "right", $t0302_angsuran_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t0302_angsuran->CurrentAction <> "gridadd")
		$t0302_angsuran_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t0302_angsuran->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t0302_angsuran_list->Recordset)
	$t0302_angsuran_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t0302_angsuran->CurrentAction <> "gridadd" && $t0302_angsuran->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t0302_angsuran_list->Pager)) $t0302_angsuran_list->Pager = new cPrevNextPager($t0302_angsuran_list->StartRec, $t0302_angsuran_list->DisplayRecs, $t0302_angsuran_list->TotalRecs) ?>
<?php if ($t0302_angsuran_list->Pager->RecordCount > 0 && $t0302_angsuran_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t0302_angsuran_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t0302_angsuran_list->PageUrl() ?>start=<?php echo $t0302_angsuran_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t0302_angsuran_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t0302_angsuran_list->PageUrl() ?>start=<?php echo $t0302_angsuran_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t0302_angsuran_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t0302_angsuran_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t0302_angsuran_list->PageUrl() ?>start=<?php echo $t0302_angsuran_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t0302_angsuran_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t0302_angsuran_list->PageUrl() ?>start=<?php echo $t0302_angsuran_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t0302_angsuran_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t0302_angsuran_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t0302_angsuran_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t0302_angsuran_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t0302_angsuran_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t0302_angsuran_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t0302_angsuran">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t0302_angsuran_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t0302_angsuran_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t0302_angsuran_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t0302_angsuran_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t0302_angsuran->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t0302_angsuran_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t0302_angsuran_list->TotalRecs == 0 && $t0302_angsuran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t0302_angsuran_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft0302_angsuranlistsrch.FilterList = <?php echo $t0302_angsuran_list->GetFilterList() ?>;
ft0302_angsuranlistsrch.Init();
ft0302_angsuranlist.Init();
</script>
<?php
$t0302_angsuran_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0302_angsuran_list->Page_Terminate();
?>
