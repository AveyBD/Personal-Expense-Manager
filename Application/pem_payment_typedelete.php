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
$pem_payment_type_delete = new pem_payment_type_delete();

// Run the page
$pem_payment_type_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_payment_type_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fpem_payment_typedelete = currentForm = new ew.Form("fpem_payment_typedelete", "delete");

// Form_CustomValidate event
fpem_payment_typedelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_payment_typedelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_payment_type_delete->showPageHeader(); ?>
<?php
$pem_payment_type_delete->showMessage();
?>
<form name="fpem_payment_typedelete" id="fpem_payment_typedelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_payment_type_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_payment_type_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_payment_type">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pem_payment_type_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
		<th class="<?php echo $pem_payment_type->type_id->headerCellClass() ?>"><span id="elh_pem_payment_type_type_id" class="pem_payment_type_type_id"><?php echo $pem_payment_type->type_id->caption() ?></span></th>
<?php } ?>
<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
		<th class="<?php echo $pem_payment_type->payment_type->headerCellClass() ?>"><span id="elh_pem_payment_type_payment_type" class="pem_payment_type_payment_type"><?php echo $pem_payment_type->payment_type->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pem_payment_type_delete->RecCnt = 0;
$i = 0;
while (!$pem_payment_type_delete->Recordset->EOF) {
	$pem_payment_type_delete->RecCnt++;
	$pem_payment_type_delete->RowCnt++;

	// Set row properties
	$pem_payment_type->resetAttributes();
	$pem_payment_type->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pem_payment_type_delete->loadRowValues($pem_payment_type_delete->Recordset);

	// Render row
	$pem_payment_type_delete->renderRow();
?>
	<tr<?php echo $pem_payment_type->rowAttributes() ?>>
<?php if ($pem_payment_type->type_id->Visible) { // type_id ?>
		<td<?php echo $pem_payment_type->type_id->cellAttributes() ?>>
<span id="el<?php echo $pem_payment_type_delete->RowCnt ?>_pem_payment_type_type_id" class="pem_payment_type_type_id">
<span<?php echo $pem_payment_type->type_id->viewAttributes() ?>>
<?php echo $pem_payment_type->type_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
		<td<?php echo $pem_payment_type->payment_type->cellAttributes() ?>>
<span id="el<?php echo $pem_payment_type_delete->RowCnt ?>_pem_payment_type_payment_type" class="pem_payment_type_payment_type">
<span<?php echo $pem_payment_type->payment_type->viewAttributes() ?>>
<?php echo $pem_payment_type->payment_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pem_payment_type_delete->Recordset->moveNext();
}
$pem_payment_type_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_payment_type_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pem_payment_type_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_payment_type_delete->terminate();
?>
