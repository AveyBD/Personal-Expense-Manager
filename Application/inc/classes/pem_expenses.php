<?php
namespace CetraFramework\cetra_pem;

/**
 * Table class for pem_expenses
 */
class pem_expenses extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $exp_id;
	public $exp_item;
	public $exp_category;
	public $payment_type;
	public $exp_source;
	public $exp_amount;
	public $exp_date;
	public $exp_remarks;
	public $user_id;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'pem_expenses';
		$this->TableName = 'pem_expenses';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pem_expenses`";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// exp_id
		$this->exp_id = new DbField('pem_expenses', 'pem_expenses', 'x_exp_id', 'exp_id', '`exp_id`', '`exp_id`', 3, -1, FALSE, '`exp_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->exp_id->IsAutoIncrement = TRUE; // Autoincrement field
		$this->exp_id->IsPrimaryKey = TRUE; // Primary key field
		$this->exp_id->Sortable = TRUE; // Allow sort
		$this->exp_id->DefaultErrorMessage = $Language->Phrase("IncorrectInteger");
		$this->fields['exp_id'] = &$this->exp_id;

		// exp_item
		$this->exp_item = new DbField('pem_expenses', 'pem_expenses', 'x_exp_item', 'exp_item', '`exp_item`', '`exp_item`', 201, -1, FALSE, '`exp_item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exp_item->Nullable = FALSE; // NOT NULL field
		$this->exp_item->Required = TRUE; // Required field
		$this->exp_item->Sortable = TRUE; // Allow sort
		$this->fields['exp_item'] = &$this->exp_item;

		// exp_category
		$this->exp_category = new DbField('pem_expenses', 'pem_expenses', 'x_exp_category', 'exp_category', '`exp_category`', '`exp_category`', 3, -1, FALSE, '`exp_category`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->exp_category->Nullable = FALSE; // NOT NULL field
		$this->exp_category->Required = TRUE; // Required field
		$this->exp_category->Sortable = TRUE; // Allow sort
		$this->exp_category->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->exp_category->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->exp_category->Lookup = new Lookup('exp_category', 'pem_categories', FALSE, 'cat_id', ["category","","",""], [], [], [], [], [], '', '');
		$this->exp_category->DefaultErrorMessage = $Language->Phrase("IncorrectInteger");
		$this->fields['exp_category'] = &$this->exp_category;

		// payment_type
		$this->payment_type = new DbField('pem_expenses', 'pem_expenses', 'x_payment_type', 'payment_type', '`payment_type`', '`payment_type`', 3, -1, FALSE, '`payment_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->payment_type->Sortable = TRUE; // Allow sort
		$this->payment_type->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->payment_type->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->payment_type->Lookup = new Lookup('payment_type', 'pem_payment_type', FALSE, 'type_id', ["payment_type","","",""], [], ["x_exp_source"], [], [], [], '', '');
		$this->payment_type->DefaultErrorMessage = $Language->Phrase("IncorrectInteger");
		$this->fields['payment_type'] = &$this->payment_type;

		// exp_source
		$this->exp_source = new DbField('pem_expenses', 'pem_expenses', 'x_exp_source', 'exp_source', '`exp_source`', '`exp_source`', 3, -1, FALSE, '`exp_source`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->exp_source->Nullable = FALSE; // NOT NULL field
		$this->exp_source->Required = TRUE; // Required field
		$this->exp_source->Sortable = TRUE; // Allow sort
		$this->exp_source->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->exp_source->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->exp_source->Lookup = new Lookup('exp_source', 'pem_exp_source', FALSE, 'source_id', ["source_name","","",""], ["x_payment_type"], [], ["source_type"], [], [], '', '');
		$this->exp_source->DefaultErrorMessage = $Language->Phrase("IncorrectInteger");
		$this->fields['exp_source'] = &$this->exp_source;

		// exp_amount
		$this->exp_amount = new DbField('pem_expenses', 'pem_expenses', 'x_exp_amount', 'exp_amount', '`exp_amount`', '`exp_amount`', 131, -1, FALSE, '`exp_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exp_amount->Nullable = FALSE; // NOT NULL field
		$this->exp_amount->Required = TRUE; // Required field
		$this->exp_amount->Sortable = TRUE; // Allow sort
		$this->exp_amount->DefaultErrorMessage = $Language->Phrase("IncorrectFloat");
		$this->fields['exp_amount'] = &$this->exp_amount;

		// exp_date
		$this->exp_date = new DbField('pem_expenses', 'pem_expenses', 'x_exp_date', 'exp_date', '`exp_date`', CastDateFieldForLike('`exp_date`', 0, "DB"), 133, 0, FALSE, '`exp_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exp_date->Nullable = FALSE; // NOT NULL field
		$this->exp_date->Required = TRUE; // Required field
		$this->exp_date->Sortable = TRUE; // Allow sort
		$this->exp_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['exp_date'] = &$this->exp_date;

		// exp_remarks
		$this->exp_remarks = new DbField('pem_expenses', 'pem_expenses', 'x_exp_remarks', 'exp_remarks', '`exp_remarks`', '`exp_remarks`', 201, -1, FALSE, '`exp_remarks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exp_remarks->Sortable = TRUE; // Allow sort
		$this->fields['exp_remarks'] = &$this->exp_remarks;

		// user_id
		$this->user_id = new DbField('pem_expenses', 'pem_expenses', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->user_id->Sortable = TRUE; // Allow sort
		$this->user_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->user_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->user_id->Lookup = new Lookup('user_id', 'users', FALSE, 'id', ["name","login","",""], [], [], [], [], [], '', '');
		$this->user_id->DefaultErrorMessage = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Single column sort
	public function updateSort(&$fld)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
		} else {
			$fld->setSort("");
		}
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`pem_expenses`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect <> "") ? $this->SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere <> "") ? $this->SqlWhere : "";
		$this->TableFilter = "";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy <> "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving <> "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy <> "") ? $this->SqlOrderBy : "`exp_date` DESC,`exp_id` DESC";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter)
	{
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = USER_ID_ALLOW;
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
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count
	public function getRecordCount($sql)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery and SELECT DISTINCT
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) && !preg_match('/^\s*select\s+distinct\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = &$this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->getRecordCount($sql);
		$this->CurrentFilter = $origFilter;
		return $cnt;
	}

	// Get record count (for current List page)
	public function listRecordCount()
	{
		$filter = $this->getSessionWhere();
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {

			// Get insert id if necessary
			$this->exp_id->setDbValue($conn->insert_ID());
			$rs['exp_id'] = $this->exp_id->DbValue;
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsPrimaryKey)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('exp_id', $rs))
				AddFilter($where, QuotedName('exp_id', $this->Dbid) . '=' . QuotedValue($rs['exp_id'], $this->exp_id->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = &$this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->exp_id->DbValue = $row['exp_id'];
		$this->exp_item->DbValue = $row['exp_item'];
		$this->exp_category->DbValue = $row['exp_category'];
		$this->payment_type->DbValue = $row['payment_type'];
		$this->exp_source->DbValue = $row['exp_source'];
		$this->exp_amount->DbValue = $row['exp_amount'];
		$this->exp_date->DbValue = $row['exp_date'];
		$this->exp_remarks->DbValue = $row['exp_remarks'];
		$this->user_id->DbValue = $row['user_id'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`exp_id` = @exp_id@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('exp_id', $row) ? $row['exp_id'] : NULL) : $this->exp_id->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@exp_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") <> "" && ReferPageName() <> CurrentPageName() && ReferPageName() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "pem_expenseslist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "pem_expensesview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "pem_expensesedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "pem_expensesadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "pem_expenseslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("pem_expensesview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("pem_expensesview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "pem_expensesadd.php?" . $this->getUrlParm($parm);
		else
			$url = "pem_expensesadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("pem_expensesedit.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("pem_expensesadd.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("pem_expensesdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "exp_id:" . JsonEncode($this->exp_id->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm <> "")
			$url .= $parm . "&";
		if ($this->exp_id->CurrentValue != NULL) {
			$url .= "exp_id=" . urlencode($this->exp_id->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("exp_id") !== NULL)
				$arKeys[] = Param("exp_id");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
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

	// Get filter from record keys
	public function getFilterFromRecordKeys()
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter <> "") $keyFilter .= " OR ";
			$this->exp_id->CurrentValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = &$this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->exp_id->setDbValue($rs->fields('exp_id'));
		$this->exp_item->setDbValue($rs->fields('exp_item'));
		$this->exp_category->setDbValue($rs->fields('exp_category'));
		$this->payment_type->setDbValue($rs->fields('payment_type'));
		$this->exp_source->setDbValue($rs->fields('exp_source'));
		$this->exp_amount->setDbValue($rs->fields('exp_amount'));
		$this->exp_date->setDbValue($rs->fields('exp_date'));
		$this->exp_remarks->setDbValue($rs->fields('exp_remarks'));
		$this->user_id->setDbValue($rs->fields('user_id'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// exp_id
		// exp_item
		// exp_category
		// payment_type
		// exp_source
		// exp_amount
		// exp_date
		// exp_remarks
		// user_id
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

		// exp_id
		$this->exp_id->LinkCustomAttributes = "";
		$this->exp_id->HrefValue = "";
		$this->exp_id->TooltipValue = "";

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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// exp_id
		$this->exp_id->EditAttrs["class"] = "form-control";
		$this->exp_id->EditCustomAttributes = "";
		$this->exp_id->EditValue = $this->exp_id->CurrentValue;
		$this->exp_id->ViewCustomAttributes = "";

		// exp_item
		$this->exp_item->EditAttrs["class"] = "form-control";
		$this->exp_item->EditCustomAttributes = "";
		$this->exp_item->EditValue = $this->exp_item->CurrentValue;
		$this->exp_item->PlaceHolder = RemoveHtml($this->exp_item->caption());

		// exp_category
		$this->exp_category->EditAttrs["class"] = "form-control";
		$this->exp_category->EditCustomAttributes = "";

		// payment_type
		$this->payment_type->EditAttrs["class"] = "form-control";
		$this->payment_type->EditCustomAttributes = "";

		// exp_source
		$this->exp_source->EditAttrs["class"] = "form-control";
		$this->exp_source->EditCustomAttributes = "";

		// exp_amount
		$this->exp_amount->EditAttrs["class"] = "form-control";
		$this->exp_amount->EditCustomAttributes = "";
		$this->exp_amount->EditValue = $this->exp_amount->CurrentValue;
		$this->exp_amount->PlaceHolder = RemoveHtml($this->exp_amount->caption());
		if (strval($this->exp_amount->EditValue) <> "" && is_numeric($this->exp_amount->EditValue))
			$this->exp_amount->EditValue = FormatNumber($this->exp_amount->EditValue, -2, -2, -2, -2);

		// exp_date
		$this->exp_date->EditAttrs["class"] = "form-control";
		$this->exp_date->EditCustomAttributes = "";
		$this->exp_date->EditValue = FormatDateTime($this->exp_date->CurrentValue, 8);
		$this->exp_date->PlaceHolder = RemoveHtml($this->exp_date->caption());

		// exp_remarks
		$this->exp_remarks->EditAttrs["class"] = "form-control";
		$this->exp_remarks->EditCustomAttributes = "";
		$this->exp_remarks->EditValue = $this->exp_remarks->CurrentValue;
		$this->exp_remarks->PlaceHolder = RemoveHtml($this->exp_remarks->caption());

		// user_id
		// Call Row Rendered event

		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					if ($this->exp_id->Exportable)
						$doc->exportCaption($this->exp_id);
					if ($this->exp_item->Exportable)
						$doc->exportCaption($this->exp_item);
					if ($this->exp_category->Exportable)
						$doc->exportCaption($this->exp_category);
					if ($this->payment_type->Exportable)
						$doc->exportCaption($this->payment_type);
					if ($this->exp_source->Exportable)
						$doc->exportCaption($this->exp_source);
					if ($this->exp_amount->Exportable)
						$doc->exportCaption($this->exp_amount);
					if ($this->exp_date->Exportable)
						$doc->exportCaption($this->exp_date);
					if ($this->exp_remarks->Exportable)
						$doc->exportCaption($this->exp_remarks);
					if ($this->user_id->Exportable)
						$doc->exportCaption($this->user_id);
				} else {
					if ($this->exp_id->Exportable)
						$doc->exportCaption($this->exp_id);
					if ($this->exp_item->Exportable)
						$doc->exportCaption($this->exp_item);
					if ($this->exp_category->Exportable)
						$doc->exportCaption($this->exp_category);
					if ($this->payment_type->Exportable)
						$doc->exportCaption($this->payment_type);
					if ($this->exp_source->Exportable)
						$doc->exportCaption($this->exp_source);
					if ($this->exp_amount->Exportable)
						$doc->exportCaption($this->exp_amount);
					if ($this->exp_date->Exportable)
						$doc->exportCaption($this->exp_date);
					if ($this->user_id->Exportable)
						$doc->exportCaption($this->user_id);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						if ($this->exp_id->Exportable)
							$doc->exportField($this->exp_id);
						if ($this->exp_item->Exportable)
							$doc->exportField($this->exp_item);
						if ($this->exp_category->Exportable)
							$doc->exportField($this->exp_category);
						if ($this->payment_type->Exportable)
							$doc->exportField($this->payment_type);
						if ($this->exp_source->Exportable)
							$doc->exportField($this->exp_source);
						if ($this->exp_amount->Exportable)
							$doc->exportField($this->exp_amount);
						if ($this->exp_date->Exportable)
							$doc->exportField($this->exp_date);
						if ($this->exp_remarks->Exportable)
							$doc->exportField($this->exp_remarks);
						if ($this->user_id->Exportable)
							$doc->exportField($this->user_id);
					} else {
						if ($this->exp_id->Exportable)
							$doc->exportField($this->exp_id);
						if ($this->exp_item->Exportable)
							$doc->exportField($this->exp_item);
						if ($this->exp_category->Exportable)
							$doc->exportField($this->exp_category);
						if ($this->payment_type->Exportable)
							$doc->exportField($this->payment_type);
						if ($this->exp_source->Exportable)
							$doc->exportField($this->exp_source);
						if ($this->exp_amount->Exportable)
							$doc->exportField($this->exp_amount);
						if ($this->exp_date->Exportable)
							$doc->exportField($this->exp_date);
						if ($this->user_id->Exportable)
							$doc->exportField($this->user_id);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// Lookup data from table
	public function lookup()
	{
		global $Security, $RequestSecurity;

		// Check token first
		$func = PROJECT_NAMESPACE . "CheckToken";
		$validRequest = FALSE;
		if (is_callable($func) && Post(TOKEN_NAME) !== NULL) {
			$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			if ($validRequest) {
				if (!isset($Security)) {
					if (session_status() !== PHP_SESSION_ACTIVE)
						session_start(); // Init session data
					$Security = new AdvancedSecurity();
					if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
					$Security->loadCurrentUserLevel(PROJECT_ID . $this->TableName);
					if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
					$validRequest = $Security->canList(); // List permission
					if ($validRequest) {
						$Security->UserID_Loading();
						$Security->loadUserID();
						$Security->UserID_Loaded();
						if (strval($Security->currentUserID()) == "")
							$validRequest = FALSE;
					}
				}
			}
		} else {

			// User profile
			$UserProfile = new UserProfile();

			// Security
			$Security = new AdvancedSecurity();
			if (is_array($RequestSecurity)) // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
			$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel(CurrentProjectID() . $this->TableName);
			$Security->TablePermission_Loaded();
			$validRequest = $Security->canList(); // List permission
		}

		// Reject invalid request
		if (!$validRequest)
			return FALSE;

		// Load lookup parameters
		$distinct = ConvertToBool(Post("distinct"));
		$linkField = Post("linkField");
		$displayFields = Post("displayFields");
		$parentFields = Post("parentFields");
		if (!is_array($parentFields))
			$parentFields = [];
		$childFields = Post("childFields");
		if (!is_array($childFields))
			$childFields = [];
		$filterFields = Post("filterFields");
		if (!is_array($filterFields))
			$filterFields = [];
		$filterOperators = Post("filterOperators");
		if (!is_array($filterOperators))
			$filterOperators = [];
		$autoFillSourceFields = Post("autoFillSourceFields");
		if (!is_array($autoFillSourceFields))
			$autoFillSourceFields = [];
		$formatAutoFill = FALSE;
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Get("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = AUTO_SUGGEST_MAX_ENTRIES;
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));

		// Create lookup object and output JSON
		$lookup = new Lookup($linkField, $this->TableVar, $distinct, $linkField, $displayFields, $parentFields, $childFields, $filterFields, $autoFillSourceFields);
		foreach ($filterFields as $i => $filterField) { // Set up filter operators
			if (@$filterOperators[$i] <> "")
				$lookup->setFilterOperator($filterField, $filterOperators[$i]);
		}
		$lookup->LookupType = $lookupType; // Lookup type
		$lookup->FilterValues[] = rawurldecode(Post("v0", Post("lookupValue", ""))); // Lookup values
		$cnt = is_array($filterFields) ? count($filterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = rawurldecode(Post("v" . $i, ""));
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect <> "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter <> "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy <> "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson();
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = THUMBNAIL_DEFAULT_WIDTH, $height = THUMBNAIL_DEFAULT_HEIGHT)
	{

		// No binary fields
		return FALSE;
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
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
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
