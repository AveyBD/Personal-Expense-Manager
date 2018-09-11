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
$pem_expenses_delete = new pem_expenses_delete();

// Run the page
$pem_expenses_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_expenses_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fpem_expensesdelete = currentForm = new ew.Form("fpem_expensesdelete", "delete");

// Form_CustomValidate event
fpem_expensesdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_expensesdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_expensesdelete.lists["x_exp_category"] = <?php echo $pem_expenses_delete->exp_category->Lookup->toClientList() ?>;
fpem_expensesdelete.lists["x_exp_category"].options = <?php echo JsonEncode($pem_expenses_delete->exp_category->lookupOptions()) ?>;
fpem_expensesdelete.lists["x_exp_source"] = <?php echo $pem_expenses_delete->exp_source->Lookup->toClientList() ?>;
fpem_expensesdelete.lists["x_exp_source"].options = <?php echo JsonEncode($pem_expenses_delete->exp_source->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_expenses_delete->showPageHeader(); ?>
<?php
$pem_expenses_delete->showMessage();
?>
<form name="fpem_expensesdelete" id="fpem_expensesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_expenses_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_expenses_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_expenses">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pem_expenses_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
		<th class="<?php echo $pem_expenses->exp_item->headerCellClass() ?>"><span id="elh_pem_expenses_exp_item" class="pem_expenses_exp_item"><?php echo $pem_expenses->exp_item->caption() ?></span></th>
<?php } ?>
<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
		<th class="<?php echo $pem_expenses->exp_category->headerCellClass() ?>"><span id="elh_pem_expenses_exp_category" class="pem_expenses_exp_category"><?php echo $pem_expenses->exp_category->caption() ?></span></th>
<?php } ?>
<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
		<th class="<?php echo $pem_expenses->exp_source->headerCellClass() ?>"><span id="elh_pem_expenses_exp_source" class="pem_expenses_exp_source"><?php echo $pem_expenses->exp_source->caption() ?></span></th>
<?php } ?>
<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
		<th class="<?php echo $pem_expenses->exp_amount->headerCellClass() ?>"><span id="elh_pem_expenses_exp_amount" class="pem_expenses_exp_amount"><?php echo $pem_expenses->exp_amount->caption() ?></span></th>
<?php } ?>
<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
		<th class="<?php echo $pem_expenses->exp_date->headerCellClass() ?>"><span id="elh_pem_expenses_exp_date" class="pem_expenses_exp_date"><?php echo $pem_expenses->exp_date->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pem_expenses_delete->RecCnt = 0;
$i = 0;
while (!$pem_expenses_delete->Recordset->EOF) {
	$pem_expenses_delete->RecCnt++;
	$pem_expenses_delete->RowCnt++;

	// Set row properties
	$pem_expenses->resetAttributes();
	$pem_expenses->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pem_expenses_delete->loadRowValues($pem_expenses_delete->Recordset);

	// Render row
	$pem_expenses_delete->renderRow();
?>
	<tr<?php echo $pem_expenses->rowAttributes() ?>>
<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
		<td<?php echo $pem_expenses->exp_item->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_delete->RowCnt ?>_pem_expenses_exp_item" class="pem_expenses_exp_item">
<span<?php echo $pem_expenses->exp_item->viewAttributes() ?>>
<?php echo $pem_expenses->exp_item->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
		<td<?php echo $pem_expenses->exp_category->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_delete->RowCnt ?>_pem_expenses_exp_category" class="pem_expenses_exp_category">
<span<?php echo $pem_expenses->exp_category->viewAttributes() ?>>
<?php echo $pem_expenses->exp_category->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
		<td<?php echo $pem_expenses->exp_source->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_delete->RowCnt ?>_pem_expenses_exp_source" class="pem_expenses_exp_source">
<span<?php echo $pem_expenses->exp_source->viewAttributes() ?>>
<?php echo $pem_expenses->exp_source->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
		<td<?php echo $pem_expenses->exp_amount->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_delete->RowCnt ?>_pem_expenses_exp_amount" class="pem_expenses_exp_amount">
<span<?php echo $pem_expenses->exp_amount->viewAttributes() ?>>
<?php echo $pem_expenses->exp_amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
		<td<?php echo $pem_expenses->exp_date->cellAttributes() ?>>
<span id="el<?php echo $pem_expenses_delete->RowCnt ?>_pem_expenses_exp_date" class="pem_expenses_exp_date">
<span<?php echo $pem_expenses->exp_date->viewAttributes() ?>>
<?php echo $pem_expenses->exp_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pem_expenses_delete->Recordset->moveNext();
}
$pem_expenses_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_expenses_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pem_expenses_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_expenses_delete->terminate();
?>
