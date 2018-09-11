<?php
namespace CetraFramework\cetra_pem;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start(); 

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$pem_accounts_list = new pem_accounts_list();

// Run the page
$pem_accounts_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_accounts_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_accounts->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fpem_accountslist = currentForm = new ew.Form("fpem_accountslist", "list");
fpem_accountslist.formKeyCountName = '<?php echo $pem_accounts_list->FormKeyCountName ?>';

// Validate form
fpem_accountslist.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
	if ($fobj.find("#confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.emptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
		<?php if ($pem_accounts_list->acc_name->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_name->caption(), $pem_accounts->acc_name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_accounts_list->acc_number->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_number");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_number->caption(), $pem_accounts->acc_number->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_accounts_list->acc_balance->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_balance");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_balance->caption(), $pem_accounts->acc_balance->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_acc_balance");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_accounts->acc_balance->errorMessage()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew.alert(ew.language.phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fpem_accountslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "acc_name", false)) return false;
	if (ew.valueChanged(fobj, infix, "acc_number", false)) return false;
	if (ew.valueChanged(fobj, infix, "acc_balance", false)) return false;
	return true;
}

// Form_CustomValidate event
fpem_accountslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_accountslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fpem_accountslistsrch = currentSearchForm = new ew.Form("fpem_accountslistsrch");

// Filters
fpem_accountslistsrch.filterList = <?php echo $pem_accounts_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_accounts->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pem_accounts_list->TotalRecs > 0 && $pem_accounts_list->ExportOptions->visible()) { ?>
<?php $pem_accounts_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_accounts_list->ImportOptions->visible()) { ?>
<?php $pem_accounts_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_accounts_list->SearchOptions->visible()) { ?>
<?php $pem_accounts_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pem_accounts_list->FilterOptions->visible()) { ?>
<?php $pem_accounts_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$pem_accounts_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pem_accounts->isExport() && !$pem_accounts->CurrentAction) { ?>
<form name="fpem_accountslistsrch" id="fpem_accountslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($pem_accounts_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fpem_accountslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pem_accounts">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($pem_accounts_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->Phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($pem_accounts_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pem_accounts_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pem_accounts_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pem_accounts_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pem_accounts_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pem_accounts_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pem_accounts_list->showPageHeader(); ?>
<?php
$pem_accounts_list->showMessage();
?>
<?php if ($pem_accounts_list->TotalRecs > 0 || $pem_accounts->CurrentAction) { ?>
<div class="ew-multi-column-grid">
<?php if (!$pem_accounts->isExport()) { ?>
<div>
<?php if (!$pem_accounts->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_accounts_list->Pager)) $pem_accounts_list->Pager = new PrevNextPager($pem_accounts_list->StartRec, $pem_accounts_list->DisplayRecs, $pem_accounts_list->TotalRecs, $pem_accounts_list->AutoHidePager) ?>
<?php if ($pem_accounts_list->Pager->RecordCount > 0 && $pem_accounts_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_accounts_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_accounts_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_accounts_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_accounts_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_accounts_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_accounts_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_accounts_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_accounts_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_accounts_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_accounts_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_accounts_list->OtherOptions as &$option)
		$option->render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpem_accountslist" id="fpem_accountslist" class="ew-horizontal ew-form ew-list-form ew-multi-column-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_accounts_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_accounts_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_accounts">
<div class="row ew-multi-column-row">
<?php if ($pem_accounts_list->TotalRecs > 0 || $pem_accounts->isGridEdit()) { ?>
<?php
if ($pem_accounts->ExportAll && $pem_accounts->isExport()) {
	$pem_accounts_list->StopRec = $pem_accounts_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pem_accounts_list->TotalRecs > $pem_accounts_list->StartRec + $pem_accounts_list->DisplayRecs - 1)
		$pem_accounts_list->StopRec = $pem_accounts_list->StartRec + $pem_accounts_list->DisplayRecs - 1;
	else
		$pem_accounts_list->StopRec = $pem_accounts_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $pem_accounts_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($pem_accounts_list->FormKeyCountName) && ($pem_accounts->isGridAdd() || $pem_accounts->isGridEdit() || $pem_accounts->isConfirm())) {
		$pem_accounts_list->KeyCount = $CurrentForm->getValue($pem_accounts_list->FormKeyCountName);
		$pem_accounts_list->StopRec = $pem_accounts_list->StartRec + $pem_accounts_list->KeyCount - 1;
	}
}
$pem_accounts_list->RecCnt = $pem_accounts_list->StartRec - 1;
if ($pem_accounts_list->Recordset && !$pem_accounts_list->Recordset->EOF) {
	$pem_accounts_list->Recordset->moveFirst();
	$selectLimit = $pem_accounts_list->UseSelectLimit;
	if (!$selectLimit && $pem_accounts_list->StartRec > 1)
		$pem_accounts_list->Recordset->move($pem_accounts_list->StartRec - 1);
} elseif (!$pem_accounts->AllowAddDeleteRow && $pem_accounts_list->StopRec == 0) {
	$pem_accounts_list->StopRec = $pem_accounts->GridAddRowCount;
}
if ($pem_accounts->isGridAdd())
	$pem_accounts_list->RowIndex = 0;
if ($pem_accounts->isGridEdit())
	$pem_accounts_list->RowIndex = 0;
while ($pem_accounts_list->RecCnt < $pem_accounts_list->StopRec) {
	$pem_accounts_list->RecCnt++;
	if ($pem_accounts_list->RecCnt >= $pem_accounts_list->StartRec) {
		$pem_accounts_list->RowCnt++;
		if ($pem_accounts->isGridAdd() || $pem_accounts->isGridEdit() || $pem_accounts->isConfirm()) {
			$pem_accounts_list->RowIndex++;
			$CurrentForm->Index = $pem_accounts_list->RowIndex;
			if ($CurrentForm->hasValue($pem_accounts_list->FormActionName) && $pem_accounts_list->EventCancelled)
				$pem_accounts_list->RowAction = strval($CurrentForm->getValue($pem_accounts_list->FormActionName));
			elseif ($pem_accounts->isGridAdd())
				$pem_accounts_list->RowAction = "insert";
			else
				$pem_accounts_list->RowAction = "";
		}

		// Set up key count
		$pem_accounts_list->KeyCount = $pem_accounts_list->RowIndex;

		// Init row class and style
		$pem_accounts->resetAttributes();
		$pem_accounts->CssClass = "";
		if ($pem_accounts->isGridAdd()) {
			$pem_accounts_list->loadRowValues(); // Load default values
		} else {
			$pem_accounts_list->loadRowValues($pem_accounts_list->Recordset); // Load row values
		}
		$pem_accounts->RowType = ROWTYPE_VIEW; // Render view
		if ($pem_accounts->isGridAdd()) // Grid add
			$pem_accounts->RowType = ROWTYPE_ADD; // Render add
		if ($pem_accounts->isGridAdd() && $pem_accounts->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$pem_accounts_list->restoreCurrentRowFormValues($pem_accounts_list->RowIndex); // Restore form values
		if ($pem_accounts->isGridEdit()) { // Grid edit
			if ($pem_accounts->EventCancelled)
				$pem_accounts_list->restoreCurrentRowFormValues($pem_accounts_list->RowIndex); // Restore form values
			if ($pem_accounts_list->RowAction == "insert")
				$pem_accounts->RowType = ROWTYPE_ADD; // Render add
			else
				$pem_accounts->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($pem_accounts->isGridEdit() && ($pem_accounts->RowType == ROWTYPE_EDIT || $pem_accounts->RowType == ROWTYPE_ADD) && $pem_accounts->EventCancelled) // Update failed
			$pem_accounts_list->restoreCurrentRowFormValues($pem_accounts_list->RowIndex); // Restore form values
		if ($pem_accounts->RowType == ROWTYPE_EDIT) // Edit row
			$pem_accounts_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pem_accounts->RowAttrs = array_merge($pem_accounts->RowAttrs, array('data-rowindex'=>$pem_accounts_list->RowCnt, 'id'=>'r' . $pem_accounts_list->RowCnt . '_pem_accounts', 'data-rowtype'=>$pem_accounts->RowType));

		// Render row
		$pem_accounts_list->renderRow();

		// Render list options
		$pem_accounts_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pem_accounts_list->RowAction <> "delete" && $pem_accounts_list->RowAction <> "insertdelete" && !($pem_accounts_list->RowAction == "insert" && $pem_accounts->isConfirm() && $pem_accounts_list->emptyRow())) {
?>
<div class="<?php echo $pem_accounts_list->getMultiColumnClass() ?>"<?php echo $pem_accounts->rowAttributes() ?>>
	<div class="card ew-card">
	<div class="card-body">
	<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
	<table class="table ew-view-table">
	<?php } ?>
	<?php if ($pem_accounts->acc_name->Visible) { // acc_name ?>
		<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_accounts_list->TableLeftColumnClass ?>"><span class="pem_accounts_acc_name">
<?php if ($pem_accounts->isExport() || $pem_accounts->sortUrl($pem_accounts->acc_name) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_accounts->acc_name->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_accounts->SortUrl($pem_accounts->acc_name) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_accounts->acc_name->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_accounts->acc_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_accounts->acc_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_name" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_name" value="<?php echo HtmlEncode($pem_accounts->acc_name->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<span<?php echo $pem_accounts->acc_name->viewAttributes() ?>>
<?php echo $pem_accounts->acc_name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_accounts_acc_name">
			<label class="<?php echo $pem_accounts_list->LeftColumnClass ?>"><?php echo $pem_accounts->acc_name->caption() ?></label>
			<div class="<?php echo $pem_accounts_list->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_name" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_name" value="<?php echo HtmlEncode($pem_accounts->acc_name->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_name">
<span<?php echo $pem_accounts->acc_name->viewAttributes() ?>>
<?php echo $pem_accounts->acc_name->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_accounts->acc_number->Visible) { // acc_number ?>
		<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_accounts_list->TableLeftColumnClass ?>"><span class="pem_accounts_acc_number">
<?php if ($pem_accounts->isExport() || $pem_accounts->sortUrl($pem_accounts->acc_number) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_accounts->acc_number->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_accounts->SortUrl($pem_accounts->acc_number) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_accounts->acc_number->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_accounts->acc_number->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_accounts->acc_number->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_number" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_number" value="<?php echo HtmlEncode($pem_accounts->acc_number->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<span<?php echo $pem_accounts->acc_number->viewAttributes() ?>>
<?php echo $pem_accounts->acc_number->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_accounts_acc_number">
			<label class="<?php echo $pem_accounts_list->LeftColumnClass ?>"><?php echo $pem_accounts->acc_number->caption() ?></label>
			<div class="<?php echo $pem_accounts_list->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_number" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_number" value="<?php echo HtmlEncode($pem_accounts->acc_number->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_number">
<span<?php echo $pem_accounts->acc_number->viewAttributes() ?>>
<?php echo $pem_accounts->acc_number->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_accounts->acc_balance->Visible) { // acc_balance ?>
		<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_accounts_list->TableLeftColumnClass ?>"><span class="pem_accounts_acc_balance">
<?php if ($pem_accounts->isExport() || $pem_accounts->sortUrl($pem_accounts->acc_balance) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_accounts->acc_balance->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_accounts->SortUrl($pem_accounts->acc_balance) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_accounts->acc_balance->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_accounts->acc_balance->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_accounts->acc_balance->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_balance" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" value="<?php echo HtmlEncode($pem_accounts->acc_balance->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<span<?php echo $pem_accounts->acc_balance->viewAttributes() ?>>
<?php echo $pem_accounts->acc_balance->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_accounts_acc_balance">
			<label class="<?php echo $pem_accounts_list->LeftColumnClass ?>"><?php echo $pem_accounts->acc_balance->caption() ?></label>
			<div class="<?php echo $pem_accounts_list->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<?php if ($pem_accounts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_balance" name="o<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="o<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" value="<?php echo HtmlEncode($pem_accounts->acc_balance->OldValue) ?>">
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" id="x<?php echo $pem_accounts_list->RowIndex ?>_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_accounts_list->RowCnt ?>_pem_accounts_acc_balance">
<span<?php echo $pem_accounts->acc_balance->viewAttributes() ?>>
<?php echo $pem_accounts->acc_balance->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_accounts->RowType == ROWTYPE_VIEW) { // View record ?>
	</table>
	<?php } ?>
	</div><!-- /.card-body -->
<?php if (!$pem_accounts_list->isExport()) { ?>
	<div class="card-footer">
		<div class="ew-multi-column-list-option">
<?php

// Render list options (body, bottom)
$pem_accounts_list->ListOptions->render("body", "bottom", $pem_accounts_list->RowCnt);
?>
		</div><!-- /.ew-multi-column-list-option -->
		<div class="clearfix"></div>
	</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
</div><!-- /.col-* -->
<?php if ($pem_accounts->RowType == ROWTYPE_ADD || $pem_accounts->RowType == ROWTYPE_EDIT) { ?>
<script>
fpem_accountslist.updateLists(<?php echo $pem_accounts_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$pem_accounts->isGridAdd())
		if (!$pem_accounts_list->Recordset->EOF)
			$pem_accounts_list->Recordset->moveNext();
}
?>
<?php } ?>
<?php if ($pem_accounts->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $pem_accounts_list->FormKeyCountName ?>" id="<?php echo $pem_accounts_list->FormKeyCountName ?>" value="<?php echo $pem_accounts_list->KeyCount ?>">
<?php echo $pem_accounts_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pem_accounts->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $pem_accounts_list->FormKeyCountName ?>" id="<?php echo $pem_accounts_list->FormKeyCountName ?>" value="<?php echo $pem_accounts_list->KeyCount ?>">
<?php echo $pem_accounts_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$pem_accounts->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-multi-column-row -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pem_accounts_list->Recordset)
	$pem_accounts_list->Recordset->Close();
?>
<?php if (!$pem_accounts->isExport()) { ?>
<div>
<?php if (!$pem_accounts->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_accounts_list->Pager)) $pem_accounts_list->Pager = new PrevNextPager($pem_accounts_list->StartRec, $pem_accounts_list->DisplayRecs, $pem_accounts_list->TotalRecs, $pem_accounts_list->AutoHidePager) ?>
<?php if ($pem_accounts_list->Pager->RecordCount > 0 && $pem_accounts_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_accounts_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_accounts_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_accounts_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_accounts_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_accounts_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_accounts_list->pageUrl() ?>start=<?php echo $pem_accounts_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_accounts_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_accounts_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_accounts_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_accounts_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_accounts_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_accounts_list->OtherOptions as &$option)
		$option->render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-multi-column-grid -->
<?php } ?>
<?php if ($pem_accounts_list->TotalRecs == 0 && !$pem_accounts->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_accounts_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pem_accounts_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_accounts->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_accounts_list->terminate();
?>
