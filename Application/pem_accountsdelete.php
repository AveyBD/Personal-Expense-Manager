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
$pem_accounts_delete = new pem_accounts_delete();

// Run the page
$pem_accounts_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_accounts_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fpem_accountsdelete = currentForm = new ew.Form("fpem_accountsdelete", "delete");

// Form_CustomValidate event
fpem_accountsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_accountsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_accounts_delete->showPageHeader(); ?>
<?php
$pem_accounts_delete->showMessage();
?>
<form name="fpem_accountsdelete" id="fpem_accountsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_accounts_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_accounts_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_accounts">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pem_accounts_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pem_accounts->acc_name->Visible) { // acc_name ?>
		<th class="<?php echo $pem_accounts->acc_name->headerCellClass() ?>"><span id="elh_pem_accounts_acc_name" class="pem_accounts_acc_name"><?php echo $pem_accounts->acc_name->caption() ?></span></th>
<?php } ?>
<?php if ($pem_accounts->acc_number->Visible) { // acc_number ?>
		<th class="<?php echo $pem_accounts->acc_number->headerCellClass() ?>"><span id="elh_pem_accounts_acc_number" class="pem_accounts_acc_number"><?php echo $pem_accounts->acc_number->caption() ?></span></th>
<?php } ?>
<?php if ($pem_accounts->acc_balance->Visible) { // acc_balance ?>
		<th class="<?php echo $pem_accounts->acc_balance->headerCellClass() ?>"><span id="elh_pem_accounts_acc_balance" class="pem_accounts_acc_balance"><?php echo $pem_accounts->acc_balance->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pem_accounts_delete->RecCnt = 0;
$i = 0;
while (!$pem_accounts_delete->Recordset->EOF) {
	$pem_accounts_delete->RecCnt++;
	$pem_accounts_delete->RowCnt++;

	// Set row properties
	$pem_accounts->resetAttributes();
	$pem_accounts->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pem_accounts_delete->loadRowValues($pem_accounts_delete->Recordset);

	// Render row
	$pem_accounts_delete->renderRow();
?>
	<tr<?php echo $pem_accounts->rowAttributes() ?>>
<?php if ($pem_accounts->acc_name->Visible) { // acc_name ?>
		<td<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<span id="el<?php echo $pem_accounts_delete->RowCnt ?>_pem_accounts_acc_name" class="pem_accounts_acc_name">
<span<?php echo $pem_accounts->acc_name->viewAttributes() ?>>
<?php echo $pem_accounts->acc_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_accounts->acc_number->Visible) { // acc_number ?>
		<td<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<span id="el<?php echo $pem_accounts_delete->RowCnt ?>_pem_accounts_acc_number" class="pem_accounts_acc_number">
<span<?php echo $pem_accounts->acc_number->viewAttributes() ?>>
<?php echo $pem_accounts->acc_number->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_accounts->acc_balance->Visible) { // acc_balance ?>
		<td<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<span id="el<?php echo $pem_accounts_delete->RowCnt ?>_pem_accounts_acc_balance" class="pem_accounts_acc_balance">
<span<?php echo $pem_accounts->acc_balance->viewAttributes() ?>>
<?php echo $pem_accounts->acc_balance->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pem_accounts_delete->Recordset->moveNext();
}
$pem_accounts_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_accounts_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pem_accounts_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_accounts_delete->terminate();
?>
