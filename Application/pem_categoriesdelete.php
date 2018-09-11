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
$pem_categories_delete = new pem_categories_delete();

// Run the page
$pem_categories_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_categories_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fpem_categoriesdelete = currentForm = new ew.Form("fpem_categoriesdelete", "delete");

// Form_CustomValidate event
fpem_categoriesdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_categoriesdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_categories_delete->showPageHeader(); ?>
<?php
$pem_categories_delete->showMessage();
?>
<form name="fpem_categoriesdelete" id="fpem_categoriesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_categories_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_categories_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_categories">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pem_categories_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pem_categories->category->Visible) { // category ?>
		<th class="<?php echo $pem_categories->category->headerCellClass() ?>"><span id="elh_pem_categories_category" class="pem_categories_category"><?php echo $pem_categories->category->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pem_categories_delete->RecCnt = 0;
$i = 0;
while (!$pem_categories_delete->Recordset->EOF) {
	$pem_categories_delete->RecCnt++;
	$pem_categories_delete->RowCnt++;

	// Set row properties
	$pem_categories->resetAttributes();
	$pem_categories->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pem_categories_delete->loadRowValues($pem_categories_delete->Recordset);

	// Render row
	$pem_categories_delete->renderRow();
?>
	<tr<?php echo $pem_categories->rowAttributes() ?>>
<?php if ($pem_categories->category->Visible) { // category ?>
		<td<?php echo $pem_categories->category->cellAttributes() ?>>
<span id="el<?php echo $pem_categories_delete->RowCnt ?>_pem_categories_category" class="pem_categories_category">
<span<?php echo $pem_categories->category->viewAttributes() ?>>
<?php echo $pem_categories->category->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pem_categories_delete->Recordset->moveNext();
}
$pem_categories_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_categories_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pem_categories_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_categories_delete->terminate();
?>
