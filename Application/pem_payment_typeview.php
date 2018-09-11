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
$pem_payment_type_view = new pem_payment_type_view();

// Run the page
$pem_payment_type_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_payment_type_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_payment_type->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fpem_payment_typeview = currentForm = new ew.Form("fpem_payment_typeview", "view");

// Form_CustomValidate event
fpem_payment_typeview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_payment_typeview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_payment_type->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pem_payment_type_view->ExportOptions->render("body") ?>
<?php
	foreach ($pem_payment_type_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pem_payment_type_view->showPageHeader(); ?>
<?php
$pem_payment_type_view->showMessage();
?>
<form name="fpem_payment_typeview" id="fpem_payment_typeview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_payment_type_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_payment_type_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_payment_type">
<input type="hidden" name="modal" value="<?php echo (int)$pem_payment_type_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
	<tr id="r_type_id">
		<td class="<?php echo $pem_payment_type_view->TableLeftColumnClass ?>"><span id="elh_pem_payment_type_type_id"><?php echo $pem_payment_type->type_id->caption() ?></span></td>
		<td data-name="type_id"<?php echo $pem_payment_type->type_id->cellAttributes() ?>>
<span id="el_pem_payment_type_type_id">
<span<?php echo $pem_payment_type->type_id->viewAttributes() ?>>
<?php echo $pem_payment_type->type_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
	<tr id="r_payment_type">
		<td class="<?php echo $pem_payment_type_view->TableLeftColumnClass ?>"><span id="elh_pem_payment_type_payment_type"><?php echo $pem_payment_type->payment_type->caption() ?></span></td>
		<td data-name="payment_type"<?php echo $pem_payment_type->payment_type->cellAttributes() ?>>
<span id="el_pem_payment_type_payment_type">
<span<?php echo $pem_payment_type->payment_type->viewAttributes() ?>>
<?php echo $pem_payment_type->payment_type->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_payment_type->remarks->Visible) { // remarks ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_payment_type_view->TableLeftColumnClass ?>"><span id="elh_pem_payment_type_remarks"><?php echo $pem_payment_type->remarks->caption() ?></span></td>
		<td data-name="remarks"<?php echo $pem_payment_type->remarks->cellAttributes() ?>>
<span id="el_pem_payment_type_remarks">
<span<?php echo $pem_payment_type->remarks->viewAttributes() ?>>
<?php echo $pem_payment_type->remarks->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$pem_payment_type_view->showPageFooter();
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
$pem_payment_type_view->terminate();
?>
