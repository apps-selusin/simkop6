<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t0301_pinjamaninfo.php" ?>
<?php include_once "t9901_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t0301_pinjaman_list = NULL; // Initialize page object first

class ct0301_pinjaman_list extends ct0301_pinjaman {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{723112A7-6795-416E-B2AF-D90AA7A8CCFB}";

	// Table name
	var $TableName = 't0301_pinjaman';

	// Page object name
	var $PageObjName = 't0301_pinjaman_list';

	// Grid form hidden field names
	var $FormName = 'ft0301_pinjamanlist';
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

		// Table object (t0301_pinjaman)
		if (!isset($GLOBALS["t0301_pinjaman"]) || get_class($GLOBALS["t0301_pinjaman"]) == "ct0301_pinjaman") {
			$GLOBALS["t0301_pinjaman"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t0301_pinjaman"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t0301_pinjamanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t0301_pinjamandelete.php";
		$this->MultiUpdateUrl = "t0301_pinjamanupdate.php";

		// Table object (t9901_employees)
		if (!isset($GLOBALS['t9901_employees'])) $GLOBALS['t9901_employees'] = new ct9901_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't0301_pinjaman', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft0301_pinjamanlistsrch";

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
		$this->Kontrak_No->SetVisibility();
		$this->Kontrak_Tgl->SetVisibility();
		$this->nasabah_id->SetVisibility();
		$this->jaminan_id->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->Angsuran_Lama->SetVisibility();
		$this->Angsuran_Bunga_Prosen->SetVisibility();
		$this->Angsuran_Denda->SetVisibility();
		$this->Dispensasi_Denda->SetVisibility();
		$this->Angsuran_Pokok->SetVisibility();
		$this->Angsuran_Bunga->SetVisibility();
		$this->Angsuran_Total->SetVisibility();
		$this->No_Ref->SetVisibility();
		$this->Biaya_Administrasi->SetVisibility();
		$this->Biaya_Materai->SetVisibility();
		$this->marketing_id->SetVisibility();
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
		global $EW_EXPORT, $t0301_pinjaman;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t0301_pinjaman);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft0301_pinjamanlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->Kontrak_No->AdvancedSearch->ToJSON(), ","); // Field Kontrak_No
		$sFilterList = ew_Concat($sFilterList, $this->Kontrak_Tgl->AdvancedSearch->ToJSON(), ","); // Field Kontrak_Tgl
		$sFilterList = ew_Concat($sFilterList, $this->nasabah_id->AdvancedSearch->ToJSON(), ","); // Field nasabah_id
		$sFilterList = ew_Concat($sFilterList, $this->jaminan_id->AdvancedSearch->ToJSON(), ","); // Field jaminan_id
		$sFilterList = ew_Concat($sFilterList, $this->Pinjaman->AdvancedSearch->ToJSON(), ","); // Field Pinjaman
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Lama->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Lama
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Bunga_Prosen->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Bunga_Prosen
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Denda->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Denda
		$sFilterList = ew_Concat($sFilterList, $this->Dispensasi_Denda->AdvancedSearch->ToJSON(), ","); // Field Dispensasi_Denda
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Pokok->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Pokok
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Bunga->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Bunga
		$sFilterList = ew_Concat($sFilterList, $this->Angsuran_Total->AdvancedSearch->ToJSON(), ","); // Field Angsuran_Total
		$sFilterList = ew_Concat($sFilterList, $this->No_Ref->AdvancedSearch->ToJSON(), ","); // Field No_Ref
		$sFilterList = ew_Concat($sFilterList, $this->Biaya_Administrasi->AdvancedSearch->ToJSON(), ","); // Field Biaya_Administrasi
		$sFilterList = ew_Concat($sFilterList, $this->Biaya_Materai->AdvancedSearch->ToJSON(), ","); // Field Biaya_Materai
		$sFilterList = ew_Concat($sFilterList, $this->marketing_id->AdvancedSearch->ToJSON(), ","); // Field marketing_id
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft0301_pinjamanlistsrch", $filters);

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

		// Field Kontrak_No
		$this->Kontrak_No->AdvancedSearch->SearchValue = @$filter["x_Kontrak_No"];
		$this->Kontrak_No->AdvancedSearch->SearchOperator = @$filter["z_Kontrak_No"];
		$this->Kontrak_No->AdvancedSearch->SearchCondition = @$filter["v_Kontrak_No"];
		$this->Kontrak_No->AdvancedSearch->SearchValue2 = @$filter["y_Kontrak_No"];
		$this->Kontrak_No->AdvancedSearch->SearchOperator2 = @$filter["w_Kontrak_No"];
		$this->Kontrak_No->AdvancedSearch->Save();

		// Field Kontrak_Tgl
		$this->Kontrak_Tgl->AdvancedSearch->SearchValue = @$filter["x_Kontrak_Tgl"];
		$this->Kontrak_Tgl->AdvancedSearch->SearchOperator = @$filter["z_Kontrak_Tgl"];
		$this->Kontrak_Tgl->AdvancedSearch->SearchCondition = @$filter["v_Kontrak_Tgl"];
		$this->Kontrak_Tgl->AdvancedSearch->SearchValue2 = @$filter["y_Kontrak_Tgl"];
		$this->Kontrak_Tgl->AdvancedSearch->SearchOperator2 = @$filter["w_Kontrak_Tgl"];
		$this->Kontrak_Tgl->AdvancedSearch->Save();

