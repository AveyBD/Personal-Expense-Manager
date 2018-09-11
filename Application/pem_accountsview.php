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
$pem_accounts_view = new pem_accounts_view();

// Run the page
$pem_accounts_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_accounts_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_accounts->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fpem_accountsview = currentForm = new ew.Form("fpem_accountsview", "view");

// Form_CustomValidate event
fpem_accountsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_accountsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_accounts->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pem_accounts_view->ExportOptions->render("body") ?>
<?php
	foreach ($pem_accounts_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pem_accounts_view->showPageHeader(); ?>
<?php
$pem_accounts_view->showMessage();
?>
<form name="fpem_accountsview" id="fpem_accountsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_accounts_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_accounts_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_accounts">
<input type="hidden" name="modal" value="<?php echo (int)$pem_accounts_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($pem_accounts->acc_id->Visible) { // acc_id ?>
	<tr id="r_acc_id">
		<td class="<?php echo $pem_accounts_view->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_id"><?php echo $pem_accounts->acc_id->caption() ?></span></td>
		<td data-name="acc_id"<?php echo $pem_accounts->acc_id->cellAttributes() ?>>
<span id="el_pem_accounts_acc_id">
<span<?php echo $pem_accounts->acc_id->viewAttributes() ?>>
<?php echo $pem_accounts->acc_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_accounts->acc_name->Visible) { // acc_name ?>
	<tr id="r_acc_name">
		<td class="<?php echo $pem_accounts_view->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_name"><?php echo $pem_accounts->acc_name->caption() ?></span></td>
		<td data-name="acc_name"<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<span id="el_pem_accounts_acc_name">
<span<?php echo $pem_accounts->acc_name->viewAttributes() ?>>
<?php echo $pem_accounts->acc_name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_accounts->acc_number->Visible) { // acc_number ?>
	<tr id="r_acc_number">
		<td class="<?php echo $pem_accounts_view->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_number"><?php echo $pem_accounts->acc_number->caption() ?></span></td>
		<td data-name="acc_number"<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<span id="el_pem_accounts_acc_number">
<span<?php echo $pem_accounts->acc_number->viewAttributes() ?>>
<?php echo $pem_accounts->acc_number->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_accounts->acc_balance->Visible) { // acc_balance ?>
	<tr id="r_acc_balance">
		<td class="<?php echo $pem_accounts_view->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_balance"><?php echo $pem_accounts->acc_balance->caption() ?></span></td>
		<td data-name="acc_balance"<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<span id="el_pem_accounts_acc_balance">
<span<?php echo $pem_accounts->acc_balance->viewAttributes() ?>>
<?php echo $pem_accounts->acc_balance->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_accounts->remarks->Visible) { // remarks ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_accounts_view->TableLeftColumnClass ?>"><span id="elh_pem_accounts_remarks"><?php echo $pem_accounts->remarks->caption() ?></span></td>
		<td data-name="remarks"<?php echo $pem_accounts->remarks->cellAttributes() ?>>
<span id="el_pem_accounts_remarks">
<span<?php echo $pem_accounts->remarks->viewAttributes() ?>>
<?php echo $pem_accounts->remarks->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$pem_accounts_view->showPageFooter();
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
$pem_accounts_view->terminate();
?>
