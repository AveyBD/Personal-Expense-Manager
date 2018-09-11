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
$pem_payment_type_list = new pem_payment_type_list();

// Run the page
$pem_payment_type_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_payment_type_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_payment_type->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fpem_payment_typelist = currentForm = new ew.Form("fpem_payment_typelist", "list");
fpem_payment_typelist.formKeyCountName = '<?php echo $pem_payment_type_list->FormKeyCountName ?>';

// Validate form
fpem_payment_typelist.validate = function() {
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
		<?php if ($pem_payment_type_list->type_id->Required) { ?>
			elm = this.getElements("x" + infix + "_type_id");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_payment_type->type_id->caption(), $pem_payment_type->type_id->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_payment_type_list->payment_type->Required) { ?>
			elm = this.getElements("x" + infix + "_payment_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_payment_type->payment_type->caption(), $pem_payment_type->payment_type->RequiredErrorMessage)) ?>");
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
fpem_payment_typelist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "payment_type", false)) return false;
	return true;
}

// Form_CustomValidate event
fpem_payment_typelist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_payment_typelist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fpem_payment_typelistsrch = currentSearchForm = new ew.Form("fpem_payment_typelistsrch");

// Filters
fpem_payment_typelistsrch.filterList = <?php echo $pem_payment_type_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_payment_type->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pem_payment_type_list->TotalRecs > 0 && $pem_payment_type_list->ExportOptions->visible()) { ?>
<?php $pem_payment_type_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_payment_type_list->ImportOptions->visible()) { ?>
<?php $pem_payment_type_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_payment_type_list->SearchOptions->visible()) { ?>
<?php $pem_payment_type_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pem_payment_type_list->FilterOptions->visible()) { ?>
<?php $pem_payment_type_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$pem_payment_type_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pem_payment_type->isExport() && !$pem_payment_type->CurrentAction) { ?>
<form name="fpem_payment_typelistsrch" id="fpem_payment_typelistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($pem_payment_type_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fpem_payment_typelistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pem_payment_type">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($pem_payment_type_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->Phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($pem_payment_type_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pem_payment_type_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pem_payment_type_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pem_payment_type_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pem_payment_type_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pem_payment_type_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pem_payment_type_list->showPageHeader(); ?>
<?php
$pem_payment_type_list->showMessage();
?>
<?php if ($pem_payment_type_list->TotalRecs > 0 || $pem_payment_type->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($pem_payment_type_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pem_payment_type">
<?php if (!$pem_payment_type->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$pem_payment_type->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_payment_type_list->Pager)) $pem_payment_type_list->Pager = new PrevNextPager($pem_payment_type_list->StartRec, $pem_payment_type_list->DisplayRecs, $pem_payment_type_list->TotalRecs, $pem_payment_type_list->AutoHidePager) ?>
<?php if ($pem_payment_type_list->Pager->RecordCount > 0 && $pem_payment_type_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_payment_type_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_payment_type_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_payment_type_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_payment_type_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_payment_type_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_payment_type_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_payment_type_list->OtherOptions as &$option)
		$option->render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpem_payment_typelist" id="fpem_payment_typelist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_payment_type_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_payment_type_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_payment_type">
<div id="gmp_pem_payment_type" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($pem_payment_type_list->TotalRecs > 0 || $pem_payment_type->isGridEdit()) { ?>
<table id="tbl_pem_payment_typelist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$pem_payment_type_list->RowType = ROWTYPE_HEADER;

// Render list options
$pem_payment_type_list->renderListOptions();

// Render list options (header, left)
$pem_payment_type_list->ListOptions->render("header", "left");
?>
<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
	<?php if ($pem_payment_type->sortUrl($pem_payment_type->type_id) == "") { ?>
		<th data-name="type_id" class="<?php echo $pem_payment_type->type_id->headerCellClass() ?>"><div id="elh_pem_payment_type_type_id" class="pem_payment_type_type_id"><div class="ew-table-header-caption"><?php echo $pem_payment_type->type_id->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type_id" class="<?php echo $pem_payment_type->type_id->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_payment_type->SortUrl($pem_payment_type->type_id) ?>',1);"><div id="elh_pem_payment_type_type_id" class="pem_payment_type_type_id">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_payment_type->type_id->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_payment_type->type_id->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_payment_type->type_id->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
	<?php if ($pem_payment_type->sortUrl($pem_payment_type->payment_type) == "") { ?>
		<th data-name="payment_type" class="<?php echo $pem_payment_type->payment_type->headerCellClass() ?>"><div id="elh_pem_payment_type_payment_type" class="pem_payment_type_payment_type"><div class="ew-table-header-caption"><?php echo $pem_payment_type->payment_type->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="payment_type" class="<?php echo $pem_payment_type->payment_type->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_payment_type->SortUrl($pem_payment_type->payment_type) ?>',1);"><div id="elh_pem_payment_type_payment_type" class="pem_payment_type_payment_type">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_payment_type->payment_type->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_payment_type->payment_type->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_payment_type->payment_type->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pem_payment_type_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pem_payment_type->ExportAll && $pem_payment_type->isExport()) {
	$pem_payment_type_list->StopRec = $pem_payment_type_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pem_payment_type_list->TotalRecs > $pem_payment_type_list->StartRec + $pem_payment_type_list->DisplayRecs - 1)
		$pem_payment_type_list->StopRec = $pem_payment_type_list->StartRec + $pem_payment_type_list->DisplayRecs - 1;
	else
		$pem_payment_type_list->StopRec = $pem_payment_type_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $pem_payment_type_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($pem_payment_type_list->FormKeyCountName) && ($pem_payment_type->isGridAdd() || $pem_payment_type->isGridEdit() || $pem_payment_type->isConfirm())) {
		$pem_payment_type_list->KeyCount = $CurrentForm->getValue($pem_payment_type_list->FormKeyCountName);
		$pem_payment_type_list->StopRec = $pem_payment_type_list->StartRec + $pem_payment_type_list->KeyCount - 1;
	}
}
$pem_payment_type_list->RecCnt = $pem_payment_type_list->StartRec - 1;
if ($pem_payment_type_list->Recordset && !$pem_payment_type_list->Recordset->EOF) {
	$pem_payment_type_list->Recordset->moveFirst();
	$selectLimit = $pem_payment_type_list->UseSelectLimit;
	if (!$selectLimit && $pem_payment_type_list->StartRec > 1)
		$pem_payment_type_list->Recordset->move($pem_payment_type_list->StartRec - 1);
} elseif (!$pem_payment_type->AllowAddDeleteRow && $pem_payment_type_list->StopRec == 0) {
	$pem_payment_type_list->StopRec = $pem_payment_type->GridAddRowCount;
}

// Initialize aggregate
$pem_payment_type->RowType = ROWTYPE_AGGREGATEINIT;
$pem_payment_type->resetAttributes();
$pem_payment_type_list->renderRow();
if ($pem_payment_type->isGridAdd())
	$pem_payment_type_list->RowIndex = 0;
if ($pem_payment_type->isGridEdit())
	$pem_payment_type_list->RowIndex = 0;
while ($pem_payment_type_list->RecCnt < $pem_payment_type_list->StopRec) {
	$pem_payment_type_list->RecCnt++;
	if ($pem_payment_type_list->RecCnt >= $pem_payment_type_list->StartRec) {
		$pem_payment_type_list->RowCnt++;
		if ($pem_payment_type->isGridAdd() || $pem_payment_type->isGridEdit() || $pem_payment_type->isConfirm()) {
			$pem_payment_type_list->RowIndex++;
			$CurrentForm->Index = $pem_payment_type_list->RowIndex;
			if ($CurrentForm->hasValue($pem_payment_type_list->FormActionName) && $pem_payment_type_list->EventCancelled)
				$pem_payment_type_list->RowAction = strval($CurrentForm->getValue($pem_payment_type_list->FormActionName));
			elseif ($pem_payment_type->isGridAdd())
				$pem_payment_type_list->RowAction = "insert";
			else
				$pem_payment_type_list->RowAction = "";
		}

		// Set up key count
		$pem_payment_type_list->KeyCount = $pem_payment_type_list->RowIndex;

		// Init row class and style
		$pem_payment_type->resetAttributes();
		$pem_payment_type->CssClass = "";
		if ($pem_payment_type->isGridAdd()) {
			$pem_payment_type_list->loadRowValues(); // Load default values
		} else {
			$pem_payment_type_list->loadRowValues($pem_payment_type_list->Recordset); // Load row values
		}
		$pem_payment_type->RowType = ROWTYPE_VIEW; // Render view
		if ($pem_payment_type->isGridAdd()) // Grid add
			$pem_payment_type->RowType = ROWTYPE_ADD; // Render add
		if ($pem_payment_type->isGridAdd() && $pem_payment_type->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$pem_payment_type_list->restoreCurrentRowFormValues($pem_payment_type_list->RowIndex); // Restore form values
		if ($pem_payment_type->isGridEdit()) { // Grid edit
			if ($pem_payment_type->EventCancelled)
				$pem_payment_type_list->restoreCurrentRowFormValues($pem_payment_type_list->RowIndex); // Restore form values
			if ($pem_payment_type_list->RowAction == "insert")
				$pem_payment_type->RowType = ROWTYPE_ADD; // Render add
			else
				$pem_payment_type->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($pem_payment_type->isGridEdit() && ($pem_payment_type->RowType == ROWTYPE_EDIT || $pem_payment_type->RowType == ROWTYPE_ADD) && $pem_payment_type->EventCancelled) // Update failed
			$pem_payment_type_list->restoreCurrentRowFormValues($pem_payment_type_list->RowIndex); // Restore form values
		if ($pem_payment_type->RowType == ROWTYPE_EDIT) // Edit row
			$pem_payment_type_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pem_payment_type->RowAttrs = array_merge($pem_payment_type->RowAttrs, array('data-rowindex'=>$pem_payment_type_list->RowCnt, 'id'=>'r' . $pem_payment_type_list->RowCnt . '_pem_payment_type', 'data-rowtype'=>$pem_payment_type->RowType));

		// Render row
		$pem_payment_type_list->renderRow();

		// Render list options
		$pem_payment_type_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pem_payment_type_list->RowAction <> "delete" && $pem_payment_type_list->RowAction <> "insertdelete" && !($pem_payment_type_list->RowAction == "insert" && $pem_payment_type->isConfirm() && $pem_payment_type_list->emptyRow())) {
?>
	<tr<?php echo $pem_payment_type->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pem_payment_type_list->ListOptions->render("body", "left", $pem_payment_type_list->RowCnt);
?>
	<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
		<td data-name="type_id"<?php echo $pem_payment_type->type_id->cellAttributes() ?>>
<?php if ($pem_payment_type->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="pem_payment_type" data-field="x_type_id" name="o<?php echo $pem_payment_type_list->RowIndex ?>_type_id" id="o<?php echo $pem_payment_type_list->RowIndex ?>_type_id" value="<?php echo HtmlEncode($pem_payment_type->type_id->OldValue) ?>">
<?php } ?>
<?php if ($pem_payment_type->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_payment_type_list->RowCnt ?>_pem_payment_type_type_id" class="form-group pem_payment_type_type_id">
<span<?php echo $pem_payment_type->type_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($pem_payment_type->type_id->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="pem_payment_type" data-field="x_type_id" name="x<?php echo $pem_payment_type_list->RowIndex ?>_type_id" id="x<?php echo $pem_payment_type_list->RowIndex ?>_type_id" value="<?php echo HtmlEncode($pem_payment_type->type_id->CurrentValue) ?>">
<?php } ?>
<?php if ($pem_payment_type->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_payment_type_list->RowCnt ?>_pem_payment_type_type_id" class="pem_payment_type_type_id">
<span<?php echo $pem_payment_type->type_id->viewAttributes() ?>>
<?php echo $pem_payment_type->type_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
		<td data-name="payment_type"<?php echo $pem_payment_type->payment_type->cellAttributes() ?>>
<?php if ($pem_payment_type->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pem_payment_type_list->RowCnt ?>_pem_payment_type_payment_type" class="form-group pem_payment_type_payment_type">
<input type="text" data-table="pem_payment_type" data-field="x_payment_type" name="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" id="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_payment_type->payment_type->getPlaceHolder()) ?>" value="<?php echo $pem_payment_type->payment_type->EditValue ?>"<?php echo $pem_payment_type->payment_type->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_payment_type" data-field="x_payment_type" name="o<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" id="o<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" value="<?php echo HtmlEncode($pem_payment_type->payment_type->OldValue) ?>">
<?php } ?>
<?php if ($pem_payment_type->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pem_payment_type_list->RowCnt ?>_pem_payment_type_payment_type" class="form-group pem_payment_type_payment_type">
<input type="text" data-table="pem_payment_type" data-field="x_payment_type" name="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" id="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_payment_type->payment_type->getPlaceHolder()) ?>" value="<?php echo $pem_payment_type->payment_type->EditValue ?>"<?php echo $pem_payment_type->payment_type->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pem_payment_type->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pem_payment_type_list->RowCnt ?>_pem_payment_type_payment_type" class="pem_payment_type_payment_type">
<span<?php echo $pem_payment_type->payment_type->viewAttributes() ?>>
<?php echo $pem_payment_type->payment_type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pem_payment_type_list->ListOptions->render("body", "right", $pem_payment_type_list->RowCnt);
?>
	</tr>
<?php if ($pem_payment_type->RowType == ROWTYPE_ADD || $pem_payment_type->RowType == ROWTYPE_EDIT) { ?>
<script>
fpem_payment_typelist.updateLists(<?php echo $pem_payment_type_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$pem_payment_type->isGridAdd())
		if (!$pem_payment_type_list->Recordset->EOF)
			$pem_payment_type_list->Recordset->moveNext();
}
?>
<?php
	if ($pem_payment_type->isGridAdd() || $pem_payment_type->isGridEdit()) {
		$pem_payment_type_list->RowIndex = '$rowindex$';
		$pem_payment_type_list->loadRowValues();

		// Set row properties
		$pem_payment_type->resetAttributes();
		$pem_payment_type->RowAttrs = array_merge($pem_payment_type->RowAttrs, array('data-rowindex'=>$pem_payment_type_list->RowIndex, 'id'=>'r0_pem_payment_type', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($pem_payment_type->RowAttrs["class"], "ew-template");
		$pem_payment_type->RowType = ROWTYPE_ADD;

		// Render row
		$pem_payment_type_list->renderRow();

		// Render list options
		$pem_payment_type_list->renderListOptions();
		$pem_payment_type_list->StartRowCnt = 0;
?>
	<tr<?php echo $pem_payment_type->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pem_payment_type_list->ListOptions->render("body", "left", $pem_payment_type_list->RowIndex);
?>
	<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
		<td data-name="type_id">
<input type="hidden" data-table="pem_payment_type" data-field="x_type_id" name="o<?php echo $pem_payment_type_list->RowIndex ?>_type_id" id="o<?php echo $pem_payment_type_list->RowIndex ?>_type_id" value="<?php echo HtmlEncode($pem_payment_type->type_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
		<td data-name="payment_type">
<span id="el$rowindex$_pem_payment_type_payment_type" class="form-group pem_payment_type_payment_type">
<input type="text" data-table="pem_payment_type" data-field="x_payment_type" name="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" id="x<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_payment_type->payment_type->getPlaceHolder()) ?>" value="<?php echo $pem_payment_type->payment_type->EditValue ?>"<?php echo $pem_payment_type->payment_type->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_payment_type" data-field="x_payment_type" name="o<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" id="o<?php echo $pem_payment_type_list->RowIndex ?>_payment_type" value="<?php echo HtmlEncode($pem_payment_type->payment_type->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pem_payment_type_list->ListOptions->render("body", "right", $pem_payment_type_list->RowIndex);
?>
<script>
fpem_payment_typelist.updateLists(<?php echo $pem_payment_type_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($pem_payment_type->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $pem_payment_type_list->FormKeyCountName ?>" id="<?php echo $pem_payment_type_list->FormKeyCountName ?>" value="<?php echo $pem_payment_type_list->KeyCount ?>">
<?php echo $pem_payment_type_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pem_payment_type->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $pem_payment_type_list->FormKeyCountName ?>" id="<?php echo $pem_payment_type_list->FormKeyCountName ?>" value="<?php echo $pem_payment_type_list->KeyCount ?>">
<?php echo $pem_payment_type_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$pem_payment_type->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pem_payment_type_list->Recordset)
	$pem_payment_type_list->Recordset->Close();
?>
<?php if (!$pem_payment_type->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$pem_payment_type->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_payment_type_list->Pager)) $pem_payment_type_list->Pager = new PrevNextPager($pem_payment_type_list->StartRec, $pem_payment_type_list->DisplayRecs, $pem_payment_type_list->TotalRecs, $pem_payment_type_list->AutoHidePager) ?>
<?php if ($pem_payment_type_list->Pager->RecordCount > 0 && $pem_payment_type_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_payment_type_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_payment_type_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_payment_type_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_payment_type_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_payment_type_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_payment_type_list->pageUrl() ?>start=<?php echo $pem_payment_type_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_payment_type_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_payment_type_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_payment_type_list->OtherOptions as &$option)
		$option->render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($pem_payment_type_list->TotalRecs == 0 && !$pem_payment_type->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_payment_type_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pem_payment_type_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_payment_type->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_payment_type_list->terminate();
?>
