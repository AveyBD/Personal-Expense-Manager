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
$pem_exp_source_add = new pem_exp_source_add();

// Run the page
$pem_exp_source_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_exp_source_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fpem_exp_sourceadd = currentForm = new ew.Form("fpem_exp_sourceadd", "add");

// Validate form
fpem_exp_sourceadd.validate = function() {
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
		<?php if ($pem_exp_source_add->source_name->Required) { ?>
			elm = this.getElements("x" + infix + "_source_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_name->caption(), $pem_exp_source->source_name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_add->source_type->Required) { ?>
			elm = this.getElements("x" + infix + "_source_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_type->caption(), $pem_exp_source->source_type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_exp_source_add->source_acc->Required) { ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->source_acc->caption(), $pem_exp_source->source_acc->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_source_acc");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_exp_source->source_acc->errorMessage()) ?>");
		<?php if ($pem_exp_source_add->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_exp_source->remarks->caption(), $pem_exp_source->remarks->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ew.forms[val])
			if (!ew.forms[val].validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpem_exp_sourceadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_exp_sourceadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_exp_sourceadd.lists["x_source_type"] = <?php echo $pem_exp_source_add->source_type->Lookup->toClientList() ?>;
fpem_exp_sourceadd.lists["x_source_type"].options = <?php echo JsonEncode($pem_exp_source_add->source_type->lookupOptions()) ?>;
fpem_exp_sourceadd.lists["x_source_acc"] = <?php echo $pem_exp_source_add->source_acc->Lookup->toClientList() ?>;
fpem_exp_sourceadd.lists["x_source_acc"].options = <?php echo JsonEncode($pem_exp_source_add->source_acc->lookupOptions()) ?>;
fpem_exp_sourceadd.autoSuggests["x_source_acc"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_exp_source_add->showPageHeader(); ?>
<?php
$pem_exp_source_add->showMessage();
?>
<form name="fpem_exp_sourceadd" id="fpem_exp_sourceadd" class="<?php echo $pem_exp_source_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_exp_source_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_exp_source_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_exp_source">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$pem_exp_source_add->IsModal ?>">
<?php if (!$pem_exp_source_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_pem_exp_sourceadd" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($pem_exp_source->source_name->Visible) { // source_name ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
	<div id="r_source_name" class="form-group row">
		<label id="elh_pem_exp_source_source_name" for="x_source_name" class="<?php echo $pem_exp_source_add->LeftColumnClass ?>"><?php echo $pem_exp_source->source_name->caption() ?><?php echo ($pem_exp_source->source_name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_exp_source_add->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<span id="el_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x_source_name" id="x_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<?php echo $pem_exp_source->source_name->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_source_name">
		<td class="<?php echo $pem_exp_source_add->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_name"><?php echo $pem_exp_source->source_name->caption() ?><?php echo ($pem_exp_source->source_name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_exp_source->source_name->cellAttributes() ?>>
<span id="el_pem_exp_source_source_name">
<input type="text" data-table="pem_exp_source" data-field="x_source_name" name="x_source_name" id="x_source_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_exp_source->source_name->getPlaceHolder()) ?>" value="<?php echo $pem_exp_source->source_name->EditValue ?>"<?php echo $pem_exp_source->source_name->editAttributes() ?>>
</span>
<?php echo $pem_exp_source->source_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_exp_source->source_type->Visible) { // source_type ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
	<div id="r_source_type" class="form-group row">
		<label id="elh_pem_exp_source_source_type" for="x_source_type" class="<?php echo $pem_exp_source_add->LeftColumnClass ?>"><?php echo $pem_exp_source->source_type->caption() ?><?php echo ($pem_exp_source->source_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_exp_source_add->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<span id="el_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x_source_type" name="x_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_exp_source->source_type->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_source_type">
		<td class="<?php echo $pem_exp_source_add->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_type"><?php echo $pem_exp_source->source_type->caption() ?><?php echo ($pem_exp_source->source_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_exp_source->source_type->cellAttributes() ?>>
<span id="el_pem_exp_source_source_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_exp_source" data-field="x_source_type" data-value-separator="<?php echo $pem_exp_source->source_type->displayValueSeparatorAttribute() ?>" id="x_source_type" name="x_source_type"<?php echo $pem_exp_source->source_type->editAttributes() ?>>
		<?php echo $pem_exp_source->source_type->selectOptionListHtml("x_source_type") ?>
	</select>
<?php echo $pem_exp_source->source_type->Lookup->getParamTag("p_x_source_type") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_payment_type") && !$pem_exp_source->source_type->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_source_type" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_exp_source->source_type->caption() ?>" data-title="<?php echo $pem_exp_source->source_type->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_source_type',url:'pem_payment_typeaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_exp_source->source_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_exp_source->source_acc->Visible) { // source_acc ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
	<div id="r_source_acc" class="form-group row">
		<label id="elh_pem_exp_source_source_acc" class="<?php echo $pem_exp_source_add->LeftColumnClass ?>"><?php echo $pem_exp_source->source_acc->caption() ?><?php echo ($pem_exp_source->source_acc->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_exp_source_add->RightColumnClass ?>"><div<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<span id="el_pem_exp_source_source_acc">
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
fpem_exp_sourceadd.createAutoSuggest({"id":"x_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x_source_acc") ?>
</span>
<?php echo $pem_exp_source->source_acc->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_source_acc">
		<td class="<?php echo $pem_exp_source_add->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_source_acc"><?php echo $pem_exp_source->source_acc->caption() ?><?php echo ($pem_exp_source->source_acc->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_exp_source->source_acc->cellAttributes() ?>>
<span id="el_pem_exp_source_source_acc">
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
fpem_exp_sourceadd.createAutoSuggest({"id":"x_source_acc","forceSelect":false});
</script>
<?php echo $pem_exp_source->source_acc->Lookup->getParamTag("p_x_source_acc") ?>
</span>
<?php echo $pem_exp_source->source_acc->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_exp_source->remarks->Visible) { // remarks ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
	<div id="r_remarks" class="form-group row">
		<label id="elh_pem_exp_source_remarks" for="x_remarks" class="<?php echo $pem_exp_source_add->LeftColumnClass ?>"><?php echo $pem_exp_source->remarks->caption() ?><?php echo ($pem_exp_source->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_exp_source_add->RightColumnClass ?>"><div<?php echo $pem_exp_source->remarks->cellAttributes() ?>>
<span id="el_pem_exp_source_remarks">
<textarea data-table="pem_exp_source" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_exp_source->remarks->getPlaceHolder()) ?>"<?php echo $pem_exp_source->remarks->editAttributes() ?>><?php echo $pem_exp_source->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_exp_source->remarks->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_exp_source_add->TableLeftColumnClass ?>"><span id="elh_pem_exp_source_remarks"><?php echo $pem_exp_source->remarks->caption() ?><?php echo ($pem_exp_source->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_exp_source->remarks->cellAttributes() ?>>
<span id="el_pem_exp_source_remarks">
<textarea data-table="pem_exp_source" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_exp_source->remarks->getPlaceHolder()) ?>"<?php echo $pem_exp_source->remarks->editAttributes() ?>><?php echo $pem_exp_source->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_exp_source->remarks->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_exp_source_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$pem_exp_source_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pem_exp_source_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_exp_source_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$pem_exp_source_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$pem_exp_source_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_exp_source_add->terminate();
?>
