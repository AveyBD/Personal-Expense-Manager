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
$pem_expenses_list = new pem_expenses_list();

// Run the page
$pem_expenses_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_expenses_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_expenses->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fpem_expenseslist = currentForm = new ew.Form("fpem_expenseslist", "list");
fpem_expenseslist.formKeyCountName = '<?php echo $pem_expenses_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpem_expenseslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_expenseslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_expenseslist.lists["x_exp_category"] = <?php echo $pem_expenses_list->exp_category->Lookup->toClientList() ?>;
fpem_expenseslist.lists["x_exp_category"].options = <?php echo JsonEncode($pem_expenses_list->exp_category->lookupOptions()) ?>;
fpem_expenseslist.lists["x_exp_source"] = <?php echo $pem_expenses_list->exp_source->Lookup->toClientList() ?>;
fpem_expenseslist.lists["x_exp_source"].options = <?php echo JsonEncode($pem_expenses_list->exp_source->lookupOptions()) ?>;

// Form object for search
var fpem_expenseslistsrch = currentSearchForm = new ew.Form("fpem_expenseslistsrch");

// Filters
fpem_expenseslistsrch.filterList = <?php echo $pem_expenses_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_expenses->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pem_expenses_list->TotalRecs > 0 && $pem_expenses_list->ExportOptions->visible()) { ?>
<?php $pem_expenses_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_expenses_list->ImportOptions->visible()) { ?>
<?php $pem_expenses_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pem_expenses_list->SearchOptions->visible()) { ?>
<?php $pem_expenses_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pem_expenses_list->FilterOptions->visible()) { ?>
<?php $pem_expenses_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$pem_expenses_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pem_expenses->isExport() && !$pem_expenses->CurrentAction) { ?>
<form name="fpem_expenseslistsrch" id="fpem_expenseslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($pem_expenses_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fpem_expenseslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pem_expenses">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($pem_expenses_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->Phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($pem_expenses_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pem_expenses_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pem_expenses_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pem_expenses_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pem_expenses_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pem_expenses_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pem_expenses_list->showPageHeader(); ?>
<?php
$pem_expenses_list->showMessage();
?>
<?php if ($pem_expenses_list->TotalRecs > 0 || $pem_expenses->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($pem_expenses_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pem_expenses">
<?php if (!$pem_expenses->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$pem_expenses->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_expenses_list->Pager)) $pem_expenses_list->Pager = new PrevNextPager($pem_expenses_list->StartRec, $pem_expenses_list->DisplayRecs, $pem_expenses_list->TotalRecs, $pem_expenses_list->AutoHidePager) ?>
<?php if ($pem_expenses_list->Pager->RecordCount > 0 && $pem_expenses_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_expenses_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_expenses_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_expenses_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_expenses_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_expenses_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_expenses_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_expenses_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_expenses_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_expenses_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_expenses_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_expenses_list->OtherOptions as &$option)
		$option->render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpem_expenseslist" id="fpem_expenseslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_expenses_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_expenses_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_expenses">
<div id="gmp_pem_expenses" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($pem_expenses_list->TotalRecs > 0 || $pem_expenses->isGridEdit()) { ?>
<table id="tbl_pem_expenseslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$pem_expenses_list->RowType = ROWTYPE_HEADER;

// Render list options
$pem_expenses_list->renderListOptions();

// Render list options (header, left)
$pem_expenses_list->ListOptions->render("header", "left");
?>
<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
	<?php if ($pem_expenses->sortUrl($pem_expenses->exp_item) == "") { ?>
		<th data-name="exp_item" class="<?php echo $pem_expenses->exp_item->headerCellClass() ?>"><div id="elh_pem_expenses_exp_item" class="pem_expenses_exp_item"><div class="ew-table-header-caption"><?php echo $pem_expenses->exp_item->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exp_item" class="<?php echo $pem_expenses->exp_item->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_expenses->SortUrl($pem_expenses->exp_item) ?>',1);"><div id="elh_pem_expenses_exp_item" class="pem_expenses_exp_item">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_expenses->exp_item->caption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pem_expenses->exp_item->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_expenses->exp_item->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
	<?php if ($pem_expenses->sortUrl($pem_expenses->exp_category) == "") { ?>
		<th data-name="exp_category" class="<?php echo $pem_expenses->exp_category->headerCellClass() ?>"><div id="elh_pem_expenses_exp_category" class="pem_expenses_exp_category"><div class="ew-table-header-caption"><?php echo $pem_expenses->exp_category->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exp_category" class="<?php echo $pem_expenses->exp_category->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_expenses->SortUrl($pem_expenses->exp_category) ?>',1);"><div id="elh_pem_expenses_exp_category" class="pem_expenses_exp_category">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_expenses->exp_category->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_expenses->exp_category->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_expenses->exp_category->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
	<?php if ($pem_expenses->sortUrl($pem_expenses->exp_source) == "") { ?>
		<th data-name="exp_source" class="<?php echo $pem_expenses->exp_source->headerCellClass() ?>"><div id="elh_pem_expenses_exp_source" class="pem_expenses_exp_source"><div class="ew-table-header-caption"><?php echo $pem_expenses->exp_source->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exp_source" class="<?php echo $pem_expenses->exp_source->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_expenses->SortUrl($pem_expenses->exp_source) ?>',1);"><div id="elh_pem_expenses_exp_source" class="pem_expenses_exp_source">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_expenses->exp_source->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_expenses->exp_source->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_expenses->exp_source->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
	<?php if ($pem_expenses->sortUrl($pem_expenses->exp_amount) == "") { ?>
		<th data-name="exp_amount" class="<?php echo $pem_expenses->exp_amount->headerCellClass() ?>"><div id="elh_pem_expenses_exp_amount" class="pem_expenses_exp_amount"><div class="ew-table-header-caption"><?php echo $pem_expenses->exp_amount->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exp_amount" class="<?php echo $pem_expenses->exp_amount->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_expenses->SortUrl($pem_expenses->exp_amount) ?>',1);"><div id="elh_pem_expenses_exp_amount" class="pem_expenses_exp_amount">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_expenses->exp_amount->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_expenses->exp_amount->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_expenses->exp_amount->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
	<?php if ($pem_expenses->sortUrl($pem_expenses->exp_date) == "") { ?>
		<th data-name="exp_date" class="<?php echo $pem_expenses->exp_date->headerCellClass() ?>"><div id="elh_pem_expenses_exp_date" class="pem_expenses_exp_date"><div class="ew-table-header-caption"><?php echo $pem_expenses->exp_date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exp_date" class="<?php echo $pem_expenses->exp_date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $pem_expenses->SortUrl($pem_expenses->exp_date) ?>',1);"><div id="elh_pem_expenses_exp_date" class="pem_expenses_exp_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pem_expenses->exp_date->caption() ?></span><span class="ew-table-header-sort"><?php if ($pem_expenses->exp_date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($pem_expenses->exp_date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pem_expenses_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pem_expenses->ExportAll && $pem_expenses->isExport()) {
	$pem_expenses_list->StopRec = $pem_expenses_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pem_expenses_list->TotalRecs > $pem_expenses_list->StartRec + $pem_expenses_list->DisplayRecs - 1)
		$pem_expenses_list->StopRec = $pem_expenses_list->StartRec + $pem_expenses_list->DisplayRecs - 1;
	else
		$pem_expenses_list->StopRec = $pem_expenses_list->TotalRecs;
}
$pem_expenses_list->RecCnt = $pem_expenses_list->StartRec - 1;
if ($pem_expenses_list->Recordset && !$pem_expenses_list->Recordset->EOF) {
	$pem_expenses_list->Recordset->moveFirst();
	$selectLimit = $pem_expenses_list->UseSelectLimit;
	if (!$selectLimit && $pem_expenses_list->StartRec > 1)
		$pem_expenses_list->Recordset->move($pem_expenses_list->StartRec - 1);
} elseif (!$pem_expenses->AllowAddDeleteRow && $pem_expenses_list->StopRec == 0) {
	$pem_expenses_list->StopRec = $pem_expenses->GridAddRowCount;
}

// Initialize aggregate
$pem_expenses->RowType = ROWTYPE_AGGREGATEINIT;
$pem_expenses->resetAttributes();
$pem_expenses_list->renderRow();
while ($pem_expenses_list->RecCnt < $pem_expenses_list->StopRec) {
	$pem_expenses_list->RecCnt++;
	if ($pem_expenses_list->RecCnt >= $pem_expenses_list->StartRec) {
		$pem_expenses_list->RowCnt++;

		// Set up key count
		$pem_expenses_list->KeyCount = $pem_expenses_list->RowIndex;

		// Init row class and style
		$pem_expenses->resetAttributes();
		$pem_expenses->CssClass = "";
		if ($pem_expenses->isGridAdd()) {
		} else {
			$pem_expenses_list->loadRowValues($pem_expenses_list->Recordset); // Load row values
		}
		$pem_expenses->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pem_expenses->RowAttrs = array_merge($pem_expenses->RowAttrs, array('data-rowindex'=>$pem_expenses_list->RowCnt, 'id'=>'r' . $pem_expenses_list->RowCnt . '_pem_expenses', 'data-rowtype'=>$pem_expenses->RowType));

		// Render row
		$pem_expenses_list->renderRow();

		// Render list options
		$pem_expenses_list->renderListOptions();
?>
	<tr<?php echo $pem_expenses->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pem_expenses_list->ListOptions->render("body", "left", $pem_expenses_list->RowCnt);
?>
	<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
		<td data-name="exp_item"<?php echo $pem_expenses->exp_item->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_list->RowCnt ?>_pem_expenses_exp_item" class="pem_expenses_exp_item">
<span<?php echo $pem_expenses->exp_item->viewAttributes() ?>>
<?php echo $pem_expenses->exp_item->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
		<td data-name="exp_category"<?php echo $pem_expenses->exp_category->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_list->RowCnt ?>_pem_expenses_exp_category" class="pem_expenses_exp_category">
<span<?php echo $pem_expenses->exp_category->viewAttributes() ?>>
<?php echo $pem_expenses->exp_category->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
		<td data-name="exp_source"<?php echo $pem_expenses->exp_source->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_list->RowCnt ?>_pem_expenses_exp_source" class="pem_expenses_exp_source">
<span<?php echo $pem_expenses->exp_source->viewAttributes() ?>>
<?php echo $pem_expenses->exp_source->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
		<td data-name="exp_amount"<?php echo $pem_expenses->exp_amount->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_list->RowCnt ?>_pem_expenses_exp_amount" class="pem_expenses_exp_amount">
<span<?php echo $pem_expenses->exp_amount->viewAttributes() ?>>
<?php echo $pem_expenses->exp_amount->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
		<td data-name="exp_date"<?php echo $pem_expenses->exp_date->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_list->RowCnt ?>_pem_expenses_exp_date" class="pem_expenses_exp_date">
<span<?php echo $pem_expenses->exp_date->viewAttributes() ?>>
<?php echo $pem_expenses->exp_date->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pem_expenses_list->ListOptions->render("body", "right", $pem_expenses_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$pem_expenses->isGridAdd())
		$pem_expenses_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$pem_expenses->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pem_expenses_list->Recordset)
	$pem_expenses_list->Recordset->Close();
?>
<?php if (!$pem_expenses->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$pem_expenses->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pem_expenses_list->Pager)) $pem_expenses_list->Pager = new PrevNextPager($pem_expenses_list->StartRec, $pem_expenses_list->DisplayRecs, $pem_expenses_list->TotalRecs, $pem_expenses_list->AutoHidePager) ?>
<?php if ($pem_expenses_list->Pager->RecordCount > 0 && $pem_expenses_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($pem_expenses_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($pem_expenses_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $pem_expenses_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($pem_expenses_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($pem_expenses_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pem_expenses_list->pageUrl() ?>start=<?php echo $pem_expenses_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pem_expenses_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($pem_expenses_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pem_expenses_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pem_expenses_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pem_expenses_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_expenses_list->OtherOptions as &$option)
		$option->render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($pem_expenses_list->TotalRecs == 0 && !$pem_expenses->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php
	foreach ($pem_expenses_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pem_expenses_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_expenses->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_expenses_list->terminate();
?>
