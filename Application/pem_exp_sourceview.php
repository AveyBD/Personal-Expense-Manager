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
$pem_exp_source_view = new pem_exp_source_view();

// Run the page
$pem_exp_source_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_exp_source_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_exp_source->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fpem_exp_sourceview = currentForm = new ew.Form("fpem_exp_sourceview", "view");

// Form_CustomValidate event
fpem_exp_sourceview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_exp_sourceview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_exp_sourceview.lists["x_source_type"] = <?php echo $pem_exp_source_view->source_type->Lookup->toClientList() ?>;
fpem_exp_sourceview.lists["x_source_type"].options = <?php echo JsonEncode($pem_exp_source_view->source_type->lookupOptions()) ?>;
fpem_exp_sourceview.lists["x_source_acc"] = <?php echo $pem_exp_source_view->source_acc->Lookup->toClientList() ?>;
fpem_exp_sourceview.lists["x_source_acc"].options = <?php echo JsonEncode($pem_exp_source_view->source_acc->lookupOptions()) ?>;
fpem_exp_sourceview.autoSuggests["x_source_acc"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_exp_source->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pem_exp_source_view->ExportOptions->render("body") ?>
<?php
	foreach ($pem_exp_source_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pem_exp_source_view->showPageHeader(); ?>
<?php
$pem_exp_source_view->showMessage();
?>
<form name="fpem_exp_sourceview" id="fpem_exp_sourceview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_exp_source_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_exp_source_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_exp_source">
<input type="hidden" name="modal" value="<?php echo (int)$pem_exp_source_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($pem_exp_source->source_id->Visible) { // source_id ?>
	<tr id="r_source_id">
		<td class="<?php echo $pem_exp_source_view->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_id"><?php echo $pem_exp_source->source_id->caption() ?></span></td>
		<td data-name="source_id"<?php echo $pem_exp_source->source_id->cellAttributes() ?>>
<span id="el_pem_exp_source_source_id">
<span<?php echo $pem_exp_source->source_id->viewAttributes() ?>>
<?php echo $pem_exp_source->source_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
	<tr id="r_source_name">
		<td class="<?php echo $pem_exp_source_view->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_name"><?php echo $pem_exp_source->source_name->caption() ?></span></td>
		<td data-name="source_name"<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<span id="el_pem_exp_source_source_name">
<span<?php echo $pem_exp_source->source_name->viewAttributes() ?>>
<?php echo $pem_exp_source->source_name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
	<tr id="r_source_type">
		<td class="<?php echo $pem_exp_source_view->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_type"><?php echo $pem_exp_source->source_type->caption() ?></span></td>
		<td data-name="source_type"<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<span id="el_pem_exp_source_source_type">
<span<?php echo $pem_exp_source->source_type->viewAttributes() ?>>
<?php echo $pem_exp_source->source_type->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
	<tr id="r_source_acc">
		<td class="<?php echo $pem_exp_source_view->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_acc"><?php echo $pem_exp_source->source_acc->caption() ?></span></td>
		<td data-name="source_acc"<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<span id="el_pem_exp_source_source_acc">
<span<?php echo $pem_exp_source->source_acc->viewAttributes() ?>>
<?php echo $pem_exp_source->source_acc->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_exp_source->remarks->Visible) { // remarks ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_exp_source_view->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_remarks"><?php echo $pem_exp_source->remarks->caption() ?></span></td>
		<td data-name="remarks"<?php echo $pem_exp_source->remarks->cellAttributes() ?>>
<span id="el_pem_exp_source_remarks">
<span<?php echo $pem_exp_source->remarks->viewAttributes() ?>>
<?php echo $pem_exp_source->remarks->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$pem_exp_source_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_exp_source->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_exp_source_view->terminate();
?>
