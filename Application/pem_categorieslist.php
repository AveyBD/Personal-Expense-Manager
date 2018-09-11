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
$pem_categories_list = new pem_categories_list();

// Run the page
$pem_categories_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_categories_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_categories->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fpem_categorieslist = currentForm = new ew.Form("fpem_categorieslist", "list");
fpem_categorieslist.formKeyCountName = '<?php echo $pem_categories_list->FormKeyCountName ?>';

// Validate form
fpem_categorieslist.validate = function() {
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
		<?php if ($pem_categories_list->category->Required) { ?>
			elm = this.getElements("x" + infix + "_category");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->category->caption(), $pem_categories->category->RequiredErrorMessage)) ?>");
		<?php } ?>

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
fpem_categorieslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "category", false)) return false;
	return true;
}

// Form_CustomValidate event
fpem_categorieslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_categorieslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fpem_categorieslistsrch = currentSearchForm = new ew.Form("fpem_categorieslistsrch");

// Filters
fpem_categorieslistsrch.filterList = <?php echo $pem_categories_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_categories->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pem_categories_list->TotalRecs > 0 && $pem_categories_list->ExportOptions->visible()) { ?>
<?php $pem_categories_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_categories_list->ImportOptions->visible()) { ?>
<?php $pem_categories_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_categories_list->SearchOptions->visible()) { ?>
<?php $pem_categories_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pem_categories_list->FilterOptions->visible()) { ?>
<?php $pem_categories_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$pem_categories_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pem_categories->isExport() && !$pem_categories->CurrentAction) { ?>
<form name="fpem_categorieslistsrch" id="fpem_categorieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($pem_categories_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fpem_categorieslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pem_categories">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($pem_categories_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->Phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($pem_categories_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pem_categories_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pem_categories_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pem_categories_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pem_categories_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pem_categories_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pem_categories_list->showPageHeader(); ?>
<?php
$pem_categories_list->showMessage();
?>
<?php if ($pem_categories_list->TotalRecs > 0 || $pem_categories->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($pem_categories_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pem_categories">
<?php if (!$pem_categories->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$pem_categories->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_categories_list->Pager)) $pem_categories_list->Pager = new PrevNextPager($pem_categories_list->StartRec, $pem_categories_list->DisplayRecs, $pem_categories_list->TotalRecs, $pem_categories_list->AutoHidePager) ?>
<?php if ($pem_categories_list->Pager->RecordCount > 0 && $pem_categories_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_categories_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_categories_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_categories_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_categories_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_categories_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_categories_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_categories_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_categories_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_categories_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_categories_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_categories_list->OtherOptions as &$option)
		$option->render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpem_categorieslist" id="fpem_categorieslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_categories_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_categories_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_categories">
<div id="gmp_pem_categories" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($pem_categories_list->TotalRecs > 0 || $pem_categories->isGridEdit()) { ?>
<table id="tbl_pem_categorieslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$pem_categories_list->RowType = ROWTYPE_HEADER;

// Render list options
$pem_categories_list->renderListOptions();

// Render list options (header, left)
$pem_categories_list->ListOptions->render("header", "left");
?>
<?php if ($pem_categories->category->Visible) { // category ?>
	<?php if ($pem_categories->sortUrl($pem_categories->category) == "") { ?>
		<th data-name="category" class="<?php echo $pem_categories->category->headerCellClass() ?>"><div id="elh_pem_categories_category" class="pem_categories_category"><div class="ew-table-header-caption"><?php echo $pem_categories->category->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="category" class="<?php echo $pem_categories->category->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_categories->SortUrl($pem_categories->category) ?>',1);"><div id="elh_pem_categories_category" class="pem_categories_category">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_categories->category->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_categories->category->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_categories->category->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pem_categories_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pem_categories->ExportAll && $pem_categories->isExport()) {
	$pem_categories_list->StopRec = $pem_categories_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pem_categories_list->TotalRecs > $pem_categories_list->StartRec + $pem_categories_list->DisplayRecs - 1)
		$pem_categories_list->StopRec = $pem_categories_list->StartRec + $pem_categories_list->DisplayRecs - 1;
	else
		$pem_categories_list->StopRec = $pem_categories_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $pem_categories_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($pem_categories_list->FormKeyCountName) && ($pem_categories->isGridAdd() || $pem_categories->isGridEdit() || $pem_categories->isConfirm())) {
		$pem_categories_list->KeyCount = $CurrentForm->getValue($pem_categories_list->FormKeyCountName);
		$pem_categories_list->StopRec = $pem_categories_list->StartRec + $pem_categories_list->KeyCount - 1;
	}
}
$pem_categories_list->RecCnt = $pem_categories_list->StartRec - 1;
if ($pem_categories_list->Recordset && !$pem_categories_list->Recordset->EOF) {
	$pem_categories_list->Recordset->moveFirst();
	$selectLimit = $pem_categories_list->UseSelectLimit;
	if (!$selectLimit && $pem_categories_list->StartRec > 1)
		$pem_categories_list->Recordset->move($pem_categories_list->StartRec - 1);
} elseif (!$pem_categories->AllowAddDeleteRow && $pem_categories_list->StopRec == 0) {
	$pem_categories_list->StopRec = $pem_categories->GridAddRowCount;
}

// Initialize aggregate
$pem_categories->RowType = ROWTYPE_AGGREGATEINIT;
$pem_categories->resetAttributes();
$pem_categories_list->renderRow();
if ($pem_categories->isGridAdd())
	$pem_categories_list->RowIndex = 0;
if ($pem_categories->isGridEdit())
	$pem_categories_list->RowIndex = 0;
while ($pem_categories_list->RecCnt < $pem_categories_list->StopRec) {
	$pem_categories_list->RecCnt++;
	if ($pem_categories_list->RecCnt >= $pem_categories_list->StartRec) {
		$pem_categories_list->RowCnt++;
		if ($pem_categories->isGridAdd() || $pem_categories->isGridEdit() || $pem_categories->isConfirm()) {
			$pem_categories_list->RowIndex++;
			$CurrentForm->Index = $pem_categories_list->RowIndex;
			if ($CurrentForm->hasValue($pem_categories_list->FormActionName) && $pem_categories_list->EventCancelled)
				$pem_categories_list->RowAction = strval($CurrentForm->getValue($pem_categories_list->FormActionName));
			elseif ($pem_categories->isGridAdd())
				$pem_categories_list->RowAction = "insert";
			else
				$pem_categories_list->RowAction = "";
		}

		// Set up key count
		$pem_categories_list->KeyCount = $pem_categories_list->RowIndex;

		// Init row class and style
		$pem_categories->resetAttributes();
		$pem_categories->CssClass = "";
		if ($pem_categories->isGridAdd()) {
			$pem_categories_list->loadRowValues(); // Load default values
		} else {
			$pem_categories_list->loadRowValues($pem_categories_list->Recordset); // Load row values
		}
		$pem_categories->RowType = ROWTYPE_VIEW; // Render view
		if ($pem_categories->isGridAdd()) // Grid add
			$pem_categories->RowType = ROWTYPE_ADD; // Render add
		if ($pem_categories->isGridAdd() && $pem_categories->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$pem_categories_list->restoreCurrentRowFormValues($pem_categories_list->RowIndex); // Restore form values
		if ($pem_categories->isGridEdit()) { // Grid edit
			if ($pem_categories->EventCancelled)
				$pem_categories_list->restoreCurrentRowFormValues($pem_categories_list->RowIndex); // Restore form values
			if ($pem_categories_list->RowAction == "insert")
				$pem_categories->RowType = ROWTYPE_ADD; // Render add
			else
				$pem_categories->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($pem_categories->isGridEdit() && ($pem_categories->RowType == ROWTYPE_EDIT || $pem_categories->RowType == ROWTYPE_ADD) && $pem_categories->EventCancelled) // Update failed
			$pem_categories_list->restoreCurrentRowFormValues($pem_categories_list->RowIndex); // Restore form values
		if ($pem_categories->RowType == ROWTYPE_EDIT) // Edit row
			$pem_categories_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pem_categories->RowAttrs = array_merge($pem_categories->RowAttrs, array('data-rowindex'=>$pem_categories_list->RowCnt, 'id'=>'r' . $pem_categories_list->RowCnt . '_pem_categories', 'data-rowtype'=>$pem_categories->RowType));

		// Render row
		$pem_categories_list->renderRow();

		// Render list options
		$pem_categories_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pem_categories_list->RowAction <> "delete" && $pem_categories_list->RowAction <> "insertdelete" && !($pem_categories_list->RowAction == "insert" && $pem_categories->isConfirm() && $pem_categories_list->emptyRow())) {
?>
	<tr<?php echo $pem_categories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pem_categories_list->ListOptions->render("body", "left", $pem_categories_list->RowCnt);
?>
	<?php if ($pem_categories->category->Visible) { // category ?>
		<td data-name="category"<?php echo $pem_categories->category->cellAttributes() ?>>
<?php if ($pem_categories->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_categories_list->RowCnt ?>_pem_categories_category" class="form-group pem_categories_category">
<input type="text" data-table="pem_categories" data-field="x_category" name="x<?php echo $pem_categories_list->RowIndex ?>_category" id="x<?php echo $pem_categories_list->RowIndex ?>_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_categories" data-field="x_category" name="o<?php echo $pem_categories_list->RowIndex ?>_category" id="o<?php echo $pem_categories_list->RowIndex ?>_category" value="<?php echo HtmlEncode($pem_categories->category->OldValue) ?>">
<?php } ?>
<?php if ($pem_categories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_categories_list->RowCnt ?>_pem_categories_category" class="form-group pem_categories_category">
<input type="text" data-table="pem_categories" data-field="x_category" name="x<?php echo $pem_categories_list->RowIndex ?>_category" id="x<?php echo $pem_categories_list->RowIndex ?>_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_categories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_categories_list->RowCnt ?>_pem_categories_category" class="pem_categories_category">
<span<?php echo $pem_categories->category->viewAttributes() ?>>
<?php echo $pem_categories->category->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($pem_categories->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="pem_categories" data-field="x_cat_id" name="x<?php echo $pem_categories_list->RowIndex ?>_cat_id" id="x<?php echo $pem_categories_list->RowIndex ?>_cat_id" value="<?php echo HtmlEncode($pem_categories->cat_id->CurrentValue) ?>">
<input type="hidden" data-table="pem_categories" data-field="x_cat_id" name="o<?php echo $pem_categories_list->RowIndex ?>_cat_id" id="o<?php echo $pem_categories_list->RowIndex ?>_cat_id" value="<?php echo HtmlEncode($pem_categories->cat_id->OldValue) ?>">
<?php } ?>
<?php if ($pem_categories->RowType == ROWTYPE_EDIT || $pem_categories->CurrentMode == "edit") { ?>
<input type="hidden" data-table="pem_categories" data-field="x_cat_id" name="x<?php echo $pem_categories_list->RowIndex ?>_cat_id" id="x<?php echo $pem_categories_list->RowIndex ?>_cat_id" value="<?php echo HtmlEncode($pem_categories->cat_id->CurrentValue) ?>">
<?php } ?>
<?php

// Render list options (body, right)
$pem_categories_list->ListOptions->render("body", "right", $pem_categories_list->RowCnt);
?>
	</tr>
<?php if ($pem_categories->RowType == ROWTYPE_ADD || $pem_categories->RowType == ROWTYPE_EDIT) { ?>
<script>
fpem_categorieslist.updateLists(<?php echo $pem_categories_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$pem_categories->isGridAdd())
		if (!$pem_categories_list->Recordset->EOF)
			$pem_categories_list->Recordset->moveNext();
}
?>
<?php
	if ($pem_categories->isGridAdd() || $pem_categories->isGridEdit()) {
		$pem_categories_list->RowIndex = '$rowindex$';
		$pem_categories_list->loadRowValues();

		// Set row properties
		$pem_categories->resetAttributes();
		$pem_categories->RowAttrs = array_merge($pem_categories->RowAttrs, array('data-rowindex'=>$pem_categories_list->RowIndex, 'id'=>'r0_pem_categories', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($pem_categories->RowAttrs["class"], "ew-template");
		$pem_categories->RowType = ROWTYPE_ADD;

		// Render row
		$pem_categories_list->renderRow();

		// Render list options
		$pem_categories_list->renderListOptions();
		$pem_categories_list->StartRowCnt = 0;
?>
	<tr<?php echo $pem_categories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pem_categories_list->ListOptions->render("body", "left", $pem_categories_list->RowIndex);
?>
	<?php if ($pem_categories->category->Visible) { // category ?>
		<td data-name="category">
<span id="el$rowindex$_pem_categories_category" class="form-group pem_categories_category">
<input type="text" data-table="pem_categories" data-field="x_category" name="x<?php echo $pem_categories_list->RowIndex ?>_category" id="x<?php echo $pem_categories_list->RowIndex ?>_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_categories" data-field="x_category" name="o<?php echo $pem_categories_list->RowIndex ?>_category" id="o<?php echo $pem_categories_list->RowIndex ?>_category" value="<?php echo HtmlEncode($pem_categories->category->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pem_categories_list->ListOptions->render("body", "right", $pem_categories_list->RowIndex);
?>
<script>
fpem_categorieslist.updateLists(<?php echo $pem_categories_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($pem_categories->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $pem_categories_list->FormKeyCountName ?>" id="<?php echo $pem_categories_list->FormKeyCountName ?>" value="<?php echo $pem_categories_list->KeyCount ?>">
<?php echo $pem_categories_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pem_categories->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $pem_categories_list->FormKeyCountName ?>" id="<?php echo $pem_categories_list->FormKeyCountName ?>" value="<?php echo $pem_categories_list->KeyCount ?>">
<?php echo $pem_categories_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$pem_categories->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pem_categories_list->Recordset)
	$pem_categories_list->Recordset->Close();
?>
<?php if (!$pem_categories->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$pem_categories->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_categories_list->Pager)) $pem_categories_list->Pager = new PrevNextPager($pem_categories_list->StartRec, $pem_categories_list->DisplayRecs, $pem_categories_list->TotalRecs, $pem_categories_list->AutoHidePager) ?>
<?php if ($pem_categories_list->Pager->RecordCount > 0 && $pem_categories_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_categories_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_categories_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_categories_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_categories_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_categories_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_categories_list->pageUrl() ?>start=<?php echo $pem_categories_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_categories_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_categories_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_categories_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_categories_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_categories_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_categories_list->OtherOptions as &$option)
		$option->render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($pem_categories_list->TotalRecs == 0 && !$pem_categories->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_categories_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pem_categories_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_categories->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_categories_list->terminate();
?>
