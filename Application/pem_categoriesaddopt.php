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
$pem_categories_addopt = new pem_categories_addopt();

// Run the page
$pem_categories_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_categories_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var fpem_categoriesaddopt = currentForm = new ew.Form("fpem_categoriesaddopt", "addopt");

// Validate form
fpem_categoriesaddopt.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
	if ($fobj.find("#confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		<?php if ($pem_categories_addopt->category->Required) { ?>
			elm = this.getElements("x" + infix + "_category");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->category->caption(), $pem_categories->category->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_categories_addopt->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->remarks->caption(), $pem_categories->remarks->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpem_categoriesaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_categoriesaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_categories_addopt->showPageHeader(); ?>
<?php
$pem_categories_addopt->showMessage();
?>
<form name="fpem_categoriesaddopt" id="fpem_categoriesaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($pem_categories_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_categories_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $pem_categories_addopt->TableVar ?>">
<?php if ($pem_categories->category->Visible) { // category ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_category"><?php echo $pem_categories->category->caption() ?><?php echo ($pem_categories->category->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="pem_categories" data-field="x_category" name="x_category" id="x_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($pem_categories->remarks->Visible) { // remarks ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_remarks"><?php echo $pem_categories->remarks->caption() ?><?php echo ($pem_categories->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<textarea data-table="pem_categories" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_categories->remarks->getPlaceHolder()) ?>"<?php echo $pem_categories->remarks->editAttributes() ?>><?php echo $pem_categories->remarks->EditValue ?></textarea>
</div>
	</div>
<?php } ?>
</form>
<?php
$pem_categories_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$pem_categories_addopt->terminate();
?>