		// Field nasabah_id
		$this->nasabah_id->AdvancedSearch->SearchValue = @$filter["x_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchOperator = @$filter["z_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchCondition = @$filter["v_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchValue2 = @$filter["y_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchOperator2 = @$filter["w_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->Save();

		// Field jaminan_id
		$this->jaminan_id->AdvancedSearch->SearchValue = @$filter["x_jaminan_id"];
		$this->jaminan_id->AdvancedSearch->SearchOperator = @$filter["z_jaminan_id"];
		$this->jaminan_id->AdvancedSearch->SearchCondition = @$filter["v_jaminan_id"];
		$this->jaminan_id->AdvancedSearch->SearchValue2 = @$filter["y_jaminan_id"];
		$this->jaminan_id->AdvancedSearch->SearchOperator2 = @$filter["w_jaminan_id"];
		$this->jaminan_id->AdvancedSearch->Save();

		// Field Pinjaman
		$this->Pinjaman->AdvancedSearch->SearchValue = @$filter["x_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator = @$filter["z_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchCondition = @$filter["v_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchValue2 = @$filter["y_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator2 = @$filter["w_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->Save();

		// Field Angsuran_Lama
		$this->Angsuran_Lama->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Lama"];
		$this->Angsuran_Lama->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Lama"];
		$this->Angsuran_Lama->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Lama"];
		$this->Angsuran_Lama->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Lama"];
		$this->Angsuran_Lama->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Lama"];
		$this->Angsuran_Lama->AdvancedSearch->Save();

		// Field Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Bunga_Prosen"];
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Bunga_Prosen"];
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Bunga_Prosen"];
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Bunga_Prosen"];
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Bunga_Prosen"];
		$this->Angsuran_Bunga_Prosen->AdvancedSearch->Save();

		// Field Angsuran_Denda
		$this->Angsuran_Denda->AdvancedSearch->SearchValue = @$filter["x_Angsuran_Denda"];
		$this->Angsuran_Denda->AdvancedSearch->SearchOperator = @$filter["z_Angsuran_Denda"];
		$this->Angsuran_Denda->AdvancedSearch->SearchCondition = @$filter["v_Angsuran_Denda"];
		$this->Angsuran_Denda->AdvancedSearch->SearchValue2 = @$filter["y_Angsuran_Denda"];
		$this->Angsuran_Denda->AdvancedSearch->SearchOperator2 = @$filter["w_Angsuran_Denda"];
		$this->Angsuran_Denda->AdvancedSearch->Save();

		// Field Dispensasi_Denda
		$this->Dispensasi_Denda->AdvancedSearch->SearchValue = @$filter["x_Dispensasi_Denda"];
		$this->Dispensasi_Denda->AdvancedSearch->SearchOperator = @$filter["z_Dispensasi_Denda"];
		$this->Dispensasi_Denda->AdvancedSearch->SearchCondition = @$filter["v_Dispensasi_Denda"];
		$this->Dispensasi_Denda->AdvancedSearch->SearchValue2 = @$filter["y_Dispensasi_Denda"];
		$this->Dispensasi_Denda->AdvancedSearch->SearchOperator2 = @$filter["w_Dispensasi_Denda"];
		$this->Dispensasi_Denda->AdvancedSearch->Save();

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

		// Field No_Ref
		$this->No_Ref->AdvancedSearch->SearchValue = @$filter["x_No_Ref"];
		$this->No_Ref->AdvancedSearch->SearchOperator = @$filter["z_No_Ref"];
		$this->No_Ref->AdvancedSearch->SearchCondition = @$filter["v_No_Ref"];
		$this->No_Ref->AdvancedSearch->SearchValue2 = @$filter["y_No_Ref"];
		$this->No_Ref->AdvancedSearch->SearchOperator2 = @$filter["w_No_Ref"];
		$this->No_Ref->AdvancedSearch->Save();

		// Field Biaya_Administrasi
		$this->Biaya_Administrasi->AdvancedSearch->SearchValue = @$filter["x_Biaya_Administrasi"];
		$this->Biaya_Administrasi->AdvancedSearch->SearchOperator = @$filter["z_Biaya_Administrasi"];
		$this->Biaya_Administrasi->AdvancedSearch->SearchCondition = @$filter["v_Biaya_Administrasi"];
		$this->Biaya_Administrasi->AdvancedSearch->SearchValue2 = @$filter["y_Biaya_Administrasi"];
		$this->Biaya_Administrasi->AdvancedSearch->SearchOperator2 = @$filter["w_Biaya_Administrasi"];
		$this->Biaya_Administrasi->AdvancedSearch->Save();

		// Field Biaya_Materai
		$this->Biaya_Materai->AdvancedSearch->SearchValue = @$filter["x_Biaya_Materai"];
		$this->Biaya_Materai->AdvancedSearch->SearchOperator = @$filter["z_Biaya_Materai"];
		$this->Biaya_Materai->AdvancedSearch->SearchCondition = @$filter["v_Biaya_Materai"];
		$this->Biaya_Materai->AdvancedSearch->SearchValue2 = @$filter["y_Biaya_Materai"];
		$this->Biaya_Materai->AdvancedSearch->SearchOperator2 = @$filter["w_Biaya_Materai"];
		$this->Biaya_Materai->AdvancedSearch->Save();

		// Field marketing_id
		$this->marketing_id->AdvancedSearch->SearchValue = @$filter["x_marketing_id"];
		$this->marketing_id->AdvancedSearch->SearchOperator = @$filter["z_marketing_id"];
		$this->marketing_id->AdvancedSearch->SearchCondition = @$filter["v_marketing_id"];
		$this->marketing_id->AdvancedSearch->SearchValue2 = @$filter["y_marketing_id"];
		$this->marketing_id->AdvancedSearch->SearchOperator2 = @$filter["w_marketing_id"];
		$this->marketing_id->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->Kontrak_No, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jaminan_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->No_Ref, $arKeywords, $type);
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
			$this->UpdateSort($this->Kontrak_No, $bCtrl); // Kontrak_No
			$this->UpdateSort($this->Kontrak_Tgl, $bCtrl); // Kontrak_Tgl
			$this->UpdateSort($this->nasabah_id, $bCtrl); // nasabah_id
			$this->UpdateSort($this->jaminan_id, $bCtrl); // jaminan_id
			$this->UpdateSort($this->Pinjaman, $bCtrl); // Pinjaman
			$this->UpdateSort($this->Angsuran_Lama, $bCtrl); // Angsuran_Lama
			$this->UpdateSort($this->Angsuran_Bunga_Prosen, $bCtrl); // Angsuran_Bunga_Prosen
			$this->UpdateSort($this->Angsuran_Denda, $bCtrl); // Angsuran_Denda
			$this->UpdateSort($this->Dispensasi_Denda, $bCtrl); // Dispensasi_Denda
			$this->UpdateSort($this->Angsuran_Pokok, $bCtrl); // Angsuran_Pokok
			$this->UpdateSort($this->Angsuran_Bunga, $bCtrl); // Angsuran_Bunga
			$this->UpdateSort($this->Angsuran_Total, $bCtrl); // Angsuran_Total
			$this->UpdateSort($this->No_Ref, $bCtrl); // No_Ref
			$this->UpdateSort($this->Biaya_Administrasi, $bCtrl); // Biaya_Administrasi
			$this->UpdateSort($this->Biaya_Materai, $bCtrl); // Biaya_Materai
			$this->UpdateSort($this->marketing_id, $bCtrl); // marketing_id
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
				$this->Kontrak_No->setSort("");
				$this->Kontrak_Tgl->setSort("");
				$this->nasabah_id->setSort("");
				$this->jaminan_id->setSort("");
				$this->Pinjaman->setSort("");
				$this->Angsuran_Lama->setSort("");
				$this->Angsuran_Bunga_Prosen->setSort("");
				$this->Angsuran_Denda->setSort("");
				$this->Dispensasi_Denda->setSort("");
				$this->Angsuran_Pokok->setSort("");
				$this->Angsuran_Bunga->setSort("");
				$this->Angsuran_Total->setSort("");
				$this->No_Ref->setSort("");
				$this->Biaya_Administrasi->setSort("");
				$this->Biaya_Materai->setSort("");
				$this->marketing_id->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft0301_pinjamanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft0301_pinjamanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft0301_pinjamanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft0301_pinjamanlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->Kontrak_No->setDbValue($rs->fields('Kontrak_No'));
		$this->Kontrak_Tgl->setDbValue($rs->fields('Kontrak_Tgl'));
		$this->nasabah_id->setDbValue($rs->fields('nasabah_id'));
		$this->jaminan_id->setDbValue($rs->fields('jaminan_id'));
		$this->Pinjaman->setDbValue($rs->fields('Pinjaman'));
		$this->Angsuran_Lama->setDbValue($rs->fields('Angsuran_Lama'));
		$this->Angsuran_Bunga_Prosen->setDbValue($rs->fields('Angsuran_Bunga_Prosen'));
		$this->Angsuran_Denda->setDbValue($rs->fields('Angsuran_Denda'));
		$this->Dispensasi_Denda->setDbValue($rs->fields('Dispensasi_Denda'));
		$this->Angsuran_Pokok->setDbValue($rs->fields('Angsuran_Pokok'));
		$this->Angsuran_Bunga->setDbValue($rs->fields('Angsuran_Bunga'));
		$this->Angsuran_Total->setDbValue($rs->fields('Angsuran_Total'));
		$this->No_Ref->setDbValue($rs->fields('No_Ref'));
		$this->Biaya_Administrasi->setDbValue($rs->fields('Biaya_Administrasi'));
		$this->Biaya_Materai->setDbValue($rs->fields('Biaya_Materai'));
		$this->marketing_id->setDbValue($rs->fields('marketing_id'));
		$this->Periode->setDbValue($rs->fields('Periode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Kontrak_No->DbValue = $row['Kontrak_No'];
		$this->Kontrak_Tgl->DbValue = $row['Kontrak_Tgl'];
		$this->nasabah_id->DbValue = $row['nasabah_id'];
		$this->jaminan_id->DbValue = $row['jaminan_id'];
		$this->Pinjaman->DbValue = $row['Pinjaman'];
		$this->Angsuran_Lama->DbValue = $row['Angsuran_Lama'];
		$this->Angsuran_Bunga_Prosen->DbValue = $row['Angsuran_Bunga_Prosen'];
		$this->Angsuran_Denda->DbValue = $row['Angsuran_Denda'];
		$this->Dispensasi_Denda->DbValue = $row['Dispensasi_Denda'];
		$this->Angsuran_Pokok->DbValue = $row['Angsuran_Pokok'];
		$this->Angsuran_Bunga->DbValue = $row['Angsuran_Bunga'];
		$this->Angsuran_Total->DbValue = $row['Angsuran_Total'];
		$this->No_Ref->DbValue = $row['No_Ref'];
		$this->Biaya_Administrasi->DbValue = $row['Biaya_Administrasi'];
		$this->Biaya_Materai->DbValue = $row['Biaya_Materai'];
		$this->marketing_id->DbValue = $row['marketing_id'];
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
		if ($this->Pinjaman->FormValue == $this->Pinjaman->CurrentValue && is_numeric(ew_StrToFloat($this->Pinjaman->CurrentValue)))
			$this->Pinjaman->CurrentValue = ew_StrToFloat($this->Pinjaman->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Bunga_Prosen->FormValue == $this->Angsuran_Bunga_Prosen->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Bunga_Prosen->CurrentValue)))
			$this->Angsuran_Bunga_Prosen->CurrentValue = ew_StrToFloat($this->Angsuran_Bunga_Prosen->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Denda->FormValue == $this->Angsuran_Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Denda->CurrentValue)))
			$this->Angsuran_Denda->CurrentValue = ew_StrToFloat($this->Angsuran_Denda->CurrentValue);

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
		if ($this->Biaya_Administrasi->FormValue == $this->Biaya_Administrasi->CurrentValue && is_numeric(ew_StrToFloat($this->Biaya_Administrasi->CurrentValue)))
			$this->Biaya_Administrasi->CurrentValue = ew_StrToFloat($this->Biaya_Administrasi->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Biaya_Materai->FormValue == $this->Biaya_Materai->CurrentValue && is_numeric(ew_StrToFloat($this->Biaya_Materai->CurrentValue)))
			$this->Biaya_Materai->CurrentValue = ew_StrToFloat($this->Biaya_Materai->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Kontrak_No
		// Kontrak_Tgl
		// nasabah_id
		// jaminan_id
		// Pinjaman
		// Angsuran_Lama
		// Angsuran_Bunga_Prosen
		// Angsuran_Denda
		// Dispensasi_Denda
		// Angsuran_Pokok
		// Angsuran_Bunga
		// Angsuran_Total
		// No_Ref
		// Biaya_Administrasi
		// Biaya_Materai
		// marketing_id
		// Periode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Kontrak_No
		$this->Kontrak_No->ViewValue = $this->Kontrak_No->CurrentValue;
		$this->Kontrak_No->ViewCustomAttributes = "";

		// Kontrak_Tgl
		$this->Kontrak_Tgl->ViewValue = $this->Kontrak_Tgl->CurrentValue;
		$this->Kontrak_Tgl->ViewValue = ew_FormatDateTime($this->Kontrak_Tgl->ViewValue, 0);
		$this->Kontrak_Tgl->ViewCustomAttributes = "";

		// nasabah_id
		$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
		$this->nasabah_id->ViewCustomAttributes = "";

		// jaminan_id
		$this->jaminan_id->ViewValue = $this->jaminan_id->CurrentValue;
		$this->jaminan_id->ViewCustomAttributes = "";

		// Pinjaman
		$this->Pinjaman->ViewValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->ViewCustomAttributes = "";

		// Angsuran_Lama
		$this->Angsuran_Lama->ViewValue = $this->Angsuran_Lama->CurrentValue;
		$this->Angsuran_Lama->ViewCustomAttributes = "";

		// Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen->ViewValue = $this->Angsuran_Bunga_Prosen->CurrentValue;
		$this->Angsuran_Bunga_Prosen->ViewCustomAttributes = "";

		// Angsuran_Denda
		$this->Angsuran_Denda->ViewValue = $this->Angsuran_Denda->CurrentValue;
		$this->Angsuran_Denda->ViewCustomAttributes = "";

		// Dispensasi_Denda
		$this->Dispensasi_Denda->ViewValue = $this->Dispensasi_Denda->CurrentValue;
		$this->Dispensasi_Denda->ViewCustomAttributes = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->ViewValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->ViewCustomAttributes = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->ViewValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->ViewCustomAttributes = "";

		// Angsuran_Total
		$this->Angsuran_Total->ViewValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->ViewCustomAttributes = "";

		// No_Ref
		$this->No_Ref->ViewValue = $this->No_Ref->CurrentValue;
		$this->No_Ref->ViewCustomAttributes = "";

		// Biaya_Administrasi
		$this->Biaya_Administrasi->ViewValue = $this->Biaya_Administrasi->CurrentValue;
		$this->Biaya_Administrasi->ViewCustomAttributes = "";

		// Biaya_Materai
		$this->Biaya_Materai->ViewValue = $this->Biaya_Materai->CurrentValue;
		$this->Biaya_Materai->ViewCustomAttributes = "";

		// marketing_id
		$this->marketing_id->ViewValue = $this->marketing_id->CurrentValue;
		$this->marketing_id->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// Kontrak_No
			$this->Kontrak_No->LinkCustomAttributes = "";
			$this->Kontrak_No->HrefValue = "";
			$this->Kontrak_No->TooltipValue = "";

			// Kontrak_Tgl
			$this->Kontrak_Tgl->LinkCustomAttributes = "";
			$this->Kontrak_Tgl->HrefValue = "";
			$this->Kontrak_Tgl->TooltipValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";
			$this->nasabah_id->TooltipValue = "";

			// jaminan_id
			$this->jaminan_id->LinkCustomAttributes = "";
			$this->jaminan_id->HrefValue = "";
			$this->jaminan_id->TooltipValue = "";

			// Pinjaman
			$this->Pinjaman->LinkCustomAttributes = "";
			$this->Pinjaman->HrefValue = "";
			$this->Pinjaman->TooltipValue = "";

			// Angsuran_Lama
			$this->Angsuran_Lama->LinkCustomAttributes = "";
			$this->Angsuran_Lama->HrefValue = "";
			$this->Angsuran_Lama->TooltipValue = "";

			// Angsuran_Bunga_Prosen
			$this->Angsuran_Bunga_Prosen->LinkCustomAttributes = "";
			$this->Angsuran_Bunga_Prosen->HrefValue = "";
			$this->Angsuran_Bunga_Prosen->TooltipValue = "";

			// Angsuran_Denda
			$this->Angsuran_Denda->LinkCustomAttributes = "";
			$this->Angsuran_Denda->HrefValue = "";
			$this->Angsuran_Denda->TooltipValue = "";

			// Dispensasi_Denda
			$this->Dispensasi_Denda->LinkCustomAttributes = "";
			$this->Dispensasi_Denda->HrefValue = "";
			$this->Dispensasi_Denda->TooltipValue = "";

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

			// No_Ref
			$this->No_Ref->LinkCustomAttributes = "";
			$this->No_Ref->HrefValue = "";
			$this->No_Ref->TooltipValue = "";

			// Biaya_Administrasi
			$this->Biaya_Administrasi->LinkCustomAttributes = "";
			$this->Biaya_Administrasi->HrefValue = "";
			$this->Biaya_Administrasi->TooltipValue = "";

			// Biaya_Materai
			$this->Biaya_Materai->LinkCustomAttributes = "";
			$this->Biaya_Materai->HrefValue = "";
			$this->Biaya_Materai->TooltipValue = "";

			// marketing_id
			$this->marketing_id->LinkCustomAttributes = "";
			$this->marketing_id->HrefValue = "";
			$this->marketing_id->TooltipValue = "";

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
if (!isset($t0301_pinjaman_list)) $t0301_pinjaman_list = new ct0301_pinjaman_list();

// Page init
$t0301_pinjaman_list->Page_Init();

// Page main
$t0301_pinjaman_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t0301_pinjaman_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft0301_pinjamanlist = new ew_Form("ft0301_pinjamanlist", "list");
ft0301_pinjamanlist.FormKeyCountName = '<?php echo $t0301_pinjaman_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft0301_pinjamanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft0301_pinjamanlist.ValidateRequired = true;
<?php } else { ?>
ft0301_pinjamanlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft0301_pinjamanlistsrch = new ew_Form("ft0301_pinjamanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($t0301_pinjaman_list->TotalRecs > 0 && $t0301_pinjaman_list->ExportOptions->Visible()) { ?>
<?php $t0301_pinjaman_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t0301_pinjaman_list->SearchOptions->Visible()) { ?>
<?php $t0301_pinjaman_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t0301_pinjaman_list->FilterOptions->Visible()) { ?>
<?php $t0301_pinjaman_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t0301_pinjaman_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t0301_pinjaman_list->TotalRecs <= 0)
			$t0301_pinjaman_list->TotalRecs = $t0301_pinjaman->SelectRecordCount();
	} else {
		if (!$t0301_pinjaman_list->Recordset && ($t0301_pinjaman_list->Recordset = $t0301_pinjaman_list->LoadRecordset()))
			$t0301_pinjaman_list->TotalRecs = $t0301_pinjaman_list->Recordset->RecordCount();
	}
	$t0301_pinjaman_list->StartRec = 1;
	if ($t0301_pinjaman_list->DisplayRecs <= 0 || ($t0301_pinjaman->Export <> "" && $t0301_pinjaman->ExportAll)) // Display all records
		$t0301_pinjaman_list->DisplayRecs = $t0301_pinjaman_list->TotalRecs;
	if (!($t0301_pinjaman->Export <> "" && $t0301_pinjaman->ExportAll))
		$t0301_pinjaman_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t0301_pinjaman_list->Recordset = $t0301_pinjaman_list->LoadRecordset($t0301_pinjaman_list->StartRec-1, $t0301_pinjaman_list->DisplayRecs);

	// Set no record found message
	if ($t0301_pinjaman->CurrentAction == "" && $t0301_pinjaman_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t0301_pinjaman_list->setWarningMessage(ew_DeniedMsg());
		if ($t0301_pinjaman_list->SearchWhere == "0=101")
			$t0301_pinjaman_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t0301_pinjaman_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t0301_pinjaman_list->AuditTrailOnSearch && $t0301_pinjaman_list->Command == "search" && !$t0301_pinjaman_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t0301_pinjaman_list->getSessionWhere();
		$t0301_pinjaman_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$t0301_pinjaman_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t0301_pinjaman->Export == "" && $t0301_pinjaman->CurrentAction == "") { ?>
<form name="ft0301_pinjamanlistsrch" id="ft0301_pinjamanlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t0301_pinjaman_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft0301_pinjamanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t0301_pinjaman">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t0301_pinjaman_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t0301_pinjaman_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t0301_pinjaman_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t0301_pinjaman_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t0301_pinjaman_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t0301_pinjaman_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t0301_pinjaman_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t0301_pinjaman_list->ShowPageHeader(); ?>
<?php
$t0301_pinjaman_list->ShowMessage();
?>
<?php if ($t0301_pinjaman_list->TotalRecs > 0 || $t0301_pinjaman->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t0301_pinjaman">
<form name="ft0301_pinjamanlist" id="ft0301_pinjamanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t0301_pinjaman_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t0301_pinjaman_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t0301_pinjaman">
<div id="gmp_t0301_pinjaman" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t0301_pinjaman_list->TotalRecs > 0 || $t0301_pinjaman->CurrentAction == "gridedit") { ?>
<table id="tbl_t0301_pinjamanlist" class="table ewTable">
<?php echo $t0301_pinjaman->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t0301_pinjaman_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t0301_pinjaman_list->RenderListOptions();

// Render list options (header, left)
$t0301_pinjaman_list->ListOptions->Render("header", "left");
?>
<?php if ($t0301_pinjaman->id->Visible) { // id ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->id) == "") { ?>
		<th data-name="id"><div id="elh_t0301_pinjaman_id" class="t0301_pinjaman_id"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->id) ?>',2);"><div id="elh_t0301_pinjaman_id" class="t0301_pinjaman_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Kontrak_No->Visible) { // Kontrak_No ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Kontrak_No) == "") { ?>
		<th data-name="Kontrak_No"><div id="elh_t0301_pinjaman_Kontrak_No" class="t0301_pinjaman_Kontrak_No"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Kontrak_No->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kontrak_No"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Kontrak_No) ?>',2);"><div id="elh_t0301_pinjaman_Kontrak_No" class="t0301_pinjaman_Kontrak_No">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Kontrak_No->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Kontrak_No->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Kontrak_No->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Kontrak_Tgl->Visible) { // Kontrak_Tgl ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Kontrak_Tgl) == "") { ?>
		<th data-name="Kontrak_Tgl"><div id="elh_t0301_pinjaman_Kontrak_Tgl" class="t0301_pinjaman_Kontrak_Tgl"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Kontrak_Tgl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kontrak_Tgl"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Kontrak_Tgl) ?>',2);"><div id="elh_t0301_pinjaman_Kontrak_Tgl" class="t0301_pinjaman_Kontrak_Tgl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Kontrak_Tgl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Kontrak_Tgl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Kontrak_Tgl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->nasabah_id) == "") { ?>
		<th data-name="nasabah_id"><div id="elh_t0301_pinjaman_nasabah_id" class="t0301_pinjaman_nasabah_id"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->nasabah_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nasabah_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->nasabah_id) ?>',2);"><div id="elh_t0301_pinjaman_nasabah_id" class="t0301_pinjaman_nasabah_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->nasabah_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->nasabah_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->nasabah_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->jaminan_id->Visible) { // jaminan_id ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->jaminan_id) == "") { ?>
		<th data-name="jaminan_id"><div id="elh_t0301_pinjaman_jaminan_id" class="t0301_pinjaman_jaminan_id"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->jaminan_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jaminan_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->jaminan_id) ?>',2);"><div id="elh_t0301_pinjaman_jaminan_id" class="t0301_pinjaman_jaminan_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->jaminan_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->jaminan_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->jaminan_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Pinjaman) == "") { ?>
		<th data-name="Pinjaman"><div id="elh_t0301_pinjaman_Pinjaman" class="t0301_pinjaman_Pinjaman"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Pinjaman->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pinjaman"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Pinjaman) ?>',2);"><div id="elh_t0301_pinjaman_Pinjaman" class="t0301_pinjaman_Pinjaman">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Pinjaman->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Pinjaman->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Pinjaman->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Lama->Visible) { // Angsuran_Lama ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Lama) == "") { ?>
		<th data-name="Angsuran_Lama"><div id="elh_t0301_pinjaman_Angsuran_Lama" class="t0301_pinjaman_Angsuran_Lama"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Lama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Lama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Lama) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Lama" class="t0301_pinjaman_Angsuran_Lama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Lama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Lama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Lama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Bunga_Prosen->Visible) { // Angsuran_Bunga_Prosen ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Bunga_Prosen) == "") { ?>
		<th data-name="Angsuran_Bunga_Prosen"><div id="elh_t0301_pinjaman_Angsuran_Bunga_Prosen" class="t0301_pinjaman_Angsuran_Bunga_Prosen"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Bunga_Prosen->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Bunga_Prosen"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Bunga_Prosen) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Bunga_Prosen" class="t0301_pinjaman_Angsuran_Bunga_Prosen">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Bunga_Prosen->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Bunga_Prosen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Bunga_Prosen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Denda->Visible) { // Angsuran_Denda ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Denda) == "") { ?>
		<th data-name="Angsuran_Denda"><div id="elh_t0301_pinjaman_Angsuran_Denda" class="t0301_pinjaman_Angsuran_Denda"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Denda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Denda"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Denda) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Denda" class="t0301_pinjaman_Angsuran_Denda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Denda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Denda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Denda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Dispensasi_Denda->Visible) { // Dispensasi_Denda ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Dispensasi_Denda) == "") { ?>
		<th data-name="Dispensasi_Denda"><div id="elh_t0301_pinjaman_Dispensasi_Denda" class="t0301_pinjaman_Dispensasi_Denda"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Dispensasi_Denda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dispensasi_Denda"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Dispensasi_Denda) ?>',2);"><div id="elh_t0301_pinjaman_Dispensasi_Denda" class="t0301_pinjaman_Dispensasi_Denda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Dispensasi_Denda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Dispensasi_Denda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Dispensasi_Denda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Pokok) == "") { ?>
		<th data-name="Angsuran_Pokok"><div id="elh_t0301_pinjaman_Angsuran_Pokok" class="t0301_pinjaman_Angsuran_Pokok"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Pokok->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Pokok"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Pokok) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Pokok" class="t0301_pinjaman_Angsuran_Pokok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Pokok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Pokok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Pokok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Bunga) == "") { ?>
		<th data-name="Angsuran_Bunga"><div id="elh_t0301_pinjaman_Angsuran_Bunga" class="t0301_pinjaman_Angsuran_Bunga"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Bunga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Bunga"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Bunga) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Bunga" class="t0301_pinjaman_Angsuran_Bunga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Bunga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Bunga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Bunga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Angsuran_Total->Visible) { // Angsuran_Total ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Total) == "") { ?>
		<th data-name="Angsuran_Total"><div id="elh_t0301_pinjaman_Angsuran_Total" class="t0301_pinjaman_Angsuran_Total"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Angsuran_Total"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Angsuran_Total) ?>',2);"><div id="elh_t0301_pinjaman_Angsuran_Total" class="t0301_pinjaman_Angsuran_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Angsuran_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Angsuran_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Angsuran_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->No_Ref->Visible) { // No_Ref ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->No_Ref) == "") { ?>
		<th data-name="No_Ref"><div id="elh_t0301_pinjaman_No_Ref" class="t0301_pinjaman_No_Ref"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->No_Ref->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_Ref"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->No_Ref) ?>',2);"><div id="elh_t0301_pinjaman_No_Ref" class="t0301_pinjaman_No_Ref">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->No_Ref->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->No_Ref->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->No_Ref->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Biaya_Administrasi->Visible) { // Biaya_Administrasi ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Biaya_Administrasi) == "") { ?>
		<th data-name="Biaya_Administrasi"><div id="elh_t0301_pinjaman_Biaya_Administrasi" class="t0301_pinjaman_Biaya_Administrasi"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Biaya_Administrasi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Biaya_Administrasi"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Biaya_Administrasi) ?>',2);"><div id="elh_t0301_pinjaman_Biaya_Administrasi" class="t0301_pinjaman_Biaya_Administrasi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Biaya_Administrasi->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Biaya_Administrasi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Biaya_Administrasi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Biaya_Materai->Visible) { // Biaya_Materai ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Biaya_Materai) == "") { ?>
		<th data-name="Biaya_Materai"><div id="elh_t0301_pinjaman_Biaya_Materai" class="t0301_pinjaman_Biaya_Materai"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Biaya_Materai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Biaya_Materai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Biaya_Materai) ?>',2);"><div id="elh_t0301_pinjaman_Biaya_Materai" class="t0301_pinjaman_Biaya_Materai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Biaya_Materai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Biaya_Materai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Biaya_Materai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->marketing_id->Visible) { // marketing_id ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->marketing_id) == "") { ?>
		<th data-name="marketing_id"><div id="elh_t0301_pinjaman_marketing_id" class="t0301_pinjaman_marketing_id"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->marketing_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="marketing_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->marketing_id) ?>',2);"><div id="elh_t0301_pinjaman_marketing_id" class="t0301_pinjaman_marketing_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->marketing_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->marketing_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->marketing_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t0301_pinjaman->Periode->Visible) { // Periode ?>
	<?php if ($t0301_pinjaman->SortUrl($t0301_pinjaman->Periode) == "") { ?>
		<th data-name="Periode"><div id="elh_t0301_pinjaman_Periode" class="t0301_pinjaman_Periode"><div class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Periode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t0301_pinjaman->SortUrl($t0301_pinjaman->Periode) ?>',2);"><div id="elh_t0301_pinjaman_Periode" class="t0301_pinjaman_Periode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t0301_pinjaman->Periode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t0301_pinjaman->Periode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t0301_pinjaman->Periode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t0301_pinjaman_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t0301_pinjaman->ExportAll && $t0301_pinjaman->Export <> "") {
	$t0301_pinjaman_list->StopRec = $t0301_pinjaman_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t0301_pinjaman_list->TotalRecs > $t0301_pinjaman_list->StartRec + $t0301_pinjaman_list->DisplayRecs - 1)
		$t0301_pinjaman_list->StopRec = $t0301_pinjaman_list->StartRec + $t0301_pinjaman_list->DisplayRecs - 1;
	else
		$t0301_pinjaman_list->StopRec = $t0301_pinjaman_list->TotalRecs;
}
$t0301_pinjaman_list->RecCnt = $t0301_pinjaman_list->StartRec - 1;
if ($t0301_pinjaman_list->Recordset && !$t0301_pinjaman_list->Recordset->EOF) {
	$t0301_pinjaman_list->Recordset->MoveFirst();
	$bSelectLimit = $t0301_pinjaman_list->UseSelectLimit;
	if (!$bSelectLimit && $t0301_pinjaman_list->StartRec > 1)
		$t0301_pinjaman_list->Recordset->Move($t0301_pinjaman_list->StartRec - 1);
} elseif (!$t0301_pinjaman->AllowAddDeleteRow && $t0301_pinjaman_list->StopRec == 0) {
	$t0301_pinjaman_list->StopRec = $t0301_pinjaman->GridAddRowCount;
}

// Initialize aggregate
$t0301_pinjaman->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t0301_pinjaman->ResetAttrs();
$t0301_pinjaman_list->RenderRow();
while ($t0301_pinjaman_list->RecCnt < $t0301_pinjaman_list->StopRec) {
	$t0301_pinjaman_list->RecCnt++;
	if (intval($t0301_pinjaman_list->RecCnt) >= intval($t0301_pinjaman_list->StartRec)) {
		$t0301_pinjaman_list->RowCnt++;

		// Set up key count
		$t0301_pinjaman_list->KeyCount = $t0301_pinjaman_list->RowIndex;

		// Init row class and style
		$t0301_pinjaman->ResetAttrs();
		$t0301_pinjaman->CssClass = "";
		if ($t0301_pinjaman->CurrentAction == "gridadd") {
		} else {
			$t0301_pinjaman_list->LoadRowValues($t0301_pinjaman_list->Recordset); // Load row values
		}
		$t0301_pinjaman->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t0301_pinjaman->RowAttrs = array_merge($t0301_pinjaman->RowAttrs, array('data-rowindex'=>$t0301_pinjaman_list->RowCnt, 'id'=>'r' . $t0301_pinjaman_list->RowCnt . '_t0301_pinjaman', 'data-rowtype'=>$t0301_pinjaman->RowType));

		// Render row
		$t0301_pinjaman_list->RenderRow();

		// Render list options
		$t0301_pinjaman_list->RenderListOptions();
?>
	<tr<?php echo $t0301_pinjaman->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t0301_pinjaman_list->ListOptions->Render("body", "left", $t0301_pinjaman_list->RowCnt);
?>
	<?php if ($t0301_pinjaman->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t0301_pinjaman->id->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_id" class="t0301_pinjaman_id">
<span<?php echo $t0301_pinjaman->id->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $t0301_pinjaman_list->PageObjName . "_row_" . $t0301_pinjaman_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Kontrak_No->Visible) { // Kontrak_No ?>
		<td data-name="Kontrak_No"<?php echo $t0301_pinjaman->Kontrak_No->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Kontrak_No" class="t0301_pinjaman_Kontrak_No">
<span<?php echo $t0301_pinjaman->Kontrak_No->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Kontrak_No->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Kontrak_Tgl->Visible) { // Kontrak_Tgl ?>
		<td data-name="Kontrak_Tgl"<?php echo $t0301_pinjaman->Kontrak_Tgl->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Kontrak_Tgl" class="t0301_pinjaman_Kontrak_Tgl">
<span<?php echo $t0301_pinjaman->Kontrak_Tgl->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Kontrak_Tgl->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<td data-name="nasabah_id"<?php echo $t0301_pinjaman->nasabah_id->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_nasabah_id" class="t0301_pinjaman_nasabah_id">
<span<?php echo $t0301_pinjaman->nasabah_id->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->nasabah_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->jaminan_id->Visible) { // jaminan_id ?>
		<td data-name="jaminan_id"<?php echo $t0301_pinjaman->jaminan_id->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_jaminan_id" class="t0301_pinjaman_jaminan_id">
<span<?php echo $t0301_pinjaman->jaminan_id->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->jaminan_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman"<?php echo $t0301_pinjaman->Pinjaman->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Pinjaman" class="t0301_pinjaman_Pinjaman">
<span<?php echo $t0301_pinjaman->Pinjaman->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Pinjaman->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Lama->Visible) { // Angsuran_Lama ?>
		<td data-name="Angsuran_Lama"<?php echo $t0301_pinjaman->Angsuran_Lama->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Lama" class="t0301_pinjaman_Angsuran_Lama">
<span<?php echo $t0301_pinjaman->Angsuran_Lama->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Lama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Bunga_Prosen->Visible) { // Angsuran_Bunga_Prosen ?>
		<td data-name="Angsuran_Bunga_Prosen"<?php echo $t0301_pinjaman->Angsuran_Bunga_Prosen->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Bunga_Prosen" class="t0301_pinjaman_Angsuran_Bunga_Prosen">
<span<?php echo $t0301_pinjaman->Angsuran_Bunga_Prosen->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Bunga_Prosen->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Denda->Visible) { // Angsuran_Denda ?>
		<td data-name="Angsuran_Denda"<?php echo $t0301_pinjaman->Angsuran_Denda->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Denda" class="t0301_pinjaman_Angsuran_Denda">
<span<?php echo $t0301_pinjaman->Angsuran_Denda->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Denda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Dispensasi_Denda->Visible) { // Dispensasi_Denda ?>
		<td data-name="Dispensasi_Denda"<?php echo $t0301_pinjaman->Dispensasi_Denda->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Dispensasi_Denda" class="t0301_pinjaman_Dispensasi_Denda">
<span<?php echo $t0301_pinjaman->Dispensasi_Denda->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Dispensasi_Denda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
		<td data-name="Angsuran_Pokok"<?php echo $t0301_pinjaman->Angsuran_Pokok->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Pokok" class="t0301_pinjaman_Angsuran_Pokok">
<span<?php echo $t0301_pinjaman->Angsuran_Pokok->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Pokok->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
		<td data-name="Angsuran_Bunga"<?php echo $t0301_pinjaman->Angsuran_Bunga->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Bunga" class="t0301_pinjaman_Angsuran_Bunga">
<span<?php echo $t0301_pinjaman->Angsuran_Bunga->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Bunga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Angsuran_Total->Visible) { // Angsuran_Total ?>
		<td data-name="Angsuran_Total"<?php echo $t0301_pinjaman->Angsuran_Total->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Angsuran_Total" class="t0301_pinjaman_Angsuran_Total">
<span<?php echo $t0301_pinjaman->Angsuran_Total->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Angsuran_Total->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->No_Ref->Visible) { // No_Ref ?>
		<td data-name="No_Ref"<?php echo $t0301_pinjaman->No_Ref->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_No_Ref" class="t0301_pinjaman_No_Ref">
<span<?php echo $t0301_pinjaman->No_Ref->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->No_Ref->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Biaya_Administrasi->Visible) { // Biaya_Administrasi ?>
		<td data-name="Biaya_Administrasi"<?php echo $t0301_pinjaman->Biaya_Administrasi->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Biaya_Administrasi" class="t0301_pinjaman_Biaya_Administrasi">
<span<?php echo $t0301_pinjaman->Biaya_Administrasi->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Biaya_Administrasi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Biaya_Materai->Visible) { // Biaya_Materai ?>
		<td data-name="Biaya_Materai"<?php echo $t0301_pinjaman->Biaya_Materai->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Biaya_Materai" class="t0301_pinjaman_Biaya_Materai">
<span<?php echo $t0301_pinjaman->Biaya_Materai->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Biaya_Materai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->marketing_id->Visible) { // marketing_id ?>
		<td data-name="marketing_id"<?php echo $t0301_pinjaman->marketing_id->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_marketing_id" class="t0301_pinjaman_marketing_id">
<span<?php echo $t0301_pinjaman->marketing_id->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->marketing_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t0301_pinjaman->Periode->Visible) { // Periode ?>
		<td data-name="Periode"<?php echo $t0301_pinjaman->Periode->CellAttributes() ?>>
<span id="el<?php echo $t0301_pinjaman_list->RowCnt ?>_t0301_pinjaman_Periode" class="t0301_pinjaman_Periode">
<span<?php echo $t0301_pinjaman->Periode->ViewAttributes() ?>>
<?php echo $t0301_pinjaman->Periode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t0301_pinjaman_list->ListOptions->Render("body", "right", $t0301_pinjaman_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t0301_pinjaman->CurrentAction <> "gridadd")
		$t0301_pinjaman_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t0301_pinjaman->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t0301_pinjaman_list->Recordset)
	$t0301_pinjaman_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t0301_pinjaman->CurrentAction <> "gridadd" && $t0301_pinjaman->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t0301_pinjaman_list->Pager)) $t0301_pinjaman_list->Pager = new cPrevNextPager($t0301_pinjaman_list->StartRec, $t0301_pinjaman_list->DisplayRecs, $t0301_pinjaman_list->TotalRecs) ?>
<?php if ($t0301_pinjaman_list->Pager->RecordCount > 0 && $t0301_pinjaman_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t0301_pinjaman_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t0301_pinjaman_list->PageUrl() ?>start=<?php echo $t0301_pinjaman_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t0301_pinjaman_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t0301_pinjaman_list->PageUrl() ?>start=<?php echo $t0301_pinjaman_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t0301_pinjaman_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t0301_pinjaman_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t0301_pinjaman_list->PageUrl() ?>start=<?php echo $t0301_pinjaman_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t0301_pinjaman_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t0301_pinjaman_list->PageUrl() ?>start=<?php echo $t0301_pinjaman_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t0301_pinjaman_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t0301_pinjaman_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t0301_pinjaman_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t0301_pinjaman_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t0301_pinjaman_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t0301_pinjaman_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t0301_pinjaman">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t0301_pinjaman_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t0301_pinjaman_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t0301_pinjaman_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t0301_pinjaman_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t0301_pinjaman->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t0301_pinjaman_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t0301_pinjaman_list->TotalRecs == 0 && $t0301_pinjaman->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t0301_pinjaman_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft0301_pinjamanlistsrch.FilterList = <?php echo $t0301_pinjaman_list->GetFilterList() ?>;
ft0301_pinjamanlistsrch.Init();
ft0301_pinjamanlist.Init();
</script>
<?php
$t0301_pinjaman_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t0301_pinjaman_list->Page_Terminate();
?>
