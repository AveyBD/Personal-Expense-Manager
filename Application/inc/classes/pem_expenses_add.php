<?php
namespace CetraFramework\cetra_pem;

//
// Page class
//
class pem_expenses_add extends pem_expenses
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}";

	// Table name
	public $TableName = 'pem_expenses';

	// Page object name
	public $PageObjName = "pem_expenses_add";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken = CHECK_TOKEN;
	public $CheckTokenFn = PROJECT_NAMESPACE . "CheckToken";
	public $CreateTokenFn = PROJECT_NAMESPACE . "CreateToken";

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Message
	public function getMessage()
	{
		return @$_SESSION[SESSION_MESSAGE];
	}
	public function setMessage($v)
	{
		AddMessage($_SESSION[SESSION_MESSAGE], $v);
	}
	public function getFailureMessage()
	{
		return @$_SESSION[SESSION_FAILURE_MESSAGE];
	}
	public function setFailureMessage($v)
	{
		AddMessage($_SESSION[SESSION_FAILURE_MESSAGE], $v);
	}
	public function getSuccessMessage()
	{
		return @$_SESSION[SESSION_SUCCESS_MESSAGE];
	}
	public function setSuccessMessage($v)
	{
		AddMessage($_SESSION[SESSION_SUCCESS_MESSAGE], $v);
	}
	public function getWarningMessage()
	{
		return @$_SESSION[SESSION_WARNING_MESSAGE];
	}
	public function setWarningMessage($v)
	{
		AddMessage($_SESSION[SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	public function clearMessage()
	{
		$_SESSION[SESSION_MESSAGE] = "";
	}
	public function clearFailureMessage()
	{
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}
	public function clearSuccessMessage()
	{
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}
	public function clearWarningMessage()
	{
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}
	public function clearMessages()
	{
		$_SESSION[SESSION_MESSAGE] = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message <> "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fa fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fa fa-warning"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage <> "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fa fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fa fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessageAsArray()
	{
		$ar = array();

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message <> "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage <> "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage <> "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage <> "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header <> "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer <> "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") <> "")
				return ($this->TableVar == Get("t"));
		} else {
			return TRUE;
		}
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(TOKEN_NAME) === NULL)
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn(Post(TOKEN_NAME), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;

		//if ($this->CheckToken) { // Always create token, required by API file/lookup request
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$CurrentToken = $this->Token; // Save to global variable

		//}
	}

	//
	// Page class constructor
	//

	public function __construct()
	{
		global $Conn, $Language, $COMPOSITE_KEY_SEPARATOR;
		global $UserTable, $UserTableConn;

		// Validate configuration
		if (!IS_PHP5)
			die("This script requires PHP 5.5 or later, but you are running " . phpversion() . ".");
		if (!function_exists("xml_parser_create"))
			die("This script requires PHP XML Parser.");
		if (!IS_WINDOWS && IS_MSACCESS)
			die("Microsoft Access is supported on Windows server only.");

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (pem_expenses)
		if (!isset($GLOBALS["pem_expenses"]) || get_class($GLOBALS["pem_expenses"]) == PROJECT_NAMESPACE . "pem_expenses") {
			$GLOBALS["pem_expenses"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pem_expenses"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'pem_expenses');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($Conn))
			$Conn = GetConnection($this->Dbid);

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new users();
			$UserTableConn = Conn($UserTable->Dbid);
		}
	}

	//
	// Terminate page
	//

	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EXPORT, $pem_expenses;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pem_expenses);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessageAsArray()));
			exit();
		}

		// Go to URL if specified
		if ($url <> "") {
			if (!DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "pem_expensesview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson([$row]);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = array();
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = array();
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {

								//$url = FullUrl($fld->TableVar . "/" . API_FILE_ACTION . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))); // URL rewrite format
								$url = FullUrl(GetPageName(API_URL) . "?" . API_OBJECT_NAME . "=" . $fld->TableVar . "&" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&" . API_FIELD_NAME . "=" . $fld->Param . "&" . API_KEY_NAME . "=" . rawurlencode($this->getRecordKeyValue($ar))); // Query string format
								$row[$fldname] = ["mimeType" => ContentType(substr($val, 0, 11)), "url" => $url];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, MULTIPLE_UPLOAD_SEPARATOR)) { // Single file
								$row[$fldname] = ["mimeType" => ContentType("", $val), "url" => FullUrl($fld->hrefPath() . $val)];
							} else { // Multiple files
								$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
								$ar = [];
								foreach ($files as $file) {
									if (!EmptyValue($file))
										$ar[] = ["type" => ContentType("", $val), "url" => FullUrl($fld->hrefPath() . $file)];
								}
								$row[$fldname] = $ar;
							}
						}
					} else {
						$row[$fldname] = $val;
					}
				}
			}
		}
		return $row;
	}

	// Get record key value from array
	protected function getRecordKeyValue($ar)
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['exp_id'];
		}
		return $key;
	}

	/**
	 * Hide fields for add/edit
	 *
	 * @return void
	 */
	protected function hideFieldsForAddEdit()
	{
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->exp_id->Visible = FALSE;
	}
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRec;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . "CheckToken";
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// User profile
		$UserProfile = new UserProfile();

		// Security
		$Security = new AdvancedSecurity();
		$validRequest = FALSE;

		// Check security for API request
		If (IsApi()) {

			// Check token first
			$func = PROJECT_NAMESPACE . "CheckToken";
			if (is_callable($func) && Post(TOKEN_NAME) !== NULL)
				$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			elseif (is_array($RequestSecurity)) // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
		}
		if (!$validRequest) {
			if (!$Security->isLoggedIn()) $Security->autoLogin();
			if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
			if (!$Security->canAdd()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("pem_expenseslist.php"));
				else
					$this->terminate(GetUrl("login.php"));
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->exp_id->Visible = FALSE;
		$this->exp_item->setVisibility();
		$this->exp_category->setVisibility();
		$this->payment_type->setVisibility();
		$this->exp_source->setVisibility();
		$this->exp_amount->setVisibility();
		$this->exp_date->setVisibility();
		$this->exp_remarks->setVisibility();
		$this->user_id->setVisibility();
		$this->hideFieldsForAddEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->Phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up lookup cache
		$this->setupLookupOptions($this->exp_category);
		$this->setupLookupOptions($this->payment_type);
		$this->setupLookupOptions($this->exp_source);
		$this->setupLookupOptions($this->user_id);

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("exp_id") !== NULL) {
				$this->exp_id->setQueryStringValue(Get("exp_id"));
				$this->setKey("exp_id", $this->exp_id->CurrentValue); // Set up key
			} else {
				$this->setKey("exp_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
				if (IsApi())
					$this->terminate();
				else
					$this->CurrentAction = "show"; // Form error, reset action
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "copy": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->terminate("pem_expenseslist.php"); // No matching record, return to list
				}
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$returnUrl = $this->getReturnUrl();
					if (GetPageName($returnUrl) == "pem_expenseslist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "pem_expensesview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) // Return to caller
						$this->terminate(TRUE);
					else
						$this->terminate($returnUrl);
				} elseif (IsApi()) { // API request, return
					$this->terminate();
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
		$this->resetAttributes();
		$this->renderRow();
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->exp_id->CurrentValue = NULL;
		$this->exp_id->OldValue = $this->exp_id->CurrentValue;
		$this->exp_item->CurrentValue = NULL;
		$this->exp_item->OldValue = $this->exp_item->CurrentValue;
		$this->exp_category->CurrentValue = NULL;
		$this->exp_category->OldValue = $this->exp_category->CurrentValue;
		$this->payment_type->CurrentValue = NULL;
		$this->payment_type->OldValue = $this->payment_type->CurrentValue;
		$this->exp_source->CurrentValue = NULL;
		$this->exp_source->OldValue = $this->exp_source->CurrentValue;
		$this->exp_amount->CurrentValue = NULL;
		$this->exp_amount->OldValue = $this->exp_amount->CurrentValue;
		$this->exp_date->CurrentValue = NULL;
		$this->exp_date->OldValue = $this->exp_date->CurrentValue;
		$this->exp_remarks->CurrentValue = NULL;
		$this->exp_remarks->OldValue = $this->exp_remarks->CurrentValue;
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'exp_item' first before field var 'x_exp_item'
		$val = $CurrentForm->hasValue("exp_item") ? $CurrentForm->getValue("exp_item") : $CurrentForm->getValue("x_exp_item");
		if (!$this->exp_item->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_item->Visible = FALSE; // Disable update for API request
			else
				$this->exp_item->setFormValue($val);
		}

		// Check field name 'exp_category' first before field var 'x_exp_category'
		$val = $CurrentForm->hasValue("exp_category") ? $CurrentForm->getValue("exp_category") : $CurrentForm->getValue("x_exp_category");
		if (!$this->exp_category->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_category->Visible = FALSE; // Disable update for API request
			else
				$this->exp_category->setFormValue($val);
		}

		// Check field name 'payment_type' first before field var 'x_payment_type'
		$val = $CurrentForm->hasValue("payment_type") ? $CurrentForm->getValue("payment_type") : $CurrentForm->getValue("x_payment_type");
		if (!$this->payment_type->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->payment_type->Visible = FALSE; // Disable update for API request
			else
				$this->payment_type->setFormValue($val);
		}

		// Check field name 'exp_source' first before field var 'x_exp_source'
		$val = $CurrentForm->hasValue("exp_source") ? $CurrentForm->getValue("exp_source") : $CurrentForm->getValue("x_exp_source");
		if (!$this->exp_source->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_source->Visible = FALSE; // Disable update for API request
			else
				$this->exp_source->setFormValue($val);
		}

		// Check field name 'exp_amount' first before field var 'x_exp_amount'
		$val = $CurrentForm->hasValue("exp_amount") ? $CurrentForm->getValue("exp_amount") : $CurrentForm->getValue("x_exp_amount");
		if (!$this->exp_amount->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_amount->Visible = FALSE; // Disable update for API request
			else
				$this->exp_amount->setFormValue($val);
		}

		// Check field name 'exp_date' first before field var 'x_exp_date'
		$val = $CurrentForm->hasValue("exp_date") ? $CurrentForm->getValue("exp_date") : $CurrentForm->getValue("x_exp_date");
		if (!$this->exp_date->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_date->Visible = FALSE; // Disable update for API request
			else
				$this->exp_date->setFormValue($val);
			$this->exp_date->CurrentValue = UnFormatDateTime($this->exp_date->CurrentValue, 0);
		}

		// Check field name 'exp_remarks' first before field var 'x_exp_remarks'
		$val = $CurrentForm->hasValue("exp_remarks") ? $CurrentForm->getValue("exp_remarks") : $CurrentForm->getValue("x_exp_remarks");
		if (!$this->exp_remarks->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->exp_remarks->Visible = FALSE; // Disable update for API request
			else
				$this->exp_remarks->setFormValue($val);
		}

		// Check field name 'user_id' first before field var 'x_user_id'
		$val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");
		if (!$this->user_id->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->user_id->Visible = FALSE; // Disable update for API request
			else
				$this->user_id->setFormValue($val);
		}

		// Check field name 'exp_id' first before field var 'x_exp_id'
		$val = $CurrentForm->hasValue("exp_id") ? $CurrentForm->getValue("exp_id") : $CurrentForm->getValue("x_exp_id");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->exp_item->CurrentValue = $this->exp_item->FormValue;
		$this->exp_category->CurrentValue = $this->exp_category->FormValue;
		$this->payment_type->CurrentValue = $this->payment_type->FormValue;
		$this->exp_source->CurrentValue = $this->exp_source->FormValue;
		$this->exp_amount->CurrentValue = $this->exp_amount->FormValue;
		$this->exp_date->CurrentValue = $this->exp_date->FormValue;
		$this->exp_date->CurrentValue = UnFormatDateTime($this->exp_date->CurrentValue, 0);
		$this->exp_remarks->CurrentValue = $this->exp_remarks->FormValue;
		$this->user_id->CurrentValue = $this->user_id->FormValue;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->exp_id->setDbValue($row['exp_id']);
		$this->exp_item->setDbValue($row['exp_item']);
		$this->exp_category->setDbValue($row['exp_category']);
		$this->payment_type->setDbValue($row['payment_type']);
		$this->exp_source->setDbValue($row['exp_source']);
		$this->exp_amount->setDbValue($row['exp_amount']);
		$this->exp_date->setDbValue($row['exp_date']);
		$this->exp_remarks->setDbValue($row['exp_remarks']);
		$this->user_id->setDbValue($row['user_id']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['exp_id'] = $this->exp_id->CurrentValue;
		$row['exp_item'] = $this->exp_item->CurrentValue;
		$row['exp_category'] = $this->exp_category->CurrentValue;
		$row['payment_type'] = $this->payment_type->CurrentValue;
		$row['exp_source'] = $this->exp_source->CurrentValue;
		$row['exp_amount'] = $this->exp_amount->CurrentValue;
		$row['exp_date'] = $this->exp_date->CurrentValue;
		$row['exp_remarks'] = $this->exp_remarks->CurrentValue;
		$row['user_id'] = $this->user_id->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("exp_id")) <> "")
			$this->exp_id->CurrentValue = $this->getKey("exp_id"); // exp_id
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = &$this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->exp_amount->FormValue == $this->exp_amount->CurrentValue && is_numeric(ConvertToFloatString($this->exp_amount->CurrentValue)))
			$this->exp_amount->CurrentValue = ConvertToFloatString($this->exp_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// exp_id
		// exp_item
		// exp_category
		// payment_type
		// exp_source
		// exp_amount
		// exp_date
		// exp_remarks
		// user_id

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// exp_id
			$this->exp_id->ViewValue = $this->exp_id->CurrentValue;
			$this->exp_id->ViewCustomAttributes = "";

			// exp_item
			$this->exp_item->ViewValue = $this->exp_item->CurrentValue;
			$this->exp_item->ViewCustomAttributes = "";

			// exp_category
			$curVal = strval($this->exp_category->CurrentValue);
			if ($curVal <> "") {
				$this->exp_category->ViewValue = $this->exp_category->lookupCacheOption($curVal);
				if ($this->exp_category->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`cat_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->exp_category->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->exp_category->ViewValue = $this->exp_category->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->exp_category->ViewValue = $this->exp_category->CurrentValue;
					}
				}
			} else {
				$this->exp_category->ViewValue = NULL;
			}
			$this->exp_category->ViewCustomAttributes = "";

			// payment_type
			$curVal = strval($this->payment_type->CurrentValue);
			if ($curVal <> "") {
				$this->payment_type->ViewValue = $this->payment_type->lookupCacheOption($curVal);
				if ($this->payment_type->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`type_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->payment_type->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->payment_type->ViewValue = $this->payment_type->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->payment_type->ViewValue = $this->payment_type->CurrentValue;
					}
				}
			} else {
				$this->payment_type->ViewValue = NULL;
			}
			$this->payment_type->ViewCustomAttributes = "";

			// exp_source
			$curVal = strval($this->exp_source->CurrentValue);
			if ($curVal <> "") {
				$this->exp_source->ViewValue = $this->exp_source->lookupCacheOption($curVal);
				if ($this->exp_source->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`source_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->exp_source->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->exp_source->ViewValue = $this->exp_source->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->exp_source->ViewValue = $this->exp_source->CurrentValue;
					}
				}
			} else {
				$this->exp_source->ViewValue = NULL;
			}
			$this->exp_source->ViewCustomAttributes = "";

			// exp_amount
			$this->exp_amount->ViewValue = $this->exp_amount->CurrentValue;
			$this->exp_amount->ViewValue = FormatCurrency($this->exp_amount->ViewValue, 2, -2, -2, -2);
			$this->exp_amount->ViewCustomAttributes = "";

			// exp_date
			$this->exp_date->ViewValue = $this->exp_date->CurrentValue;
			$this->exp_date->ViewValue = FormatDateTime($this->exp_date->ViewValue, 0);
			$this->exp_date->ViewCustomAttributes = "";

			// exp_remarks
			$this->exp_remarks->ViewValue = $this->exp_remarks->CurrentValue;
			$this->exp_remarks->ViewCustomAttributes = "";

			// user_id
			$curVal = strval($this->user_id->CurrentValue);
			if ($curVal <> "") {
				$this->user_id->ViewValue = $this->user_id->lookupCacheOption($curVal);
				if ($this->user_id->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->user_id->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->user_id->ViewValue = $this->user_id->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->user_id->ViewValue = $this->user_id->CurrentValue;
					}
				}
			} else {
				$this->user_id->ViewValue = NULL;
			}
			$this->user_id->ViewCustomAttributes = "";

			// exp_item
			$this->exp_item->LinkCustomAttributes = "";
			$this->exp_item->HrefValue = "";
			$this->exp_item->TooltipValue = "";

			// exp_category
			$this->exp_category->LinkCustomAttributes = "";
			$this->exp_category->HrefValue = "";
			$this->exp_category->TooltipValue = "";

			// payment_type
			$this->payment_type->LinkCustomAttributes = "";
			$this->payment_type->HrefValue = "";
			$this->payment_type->TooltipValue = "";

			// exp_source
			$this->exp_source->LinkCustomAttributes = "";
			$this->exp_source->HrefValue = "";
			$this->exp_source->TooltipValue = "";

			// exp_amount
			$this->exp_amount->LinkCustomAttributes = "";
			$this->exp_amount->HrefValue = "";
			$this->exp_amount->TooltipValue = "";

			// exp_date
			$this->exp_date->LinkCustomAttributes = "";
			$this->exp_date->HrefValue = "";
			$this->exp_date->TooltipValue = "";

			// exp_remarks
			$this->exp_remarks->LinkCustomAttributes = "";
			$this->exp_remarks->HrefValue = "";
			$this->exp_remarks->TooltipValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// exp_item
			$this->exp_item->EditAttrs["class"] = "form-control";
			$this->exp_item->EditCustomAttributes = "";
			$this->exp_item->EditValue = HtmlEncode($this->exp_item->CurrentValue);
			$this->exp_item->PlaceHolder = RemoveHtml($this->exp_item->caption());

			// exp_category
			$this->exp_category->EditAttrs["class"] = "form-control";
			$this->exp_category->EditCustomAttributes = "";
			$curVal = trim(strval($this->exp_category->CurrentValue));
			if ($curVal <> "")
				$this->exp_category->ViewValue = $this->exp_category->lookupCacheOption($curVal);
			else
				$this->exp_category->ViewValue = $this->exp_category->Lookup !== NULL && is_array($this->exp_category->Lookup->Options) ? $curVal : NULL;
			if ($this->exp_category->ViewValue !== NULL) { // Load from cache
				$this->exp_category->EditValue = array_values($this->exp_category->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`cat_id`" . SearchString("=", $this->exp_category->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->exp_category->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->exp_category->EditValue = $arwrk;
			}

			// payment_type
			$this->payment_type->EditAttrs["class"] = "form-control";
			$this->payment_type->EditCustomAttributes = "";
			$curVal = trim(strval($this->payment_type->CurrentValue));
			if ($curVal <> "")
				$this->payment_type->ViewValue = $this->payment_type->lookupCacheOption($curVal);
			else
				$this->payment_type->ViewValue = $this->payment_type->Lookup !== NULL && is_array($this->payment_type->Lookup->Options) ? $curVal : NULL;
			if ($this->payment_type->ViewValue !== NULL) { // Load from cache
				$this->payment_type->EditValue = array_values($this->payment_type->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`type_id`" . SearchString("=", $this->payment_type->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->payment_type->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->payment_type->EditValue = $arwrk;
			}

			// exp_source
			$this->exp_source->EditAttrs["class"] = "form-control";
			$this->exp_source->EditCustomAttributes = "";
			$curVal = trim(strval($this->exp_source->CurrentValue));
			if ($curVal <> "")
				$this->exp_source->ViewValue = $this->exp_source->lookupCacheOption($curVal);
			else
				$this->exp_source->ViewValue = $this->exp_source->Lookup !== NULL && is_array($this->exp_source->Lookup->Options) ? $curVal : NULL;
			if ($this->exp_source->ViewValue !== NULL) { // Load from cache
				$this->exp_source->EditValue = array_values($this->exp_source->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`source_id`" . SearchString("=", $this->exp_source->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->exp_source->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->exp_source->EditValue = $arwrk;
			}

			// exp_amount
			$this->exp_amount->EditAttrs["class"] = "form-control";
			$this->exp_amount->EditCustomAttributes = "";
			$this->exp_amount->EditValue = HtmlEncode($this->exp_amount->CurrentValue);
			$this->exp_amount->PlaceHolder = RemoveHtml($this->exp_amount->caption());
			if (strval($this->exp_amount->EditValue) <> "" && is_numeric($this->exp_amount->EditValue))
				$this->exp_amount->EditValue = FormatNumber($this->exp_amount->EditValue, -2, -2, -2, -2);

			// exp_date
			$this->exp_date->EditAttrs["class"] = "form-control";
			$this->exp_date->EditCustomAttributes = "";
			$this->exp_date->EditValue = HtmlEncode(FormatDateTime($this->exp_date->CurrentValue, 8));
			$this->exp_date->PlaceHolder = RemoveHtml($this->exp_date->caption());

			// exp_remarks
			$this->exp_remarks->EditAttrs["class"] = "form-control";
			$this->exp_remarks->EditCustomAttributes = "";
			$this->exp_remarks->EditValue = HtmlEncode($this->exp_remarks->CurrentValue);
			$this->exp_remarks->PlaceHolder = RemoveHtml($this->exp_remarks->caption());

			// user_id
			// Add refer script
			// exp_item

			$this->exp_item->LinkCustomAttributes = "";
			$this->exp_item->HrefValue = "";

			// exp_category
			$this->exp_category->LinkCustomAttributes = "";
			$this->exp_category->HrefValue = "";

			// payment_type
			$this->payment_type->LinkCustomAttributes = "";
			$this->payment_type->HrefValue = "";

			// exp_source
			$this->exp_source->LinkCustomAttributes = "";
			$this->exp_source->HrefValue = "";

			// exp_amount
			$this->exp_amount->LinkCustomAttributes = "";
			$this->exp_amount->HrefValue = "";

			// exp_date
			$this->exp_date->LinkCustomAttributes = "";
			$this->exp_date->HrefValue = "";

			// exp_remarks
			$this->exp_remarks->LinkCustomAttributes = "";
			$this->exp_remarks->HrefValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!SERVER_VALIDATE)
			return ($FormError == "");
		if ($this->exp_id->Required) {
			if (!$this->exp_id->IsDetailKey && $this->exp_id->FormValue != NULL && $this->exp_id->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_id->caption(), $this->exp_id->RequiredErrorMessage));
			}
		}
		if ($this->exp_item->Required) {
			if (!$this->exp_item->IsDetailKey && $this->exp_item->FormValue != NULL && $this->exp_item->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_item->caption(), $this->exp_item->RequiredErrorMessage));
			}
		}
		if ($this->exp_category->Required) {
			if (!$this->exp_category->IsDetailKey && $this->exp_category->FormValue != NULL && $this->exp_category->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_category->caption(), $this->exp_category->RequiredErrorMessage));
			}
		}
		if ($this->payment_type->Required) {
			if (!$this->payment_type->IsDetailKey && $this->payment_type->FormValue != NULL && $this->payment_type->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->payment_type->caption(), $this->payment_type->RequiredErrorMessage));
			}
		}
		if ($this->exp_source->Required) {
			if (!$this->exp_source->IsDetailKey && $this->exp_source->FormValue != NULL && $this->exp_source->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_source->caption(), $this->exp_source->RequiredErrorMessage));
			}
		}
		if ($this->exp_amount->Required) {
			if (!$this->exp_amount->IsDetailKey && $this->exp_amount->FormValue != NULL && $this->exp_amount->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_amount->caption(), $this->exp_amount->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->exp_amount->FormValue)) {
			AddMessage($FormError, $this->exp_amount->errorMessage());
		}
		if ($this->exp_date->Required) {
			if (!$this->exp_date->IsDetailKey && $this->exp_date->FormValue != NULL && $this->exp_date->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_date->caption(), $this->exp_date->RequiredErrorMessage));
			}
		}
		if (!CheckDate($this->exp_date->FormValue)) {
			AddMessage($FormError, $this->exp_date->errorMessage());
		}
		if ($this->exp_remarks->Required) {
			if (!$this->exp_remarks->IsDetailKey && $this->exp_remarks->FormValue != NULL && $this->exp_remarks->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->exp_remarks->caption(), $this->exp_remarks->RequiredErrorMessage));
			}
		}
		if ($this->user_id->Required) {
			if (!$this->user_id->IsDetailKey && $this->user_id->FormValue != NULL && $this->user_id->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError <> "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;
		$conn = &$this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// exp_item
		$this->exp_item->setDbValueDef($rsnew, $this->exp_item->CurrentValue, "", FALSE);

		// exp_category
		$this->exp_category->setDbValueDef($rsnew, $this->exp_category->CurrentValue, 0, FALSE);

		// payment_type
		$this->payment_type->setDbValueDef($rsnew, $this->payment_type->CurrentValue, NULL, FALSE);

		// exp_source
		$this->exp_source->setDbValueDef($rsnew, $this->exp_source->CurrentValue, 0, FALSE);

		// exp_amount
		$this->exp_amount->setDbValueDef($rsnew, $this->exp_amount->CurrentValue, 0, FALSE);

		// exp_date
		$this->exp_date->setDbValueDef($rsnew, UnFormatDateTime($this->exp_date->CurrentValue, 0), CurrentDate(), FALSE);

		// exp_remarks
		$this->exp_remarks->setDbValueDef($rsnew, $this->exp_remarks->CurrentValue, NULL, FALSE);

		// user_id
		$this->user_id->setDbValueDef($rsnew, CurrentUserID(), NULL);
		$rsnew['user_id'] = &$this->user_id->DbValue;

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($addRow) {
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
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pem_expenseslist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL
			switch ($fld->FieldVar) {
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql <> "" && count($fld->Lookup->Options) == 0) {
				$conn = &$this->getConnection();
				$totalCnt = $this->getRecordCount($sql);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_exp_category":
							break;
						case "x_payment_type":
							break;
						case "x_exp_source":
							break;
						case "x_user_id":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
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
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
