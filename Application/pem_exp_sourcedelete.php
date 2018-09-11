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
$pem_exp_source_delete = new pem_exp_source_delete();

// Run the page
$pem_exp_source_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_exp_source_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fpem_exp_sourcedelete = currentForm = new ew.Form("fpem_exp_sourcedelete", "delete");

// Form_CustomValidate event
fpem_exp_sourcedelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_exp_sourcedelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_exp_sourcedelete.lists["x_source_type"] = <?php echo $pem_exp_source_delete->source_type->Lookup->toClientList() ?>;
fpem_exp_sourcedelete.lists["x_source_type"].options = <?php echo JsonEncode($pem_exp_source_delete->source_type->lookupOptions()) ?>;
fpem_exp_sourcedelete.lists["x_source_acc"] = <?php echo $pem_exp_source_delete->source_acc->Lookup->toClientList() ?>;
fpem_exp_sourcedelete.lists["x_source_acc"].options = <?php echo JsonEncode($pem_exp_source_delete->source_acc->lookupOptions()) ?>;
fpem_exp_sourcedelete.autoSuggests["x_source_acc"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_exp_source_delete->showPageHeader(); ?>
<?php
$pem_exp_source_delete->showMessage();
?>
<form name="fpem_exp_sourcedelete" id="fpem_exp_sourcedelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_exp_source_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_exp_source_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_exp_source">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pem_exp_source_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
		<th class="<?php echo $pem_exp_source->source_name->headerCellClass() ?>"><span id="elh_pem_exp_source_source_name" class="pem_exp_source_source_name"><?php echo $pem_exp_source->source_name->caption() ?></span></th>
<?php } ?>
<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
		<th class="<?php echo $pem_exp_source->source_type->headerCellClass() ?>"><span id="elh_pem_exp_source_source_type" class="pem_exp_source_source_type"><?php echo $pem_exp_source->source_type->caption() ?></span></th>
<?php } ?>
<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
		<th class="<?php echo $pem_exp_source->source_acc->headerCellClass() ?>"><span id="elh_pem_exp_source_source_acc" class="pem_exp_source_source_acc"><?php echo $pem_exp_source->source_acc->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pem_exp_source_delete->RecCnt = 0;
$i = 0;
while (!$pem_exp_source_delete->Recordset->EOF) {
	$pem_exp_source_delete->RecCnt++;
	$pem_exp_source_delete->RowCnt++;

	// Set row properties
	$pem_exp_source->resetAttributes();
	$pem_exp_source->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pem_exp_source_delete->loadRowValues($pem_exp_source_delete->Recordset);

	// Render row
	$pem_exp_source_delete->renderRow();
?>
	<tr<?php echo $pem_exp_source->rowAttributes() ?>>
<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
		<td<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<span id="el<?php echo $pem_exp_source_delete->RowCnt ?>_pem_exp_source_source_name" class="pem_exp_source_source_name">
<span<?php echo $pem_exp_source->source_name->viewAttributes() ?>>
<?php echo $pem_exp_source->source_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
		<td<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<span id="el<?php echo $pem_exp_source_delete->RowCnt ?>_pem_exp_source_source_type" class="pem_exp_source_source_type">
<span<?php echo $pem_exp_source->source_type->viewAttributes() ?>>
<?php echo $pem_exp_source->source_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
		<td<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<span id="el<?php echo $pem_exp_source_delete->RowCnt ?>_pem_exp_source_source_acc" class="pem_exp_source_source_acc">
<span<?php echo $pem_exp_source->source_acc->viewAttributes() ?>>
<?php echo $pem_exp_source->source_acc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pem_exp_source_delete->Recordset->moveNext();
}
$pem_exp_source_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_exp_source_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pem_exp_source_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_exp_source_delete->terminate();
?>
