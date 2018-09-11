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
$pem_categories_view = new pem_categories_view();

// Run the page
$pem_categories_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_categories_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$pem_categories->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fpem_categoriesview = currentForm = new ew.Form("fpem_categoriesview", "view");

// Form_CustomValidate event
fpem_categoriesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_categoriesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$pem_categories->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pem_categories_view->ExportOptions->render("body") ?>
<?php
	foreach ($pem_categories_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pem_categories_view->showPageHeader(); ?>
<?php
$pem_categories_view->showMessage();
?>
<form name="fpem_categoriesview" id="fpem_categoriesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_categories_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_categories_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_categories">
<input type="hidden" name="modal" value="<?php echo (int)$pem_categories_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($pem_categories->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id">
		<td class="<?php echo $pem_categories_view->TableLeftColumnClass ?>"><span id="elh_pem_categories_cat_id"><?php echo $pem_categories->cat_id->caption() ?></span></td>
		<td data-name="cat_id"<?php echo $pem_categories->cat_id->cellAttributes() ?>>
<span id="el_pem_categories_cat_id">
<span<?php echo $pem_categories->cat_id->viewAttributes() ?>>
<?php echo $pem_categories->cat_id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_categories->category->Visible) { // category ?>
	<tr id="r_category">
		<td class="<?php echo $pem_categories_view->TableLeftColumnClass ?>"><span id="elh_pem_categories_category"><?php echo $pem_categories->category->caption() ?></span></td>
		<td data-name="category"<?php echo $pem_categories->category->cellAttributes() ?>>
<span id="el_pem_categories_category">
<span<?php echo $pem_categories->category->viewAttributes() ?>>
<?php echo $pem_categories->category->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pem_categories->remarks->Visible) { // remarks ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_categories_view->TableLeftColumnClass ?>"><span id="elh_pem_categories_remarks"><?php echo $pem_categories->remarks->caption() ?></span></td>
		<td data-name="remarks"<?php echo $pem_categories->remarks->cellAttributes() ?>>
<span id="el_pem_categories_remarks">
<span<?php echo $pem_categories->remarks->viewAttributes() ?>>
<?php echo $pem_categories->remarks->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$pem_categories_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$pem_categories->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pem_categories_view->terminate();
?>
