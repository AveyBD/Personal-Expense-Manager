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
$pem_exp_source_addopt = new pem_exp_source_addopt();

// Run the page
$pem_exp_source_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_exp_source_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var fpem_exp_sourceaddopt = currentForm = new ew.Form("fpem_exp_sourceaddopt", "addopt");

// Validate form
fpem_exp_sourceaddopt.validate = function() {
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
		<?php if ($pem_exp_source_addopt->source_name->Required) { ?>
			elm = this.getElements("x" + infix + "_source_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_name->caption(), $pem_exp_source->source_name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_addopt->source_type->Required) { ?>
			elm = this.getElements("x" + infix + "_source_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_type->caption(), $pem_exp_source->source_type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_addopt->source_acc->Required) { ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_acc->caption(), $pem_exp_source->source_acc->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_exp_source->source_acc->errorMessage()) ?>");
		<?php if ($pem_exp_source_addopt->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->remarks->caption(), $pem_exp_source->remarks->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpem_exp_sourceaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_exp_sourceaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_exp_sourceaddopt.lists["x_source_type"] = <?php echo $pem_exp_source_addopt->source_type->Lookup->toClientList() ?>;
fpem_exp_sourceaddopt.lists["x_source_type"].options = <?php echo JsonEncode($pem_exp_source_addopt->source_type->lookupOptions()) ?>;
fpem_exp_sourceaddopt.lists["x_source_acc"] = <?php echo $pem_exp_source_addopt->source_acc->Lookup->toClientList() ?>;
fpem_exp_sourceaddopt.lists["x_source_acc"].options = <?php echo JsonEncode($pem_exp_source_addopt->source_acc->lookupOptions()) ?>;
fpem_exp_sourceaddopt.autoSuggests["x_source_acc"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_exp_source_addopt->showPageHeader(); ?>
<?php
$pem_exp_source_addopt->showMessage();
?>
<form name="fpem_exp_sourceaddopt" id="fpem_exp_sourceaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($pem_exp_source_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_exp_source_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $pem_exp_source_addopt->TableVar ?>">
<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_source_name"><?php echo $pem_exp_source->source_name->caption() ?><?php echo ($pem_exp_source->source_name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x_source_name" id="x_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</div>
	</div>
<?php } ?>
<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_source_type"><?php echo $pem_exp_source->source_type->caption() ?><?php echo ($pem_exp_source->source_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x_source_type" name="x_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x_source_type") ?>
	</select>
</div>
</div>
	</div>
<?php } ?>
<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label"><?php echo $pem_exp_source->source_acc->caption() ?><?php echo ($pem_exp_source->source_acc->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<?php
$wrkonchange = "" . trim(@$pem_exp_source->source_acc->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$pem_exp_source->source_acc->EditAttrs["onchange"] = "";
?>
<span id="as_x_source_acc" class="text-nowrap" style="z-index: 8960">
	<input type="text" class="form-control" name="sv_x_source_acc" id="sv_x_source_acc" value="<?php echo RemoveHtml($pem_exp_source->source_acc->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pem_exp_source->source_acc->getPlaceHolder()) ?>"<?php echo $pem_exp_source->source_acc->editAttributes() ?>>
</span>
<input type="hidden" data-table="pem_exp_source" data-field="x_source_acc" data-value-separator="<?php echo $pem_exp_source->source_acc->displayValueSeparatorAttribute() ?>" name="x_source_acc" id="x_source_acc" value="<?php echo HtmlEncode($pem_exp_source->source_acc->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fpem_exp_sourceaddopt.createAutoSuggest({"id":"x_source_acc","forceSelect":false});
</script>
</div>
	</div>
<?php } ?>
<?php if ($pem_exp_source->remarks->Visible) { // remarks ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_remarks"><?php echo $pem_exp_source->remarks->caption() ?><?php echo ($pem_exp_source->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<textarea data-table="pem_exp_source" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_exp_source->remarks->getPlaceHolder()) ?>"<?php echo $pem_exp_source->remarks->editAttributes() ?>><?php echo $pem_exp_source->remarks->EditValue ?></textarea>
</div>
	</div>
<?php } ?>
</form>
<?php
$pem_exp_source_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$pem_exp_source_addopt->terminate();
?>
