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
$pem_exp_source_list = new pem_exp_source_list();

// Run the page
$pem_exp_source_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_exp_source_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_exp_source->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fpem_exp_sourcelist = currentForm = new ew.Form("fpem_exp_sourcelist", "list");
fpem_exp_sourcelist.formKeyCountName = '<?php echo $pem_exp_source_list->FormKeyCountName ?>';

// Validate form
fpem_exp_sourcelist.validate = function() {
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
		<?php if ($pem_exp_source_list->source_name->Required) { ?>
			elm = this.getElements("x" + infix + "_source_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_name->caption(), $pem_exp_source->source_name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_list->source_type->Required) { ?>
			elm = this.getElements("x" + infix + "_source_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_type->caption(), $pem_exp_source->source_type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_list->source_acc->Required) { ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_acc->caption(), $pem_exp_source->source_acc->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_exp_source->source_acc->errorMessage()) ?>");

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
fpem_exp_sourcelist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "source_name", false)) return false;
	if (ew.valueChanged(fobj, infix, "source_type", false)) return false;
	if (ew.valueChanged(fobj, infix, "source_acc", false)) return false;
	return true;
}

// Form_CustomValidate event
fpem_exp_sourcelist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_exp_sourcelist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_exp_sourcelist.lists["x_source_type"] = <?php echo $pem_exp_source_list->source_type->Lookup->toClientList() ?>;
fpem_exp_sourcelist.lists["x_source_type"].options = <?php echo JsonEncode($pem_exp_source_list->source_type->lookupOptions()) ?>;
fpem_exp_sourcelist.lists["x_source_acc"] = <?php echo $pem_exp_source_list->source_acc->Lookup->toClientList() ?>;
fpem_exp_sourcelist.lists["x_source_acc"].options = <?php echo JsonEncode($pem_exp_source_list->source_acc->lookupOptions()) ?>;
fpem_exp_sourcelist.autoSuggests["x_source_acc"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
var fpem_exp_sourcelistsrch = currentSearchForm = new ew.Form("fpem_exp_sourcelistsrch");

// Filters
fpem_exp_sourcelistsrch.filterList = <?php echo $pem_exp_source_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_exp_source->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pem_exp_source_list->TotalRecs > 0 && $pem_exp_source_list->ExportOptions->visible()) { ?>
<?php $pem_exp_source_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_exp_source_list->ImportOptions->visible()) { ?>
<?php $pem_exp_source_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_exp_source_list->SearchOptions->visible()) { ?>
<?php $pem_exp_source_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pem_exp_source_list->FilterOptions->visible()) { ?>
<?php $pem_exp_source_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$pem_exp_source_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pem_exp_source->isExport() && !$pem_exp_source->CurrentAction) { ?>
<form name="fpem_exp_sourcelistsrch" id="fpem_exp_sourcelistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($pem_exp_source_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fpem_exp_sourcelistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pem_exp_source">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($pem_exp_source_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->Phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($pem_exp_source_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pem_exp_source_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pem_exp_source_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pem_exp_source_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pem_exp_source_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pem_exp_source_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pem_exp_source_list->showPageHeader(); ?>
<?php
$pem_exp_source_list->showMessage();
?>
<?php if ($pem_exp_source_list->TotalRecs > 0 || $pem_exp_source->CurrentAction) { ?>
<div class="ew-multi-column-grid">
<?php if (!$pem_exp_source->isExport()) { ?>
<div>
<?php if (!$pem_exp_source->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_exp_source_list->Pager)) $pem_exp_source_list->Pager = new PrevNextPager($pem_exp_source_list->StartRec, $pem_exp_source_list->DisplayRecs, $pem_exp_source_list->TotalRecs, $pem_exp_source_list->AutoHidePager) ?>
<?php if ($pem_exp_source_list->Pager->RecordCount > 0 && $pem_exp_source_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_exp_source_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_exp_source_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_exp_source_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_exp_source_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_exp_source_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_exp_source_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_exp_source_list->OtherOptions as &$option)
		$option->render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpem_exp_sourcelist" id="fpem_exp_sourcelist" class="ew-horizontal ew-form ew-list-form ew-multi-column-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_exp_source_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_exp_source_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_exp_source">
<div class="row ew-multi-column-row">
<?php if ($pem_exp_source_list->TotalRecs > 0 || $pem_exp_source->isGridEdit()) { ?>
<?php
if ($pem_exp_source->ExportAll && $pem_exp_source->isExport()) {
	$pem_exp_source_list->StopRec = $pem_exp_source_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pem_exp_source_list->TotalRecs > $pem_exp_source_list->StartRec + $pem_exp_source_list->DisplayRecs - 1)
		$pem_exp_source_list->StopRec = $pem_exp_source_list->StartRec + $pem_exp_source_list->DisplayRecs - 1;
	else
		$pem_exp_source_list->StopRec = $pem_exp_source_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $pem_exp_source_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($pem_exp_source_list->FormKeyCountName) && ($pem_exp_source->isGridAdd() || $pem_exp_source->isGridEdit() || $pem_exp_source->isConfirm())) {
		$pem_exp_source_list->KeyCount = $CurrentForm->getValue($pem_exp_source_list->FormKeyCountName);
		$pem_exp_source_list->StopRec = $pem_exp_source_list->StartRec + $pem_exp_source_list->KeyCount - 1;
	}
}
$pem_exp_source_list->RecCnt = $pem_exp_source_list->StartRec - 1;
if ($pem_exp_source_list->Recordset && !$pem_exp_source_list->Recordset->EOF) {
	$pem_exp_source_list->Recordset->moveFirst();
	$selectLimit = $pem_exp_source_list->UseSelectLimit;
	if (!$selectLimit && $pem_exp_source_list->StartRec > 1)
		$pem_exp_source_list->Recordset->move($pem_exp_source_list->StartRec - 1);
} elseif (!$pem_exp_source->AllowAddDeleteRow && $pem_exp_source_list->StopRec == 0) {
	$pem_exp_source_list->StopRec = $pem_exp_source->GridAddRowCount;
}
if ($pem_exp_source->isGridAdd())
	$pem_exp_source_list->RowIndex = 0;
if ($pem_exp_source->isGridEdit())
	$pem_exp_source_list->RowIndex = 0;
while ($pem_exp_source_list->RecCnt < $pem_exp_source_list->StopRec) {
	$pem_exp_source_list->RecCnt++;
	if ($pem_exp_source_list->RecCnt >= $pem_exp_source_list->StartRec) {
		$pem_exp_source_list->RowCnt++;
		if ($pem_exp_source->isGridAdd() || $pem_exp_source->isGridEdit() || $pem_exp_source->isConfirm()) {
			$pem_exp_source_list->RowIndex++;
			$CurrentForm->Index = $pem_exp_source_list->RowIndex;
			if ($CurrentForm->hasValue($pem_exp_source_list->FormActionName) && $pem_exp_source_list->EventCancelled)
				$pem_exp_source_list->RowAction = strval($CurrentForm->getValue($pem_exp_source_list->FormActionName));
			elseif ($pem_exp_source->isGridAdd())
				$pem_exp_source_list->RowAction = "insert";
			else
				$pem_exp_source_list->RowAction = "";
		}

		// Set up key count
		$pem_exp_source_list->KeyCount = $pem_exp_source_list->RowIndex;

		// Init row class and style
		$pem_exp_source->resetAttributes();
		$pem_exp_source->CssClass = "";
		if ($pem_exp_source->isGridAdd()) {
			$pem_exp_source_list->loadRowValues(); // Load default values
		} else {
			$pem_exp_source_list->loadRowValues($pem_exp_source_list->Recordset); // Load row values
		}
		$pem_exp_source->RowType = ROWTYPE_VIEW; // Render view
		if ($pem_exp_source->isGridAdd()) // Grid add
			$pem_exp_source->RowType = ROWTYPE_ADD; // Render add
		if ($pem_exp_source->isGridAdd() && $pem_exp_source->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$pem_exp_source_list->restoreCurrentRowFormValues($pem_exp_source_list->RowIndex); // Restore form values
		if ($pem_exp_source->isGridEdit()) { // Grid edit
			if ($pem_exp_source->EventCancelled)
				$pem_exp_source_list->restoreCurrentRowFormValues($pem_exp_source_list->RowIndex); // Restore form values
			if ($pem_exp_source_list->RowAction == "insert")
				$pem_exp_source->RowType = ROWTYPE_ADD; // Render add
			else
				$pem_exp_source->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($pem_exp_source->isGridEdit() && ($pem_exp_source->RowType == ROWTYPE_EDIT || $pem_exp_source->RowType == ROWTYPE_ADD) && $pem_exp_source->EventCancelled) // Update failed
			$pem_exp_source_list->restoreCurrentRowFormValues($pem_exp_source_list->RowIndex); // Restore form values
		if ($pem_exp_source->RowType == ROWTYPE_EDIT) // Edit row
			$pem_exp_source_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pem_exp_source->RowAttrs = array_merge($pem_exp_source->RowAttrs, array('data-rowindex'=>$pem_exp_source_list->RowCnt, 'id'=>'r' . $pem_exp_source_list->RowCnt . '_pem_exp_source', 'data-rowtype'=>$pem_exp_source->RowType));

		// Render row
		$pem_exp_source_list->renderRow();

		// Render list options
		$pem_exp_source_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pem_exp_source_list->RowAction <> "delete" && $pem_exp_source_list->RowAction <> "insertdelete" && !($pem_exp_source_list->RowAction == "insert" && $pem_exp_source->isConfirm() && $pem_exp_source_list->emptyRow())) {
?>
<div class="<?php echo $pem_exp_source_list->getMultiColumnClass() ?>"<?php echo $pem_exp_source->rowAttributes() ?>>
	<div class="card ew-card">
	<div class="card-body">
	<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
	<table class="table ew-view-table">
	<?php } ?>
	<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
		<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_exp_source_list->TableLeftColumnClass ?>"><span class="pem_exp_source_source_name">
<?php if ($pem_exp_source->isExport() || $pem_exp_source->sortUrl($pem_exp_source->source_name) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_exp_source->source_name->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_exp_source->SortUrl($pem_exp_source->source_name) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_exp_source->source_name->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_exp_source->source_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_exp_source->source_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_name" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_name" value="<?php echo HtmlEncode($pem_exp_source->source_name->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<span<?php echo $pem_exp_source->source_name->viewAttributes() ?>>
<?php echo $pem_exp_source->source_name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_exp_source_source_name">
			<label class="<?php echo $pem_exp_source_list->LeftColumnClass ?>"><?php echo $pem_exp_source->source_name->caption() ?></label>
			<div class="<?php echo $pem_exp_source_list->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_name" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_name" value="<?php echo HtmlEncode($pem_exp_source->source_name->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_name">
<span<?php echo $pem_exp_source->source_name->viewAttributes() ?>>
<?php echo $pem_exp_source->source_name->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
		<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_exp_source_list->TableLeftColumnClass ?>"><span class="pem_exp_source_source_type">
<?php if ($pem_exp_source->isExport() || $pem_exp_source->sortUrl($pem_exp_source->source_type) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_exp_source->source_type->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_exp_source->SortUrl($pem_exp_source->source_type) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_exp_source->source_type->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_exp_source->source_type->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_exp_source->source_type->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?php echo $pem_exp_source_list->RowIndex ?>_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_type" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_type" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_type" value="<?php echo HtmlEncode($pem_exp_source->source_type->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?php echo $pem_exp_source_list->RowIndex ?>_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<span<?php echo $pem_exp_source->source_type->viewAttributes() ?>>
<?php echo $pem_exp_source->source_type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_exp_source_source_type">
			<label class="<?php echo $pem_exp_source_list->LeftColumnClass ?>"><?php echo $pem_exp_source->source_type->caption() ?></label>
			<div class="<?php echo $pem_exp_source_list->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?php echo $pem_exp_source_list->RowIndex ?>_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_type" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_type" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_type" value="<?php echo HtmlEncode($pem_exp_source->source_type->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?php echo $pem_exp_source_list->RowIndex ?>_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?php echo $pem_exp_source_list->RowIndex ?>_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_type">
<span<?php echo $pem_exp_source->source_type->viewAttributes() ?>>
<?php echo $pem_exp_source->source_type->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
		<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
		<tr>
			<td class="ew-table-header <?php echo $pem_exp_source_list->TableLeftColumnClass ?>"><span class="pem_exp_source_source_acc">
<?php if ($pem_exp_source->isExport() || $pem_exp_source->sortUrl($pem_exp_source->source_acc) == "") { ?>
				<div class="ew-table-header-caption"><?php echo $pem_exp_source->source_acc->caption() ?></div>
<?php } else { ?>
				<div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_exp_source->SortUrl($pem_exp_source->source_acc) ?>',1);">
				<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_exp_source->source_acc->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_exp_source->source_acc->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_exp_source->source_acc->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
				</div>
<?php } ?>
			</span></td>
			<td<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<?php
$wrkonchange = "" . trim(@$pem_exp_source->source_acc->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$pem_exp_source->source_acc->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" class="text-nowrap" style="z-index: <?php echo (9000 - $pem_exp_source_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo RemoveHtml($pem_exp_source->source_acc->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>"<?php echo $pem_exp_source->source_acc->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" data-value-separator="<?php echo $pem_exp_source->source_acc->displayValueSeparatorAttribute() ?>" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fpem_exp_sourcelist.createAutoSuggest({"id":"x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc") ?>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<?php
$wrkonchange = "" . trim(@$pem_exp_source->source_acc->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$pem_exp_source->source_acc->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" class="text-nowrap" style="z-index: <?php echo (9000 - $pem_exp_source_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo RemoveHtml($pem_exp_source->source_acc->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>"<?php echo $pem_exp_source->source_acc->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" data-value-separator="<?php echo $pem_exp_source->source_acc->displayValueSeparatorAttribute() ?>" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fpem_exp_sourcelist.createAutoSuggest({"id":"x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc") ?>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<span<?php echo $pem_exp_source->source_acc->viewAttributes() ?>>
<?php echo $pem_exp_source->source_acc->getViewValue() ?></span>
</span>
<?php } ?>
</td>
		</tr>
		<?php } else { // Add/edit record ?>
		<div class="form-group row pem_exp_source_source_acc">
			<label class="<?php echo $pem_exp_source_list->LeftColumnClass ?>"><?php echo $pem_exp_source->source_acc->caption() ?></label>
			<div class="<?php echo $pem_exp_source_list->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<?php
$wrkonchange = "" . trim(@$pem_exp_source->source_acc->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$pem_exp_source->source_acc->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" class="text-nowrap" style="z-index: <?php echo (9000 - $pem_exp_source_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo RemoveHtml($pem_exp_source->source_acc->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>"<?php echo $pem_exp_source->source_acc->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" data-value-separator="<?php echo $pem_exp_source->source_acc->displayValueSeparatorAttribute() ?>" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fpem_exp_sourcelist.createAutoSuggest({"id":"x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc") ?>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" name="o<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="o<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->OldValue) ?>">
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<?php
$wrkonchange = "" . trim(@$pem_exp_source->source_acc->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$pem_exp_source->source_acc->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" class="text-nowrap" style="z-index: <?php echo (9000 - $pem_exp_source_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="sv_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo RemoveHtml($pem_exp_source->source_acc->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>"<?php echo $pem_exp_source->source_acc->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" data-value-separator="<?php echo $pem_exp_source->source_acc->displayValueSeparatorAttribute() ?>" name="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" id="x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fpem_exp_sourcelist.createAutoSuggest({"id":"x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x<?php echo $pem_exp_source_list->RowIndex ?>_source_acc") ?>
</span>
<?php } ?>
<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_exp_source_list->RowCnt ?>_pem_exp_source_source_acc">
<span<?php echo $pem_exp_source->source_acc->viewAttributes() ?>>
<?php echo $pem_exp_source->source_acc->getViewValue() ?></span>
</span>
<?php } ?>
</div></div>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pem_exp_source->RowType == ROWTYPE_VIEW) { // View record ?>
	</table>
	<?php } ?>
	</div><!-- /.card-body -->
<?php if (!$pem_exp_source_list->isExport()) { ?>
	<div class="card-footer">
		<div class="ew-multi-column-list-option">
<?php

// Render list options (body, bottom)
$pem_exp_source_list->ListOptions->render("body", "bottom", $pem_exp_source_list->RowCnt);
?>
		</div><!-- /.ew-multi-column-list-option -->
		<div class="clearfix"></div>
	</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
</div><!-- /.col-* -->
<?php if ($pem_exp_source->RowType == ROWTYPE_ADD || $pem_exp_source->RowType == ROWTYPE_EDIT) { ?>
<script>
fpem_exp_sourcelist.updateLists(<?php echo $pem_exp_source_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$pem_exp_source->isGridAdd())
		if (!$pem_exp_source_list->Recordset->EOF)
			$pem_exp_source_list->Recordset->moveNext();
}
?>
<?php } ?>
<?php if ($pem_exp_source->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $pem_exp_source_list->FormKeyCountName ?>" id="<?php echo $pem_exp_source_list->FormKeyCountName ?>" value="<?php echo $pem_exp_source_list->KeyCount ?>">
<?php echo $pem_exp_source_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pem_exp_source->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $pem_exp_source_list->FormKeyCountName ?>" id="<?php echo $pem_exp_source_list->FormKeyCountName ?>" value="<?php echo $pem_exp_source_list->KeyCount ?>">
<?php echo $pem_exp_source_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$pem_exp_source->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-multi-column-row -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pem_exp_source_list->Recordset)
	$pem_exp_source_list->Recordset->Close();
?>
<?php if (!$pem_exp_source->isExport()) { ?>
<div>
<?php if (!$pem_exp_source->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_exp_source_list->Pager)) $pem_exp_source_list->Pager = new PrevNextPager($pem_exp_source_list->StartRec, $pem_exp_source_list->DisplayRecs, $pem_exp_source_list->TotalRecs, $pem_exp_source_list->AutoHidePager) ?>
<?php if ($pem_exp_source_list->Pager->RecordCount > 0 && $pem_exp_source_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_exp_source_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_exp_source_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_exp_source_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_exp_source_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_exp_source_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_exp_source_list->pageUrl() ?>start=<?php echo $pem_exp_source_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_exp_source_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_exp_source_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_exp_source_list->OtherOptions as &$option)
		$option->render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-multi-column-grid -->
<?php } ?>
<?php if ($pem_exp_source_list->TotalRecs == 0 && !$pem_exp_source->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_exp_source_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pem_exp_source_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_exp_source->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_exp_source_list->terminate();
?>
