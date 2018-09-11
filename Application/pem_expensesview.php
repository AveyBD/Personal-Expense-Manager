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
$pem_expenses_view = new pem_expenses_view();

// Run the page
$pem_expenses_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_expenses_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_expenses->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fpem_expensesview = currentForm = new ew.Form("fpem_expensesview", "view");

// Form_CustomValidate event
fpem_expensesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_expensesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_expensesview.lists["x_exp_category"] = <?php echo $pem_expenses_view->exp_category->Lookup->toClientList() ?>;
fpem_expensesview.lists["x_exp_category"].options = <?php echo JsonEncode($pem_expenses_view->exp_category->lookupOptions()) ?>;
fpem_expensesview.lists["x_payment_type"] = <?php echo $pem_expenses_view->payment_type->Lookup->toClientList() ?>;
fpem_expensesview.lists["x_payment_type"].options = <?php echo JsonEncode($pem_expenses_view->payment_type->lookupOptions()) ?>;
fpem_expensesview.lists["x_exp_source"] = <?php echo $pem_expenses_view->exp_source->Lookup->toClientList() ?>;
fpem_expensesview.lists["x_exp_source"].options = <?php echo JsonEncode($pem_expenses_view->exp_source->lookupOptions()) ?>;
fpem_expensesview.lists["x_user_id"] = <?php echo $pem_expenses_view->user_id->Lookup->toClientList() ?>;
fpem_expensesview.lists["x_user_id"].options = <?php echo JsonEncode($pem_expenses_view->user_id->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_expenses->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pem_expenses_view->ExportOptions->render("body") ?>
<?php
	foreach ($pem_expenses_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pem_expenses_view->showPageHeader(); ?>
<?php
$pem_expenses_view->showMessage();
?>
<form name="fpem_expensesview" id="fpem_expensesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_expenses_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_expenses_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_expenses">
<input type="hidden" name="modal" value="<?php echo (int)$pem_expenses_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($pem_expenses->exp_id->Visible) { // exp_id ?>
	<tr id="r_exp_id">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_id"><?php echo $pem_expenses->exp_id->caption() ?></span></td>
		<td data-name="exp_id"<?php echo $pem_expenses->exp_id->cellAttributes() ?>>
<span id="el_pem_expenses_exp_id">
<span<?php echo $pem_expenses->exp_id->viewAttributes() ?>>
<?php echo $pem_expenses->exp_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
	<tr id="r_exp_item">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_item"><?php echo $pem_expenses->exp_item->caption() ?></span></td>
		<td data-name="exp_item"<?php echo $pem_expenses->exp_item->cellAttributes() ?>>
<span id="el_pem_expenses_exp_item">
<span<?php echo $pem_expenses->exp_item->viewAttributes() ?>>
<?php echo $pem_expenses->exp_item->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
	<tr id="r_exp_category">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_category"><?php echo $pem_expenses->exp_category->caption() ?></span></td>
		<td data-name="exp_category"<?php echo $pem_expenses->exp_category->cellAttributes() ?>>
<span id="el_pem_expenses_exp_category">
<span<?php echo $pem_expenses->exp_category->viewAttributes() ?>>
<?php echo $pem_expenses->exp_category->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->payment_type->Visible) { // payment_type ?>
	<tr id="r_payment_type">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_payment_type"><?php echo $pem_expenses->payment_type->caption() ?></span></td>
		<td data-name="payment_type"<?php echo $pem_expenses->payment_type->cellAttributes() ?>>
<span id="el_pem_expenses_payment_type">
<span<?php echo $pem_expenses->payment_type->viewAttributes() ?>>
<?php echo $pem_expenses->payment_type->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
	<tr id="r_exp_source">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_source"><?php echo $pem_expenses->exp_source->caption() ?></span></td>
		<td data-name="exp_source"<?php echo $pem_expenses->exp_source->cellAttributes() ?>>
<span id="el_pem_expenses_exp_source">
<span<?php echo $pem_expenses->exp_source->viewAttributes() ?>>
<?php echo $pem_expenses->exp_source->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
	<tr id="r_exp_amount">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_amount"><?php echo $pem_expenses->exp_amount->caption() ?></span></td>
		<td data-name="exp_amount"<?php echo $pem_expenses->exp_amount->cellAttributes() ?>>
<span id="el_pem_expenses_exp_amount">
<span<?php echo $pem_expenses->exp_amount->viewAttributes() ?>>
<?php echo $pem_expenses->exp_amount->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
	<tr id="r_exp_date">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_date"><?php echo $pem_expenses->exp_date->caption() ?></span></td>
		<td data-name="exp_date"<?php echo $pem_expenses->exp_date->cellAttributes() ?>>
<span id="el_pem_expenses_exp_date">
<span<?php echo $pem_expenses->exp_date->viewAttributes() ?>>
<?php echo $pem_expenses->exp_date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->exp_remarks->Visible) { // exp_remarks ?>
	<tr id="r_exp_remarks">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_remarks"><?php echo $pem_expenses->exp_remarks->caption() ?></span></td>
		<td data-name="exp_remarks"<?php echo $pem_expenses->exp_remarks->cellAttributes() ?>>
<span id="el_pem_expenses_exp_remarks">
<span<?php echo $pem_expenses->exp_remarks->viewAttributes() ?>>
<?php echo $pem_expenses->exp_remarks->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_expenses->user_id->Visible) { // user_id ?>
	<tr id="r_user_id">
		<td class="<?php echo $pem_expenses_view->TableLeftColumnClass ?>"><span id="elh_pem_expenses_user_id"><?php echo $pem_expenses->user_id->caption() ?></span></td>
		<td data-name="user_id"<?php echo $pem_expenses->user_id->cellAttributes() ?>>
<span id="el_pem_expenses_user_id">
<span<?php echo $pem_expenses->user_id->viewAttributes() ?>>
<?php echo $pem_expenses->user_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$pem_expenses_view->showPageFooter();
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
$pem_expenses_view->terminate();
?>
