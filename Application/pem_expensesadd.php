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
$pem_expenses_add = new pem_expenses_add();

// Run the page
$pem_expenses_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_expenses_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fpem_expensesadd = currentForm = new ew.Form("fpem_expensesadd", "add");

// Validate form
fpem_expensesadd.validate = function() {
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
		<?php if ($pem_expenses_add->exp_item->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_item");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_item->caption(), $pem_expenses->exp_item->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_expenses_add->exp_category->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_category");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_category->caption(), $pem_expenses->exp_category->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_expenses_add->payment_type->Required) { ?>
			elm = this.getElements("x" + infix + "_payment_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->payment_type->caption(), $pem_expenses->payment_type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_expenses_add->exp_source->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_source");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_source->caption(), $pem_expenses->exp_source->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_expenses_add->exp_amount->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_amount");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_amount->caption(), $pem_expenses->exp_amount->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_exp_amount");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_expenses->exp_amount->errorMessage()) ?>");
		<?php if ($pem_expenses_add->exp_date->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_date->caption(), $pem_expenses->exp_date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_exp_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_expenses->exp_date->errorMessage()) ?>");
		<?php if ($pem_expenses_add->exp_remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_exp_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->exp_remarks->caption(), $pem_expenses->exp_remarks->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_expenses_add->user_id->Required) { ?>
			elm = this.getElements("x" + infix + "_user_id");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_expenses->user_id->caption(), $pem_expenses->user_id->RequiredErrorMessage)) ?>");
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
fpem_expensesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_expensesadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpem_expensesadd.lists["x_exp_category"] = <?php echo $pem_expenses_add->exp_category->Lookup->toClientList() ?>;
fpem_expensesadd.lists["x_exp_category"].options = <?php echo JsonEncode($pem_expenses_add->exp_category->lookupOptions()) ?>;
fpem_expensesadd.lists["x_payment_type"] = <?php echo $pem_expenses_add->payment_type->Lookup->toClientList() ?>;
fpem_expensesadd.lists["x_payment_type"].options = <?php echo JsonEncode($pem_expenses_add->payment_type->lookupOptions()) ?>;
fpem_expensesadd.lists["x_exp_source"] = <?php echo $pem_expenses_add->exp_source->Lookup->toClientList() ?>;
fpem_expensesadd.lists["x_exp_source"].options = <?php echo JsonEncode($pem_expenses_add->exp_source->lookupOptions()) ?>;
fpem_expensesadd.lists["x_user_id"] = <?php echo $pem_expenses_add->user_id->Lookup->toClientList() ?>;
fpem_expensesadd.lists["x_user_id"].options = <?php echo JsonEncode($pem_expenses_add->user_id->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_expenses_add->showPageHeader(); ?>
<?php
$pem_expenses_add->showMessage();
?>
<form name="fpem_expensesadd" id="fpem_expensesadd" class="<?php echo $pem_expenses_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_expenses_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_expenses_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_expenses">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$pem_expenses_add->IsModal ?>">
<?php if (!$pem_expenses_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_pem_expensesadd" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($pem_expenses->exp_item->Visible) { // exp_item ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_item" class="form-group row">
		<label id="elh_pem_expenses_exp_item" for="x_exp_item" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_item->caption() ?><?php echo ($pem_expenses->exp_item->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_item->cellAttributes() ?>>
<span id="el_pem_expenses_exp_item">
<input type="text" data-table="pem_expenses" data-field="x_exp_item" name="x_exp_item" id="x_exp_item" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_expenses->exp_item->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_item->EditValue ?>"<?php echo $pem_expenses->exp_item->editAttributes() ?>>
</span>
<?php echo $pem_expenses->exp_item->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_item">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_item"><?php echo $pem_expenses->exp_item->caption() ?><?php echo ($pem_expenses->exp_item->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_item->cellAttributes() ?>>
<span id="el_pem_expenses_exp_item">
<input type="text" data-table="pem_expenses" data-field="x_exp_item" name="x_exp_item" id="x_exp_item" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_expenses->exp_item->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_item->EditValue ?>"<?php echo $pem_expenses->exp_item->editAttributes() ?>>
</span>
<?php echo $pem_expenses->exp_item->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_category->Visible) { // exp_category ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_category" class="form-group row">
		<label id="elh_pem_expenses_exp_category" for="x_exp_category" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_category->caption() ?><?php echo ($pem_expenses->exp_category->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_category->cellAttributes() ?>>
<span id="el_pem_expenses_exp_category">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_exp_category" data-value-separator="<?php echo $pem_expenses->exp_category->displayValueSeparatorAttribute() ?>" id="x_exp_category" name="x_exp_category"<?php echo $pem_expenses->exp_category->editAttributes() ?>>
		<?php echo $pem_expenses->exp_category->selectOptionListHtml("x_exp_category") ?>
	</select>
<?php echo $pem_expenses->exp_category->Lookup->getParamTag("p_x_exp_category") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_categories") && !$pem_expenses->exp_category->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_exp_category" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_expenses->exp_category->caption() ?>" data-title="<?php echo $pem_expenses->exp_category->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_exp_category',url:'pem_categoriesaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_expenses->exp_category->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_category">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_category"><?php echo $pem_expenses->exp_category->caption() ?><?php echo ($pem_expenses->exp_category->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_category->cellAttributes() ?>>
<span id="el_pem_expenses_exp_category">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_exp_category" data-value-separator="<?php echo $pem_expenses->exp_category->displayValueSeparatorAttribute() ?>" id="x_exp_category" name="x_exp_category"<?php echo $pem_expenses->exp_category->editAttributes() ?>>
		<?php echo $pem_expenses->exp_category->selectOptionListHtml("x_exp_category") ?>
	</select>
<?php echo $pem_expenses->exp_category->Lookup->getParamTag("p_x_exp_category") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_categories") && !$pem_expenses->exp_category->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_exp_category" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_expenses->exp_category->caption() ?>" data-title="<?php echo $pem_expenses->exp_category->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_exp_category',url:'pem_categoriesaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_expenses->exp_category->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->payment_type->Visible) { // payment_type ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_payment_type" class="form-group row">
		<label id="elh_pem_expenses_payment_type" for="x_payment_type" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->payment_type->caption() ?><?php echo ($pem_expenses->payment_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->payment_type->cellAttributes() ?>>
<span id="el_pem_expenses_payment_type">
<?php $pem_expenses->payment_type->EditAttrs["onchange"] = "ew.updateOptions.call(this);" . @$pem_expenses->payment_type->EditAttrs["onchange"]; ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_payment_type" data-value-separator="<?php echo $pem_expenses->payment_type->displayValueSeparatorAttribute() ?>" id="x_payment_type" name="x_payment_type"<?php echo $pem_expenses->payment_type->editAttributes() ?>>
		<?php echo $pem_expenses->payment_type->selectOptionListHtml("x_payment_type") ?>
	</select>
<?php echo $pem_expenses->payment_type->Lookup->getParamTag("p_x_payment_type") ?>
</div>
</span>
<?php echo $pem_expenses->payment_type->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_type">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_payment_type"><?php echo $pem_expenses->payment_type->caption() ?><?php echo ($pem_expenses->payment_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->payment_type->cellAttributes() ?>>
<span id="el_pem_expenses_payment_type">
<?php $pem_expenses->payment_type->EditAttrs["onchange"] = "ew.updateOptions.call(this);" . @$pem_expenses->payment_type->EditAttrs["onchange"]; ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_payment_type" data-value-separator="<?php echo $pem_expenses->payment_type->displayValueSeparatorAttribute() ?>" id="x_payment_type" name="x_payment_type"<?php echo $pem_expenses->payment_type->editAttributes() ?>>
		<?php echo $pem_expenses->payment_type->selectOptionListHtml("x_payment_type") ?>
	</select>
<?php echo $pem_expenses->payment_type->Lookup->getParamTag("p_x_payment_type") ?>
</div>
</span>
<?php echo $pem_expenses->payment_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_source->Visible) { // exp_source ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_source" class="form-group row">
		<label id="elh_pem_expenses_exp_source" for="x_exp_source" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_source->caption() ?><?php echo ($pem_expenses->exp_source->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_source->cellAttributes() ?>>
<span id="el_pem_expenses_exp_source">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_exp_source" data-value-separator="<?php echo $pem_expenses->exp_source->displayValueSeparatorAttribute() ?>" id="x_exp_source" name="x_exp_source"<?php echo $pem_expenses->exp_source->editAttributes() ?>>
		<?php echo $pem_expenses->exp_source->selectOptionListHtml("x_exp_source") ?>
	</select>
<?php echo $pem_expenses->exp_source->Lookup->getParamTag("p_x_exp_source") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_exp_source") && !$pem_expenses->exp_source->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_exp_source" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_expenses->exp_source->caption() ?>" data-title="<?php echo $pem_expenses->exp_source->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_exp_source',url:'pem_exp_sourceaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_expenses->exp_source->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_source">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_source"><?php echo $pem_expenses->exp_source->caption() ?><?php echo ($pem_expenses->exp_source->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_source->cellAttributes() ?>>
<span id="el_pem_expenses_exp_source">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pem_expenses" data-field="x_exp_source" data-value-separator="<?php echo $pem_expenses->exp_source->displayValueSeparatorAttribute() ?>" id="x_exp_source" name="x_exp_source"<?php echo $pem_expenses->exp_source->editAttributes() ?>>
		<?php echo $pem_expenses->exp_source->selectOptionListHtml("x_exp_source") ?>
	</select>
<?php echo $pem_expenses->exp_source->Lookup->getParamTag("p_x_exp_source") ?>
<?php if (AllowAdd(CurrentProjectID() . "pem_exp_source") && !$pem_expenses->exp_source->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_exp_source" title="<?php echo HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $pem_expenses->exp_source->caption() ?>" data-title="<?php echo $pem_expenses->exp_source->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_exp_source',url:'pem_exp_sourceaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</div>
</span>
<?php echo $pem_expenses->exp_source->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_amount->Visible) { // exp_amount ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_amount" class="form-group row">
		<label id="elh_pem_expenses_exp_amount" for="x_exp_amount" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_amount->caption() ?><?php echo ($pem_expenses->exp_amount->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_amount->cellAttributes() ?>>
<span id="el_pem_expenses_exp_amount">
<input type="text" data-table="pem_expenses" data-field="x_exp_amount" name="x_exp_amount" id="x_exp_amount" size="30" placeholder="<?php echo HtmlEncode($pem_expenses->exp_amount->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_amount->EditValue ?>"<?php echo $pem_expenses->exp_amount->editAttributes() ?>>
</span>
<?php echo $pem_expenses->exp_amount->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_amount">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_amount"><?php echo $pem_expenses->exp_amount->caption() ?><?php echo ($pem_expenses->exp_amount->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_amount->cellAttributes() ?>>
<span id="el_pem_expenses_exp_amount">
<input type="text" data-table="pem_expenses" data-field="x_exp_amount" name="x_exp_amount" id="x_exp_amount" size="30" placeholder="<?php echo HtmlEncode($pem_expenses->exp_amount->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_amount->EditValue ?>"<?php echo $pem_expenses->exp_amount->editAttributes() ?>>
</span>
<?php echo $pem_expenses->exp_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_date->Visible) { // exp_date ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_date" class="form-group row">
		<label id="elh_pem_expenses_exp_date" for="x_exp_date" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_date->caption() ?><?php echo ($pem_expenses->exp_date->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_date->cellAttributes() ?>>
<span id="el_pem_expenses_exp_date">
<input type="text" data-table="pem_expenses" data-field="x_exp_date" name="x_exp_date" id="x_exp_date" placeholder="<?php echo HtmlEncode($pem_expenses->exp_date->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_date->EditValue ?>"<?php echo $pem_expenses->exp_date->editAttributes() ?>>
<?php if (!$pem_expenses->exp_date->ReadOnly && !$pem_expenses->exp_date->Disabled && !isset($pem_expenses->exp_date->EditAttrs["readonly"]) && !isset($pem_expenses->exp_date->EditAttrs["disabled"])) { ?>
<script>
ew.createDateTimePicker("fpem_expensesadd", "x_exp_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $pem_expenses->exp_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_date">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_date"><?php echo $pem_expenses->exp_date->caption() ?><?php echo ($pem_expenses->exp_date->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_date->cellAttributes() ?>>
<span id="el_pem_expenses_exp_date">
<input type="text" data-table="pem_expenses" data-field="x_exp_date" name="x_exp_date" id="x_exp_date" placeholder="<?php echo HtmlEncode($pem_expenses->exp_date->getPlaceHolder()) ?>" value="<?php echo $pem_expenses->exp_date->EditValue ?>"<?php echo $pem_expenses->exp_date->editAttributes() ?>>
<?php if (!$pem_expenses->exp_date->ReadOnly && !$pem_expenses->exp_date->Disabled && !isset($pem_expenses->exp_date->EditAttrs["readonly"]) && !isset($pem_expenses->exp_date->EditAttrs["disabled"])) { ?>
<script>
ew.createDateTimePicker("fpem_expensesadd", "x_exp_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $pem_expenses->exp_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses->exp_remarks->Visible) { // exp_remarks ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
	<div id="r_exp_remarks" class="form-group row">
		<label id="elh_pem_expenses_exp_remarks" for="x_exp_remarks" class="<?php echo $pem_expenses_add->LeftColumnClass ?>"><?php echo $pem_expenses->exp_remarks->caption() ?><?php echo ($pem_expenses->exp_remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_expenses_add->RightColumnClass ?>"><div<?php echo $pem_expenses->exp_remarks->cellAttributes() ?>>
<span id="el_pem_expenses_exp_remarks">
<textarea data-table="pem_expenses" data-field="x_exp_remarks" name="x_exp_remarks" id="x_exp_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_expenses->exp_remarks->getPlaceHolder()) ?>"<?php echo $pem_expenses->exp_remarks->editAttributes() ?>><?php echo $pem_expenses->exp_remarks->EditValue ?></textarea>
</span>
<?php echo $pem_expenses->exp_remarks->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_exp_remarks">
		<td class="<?php echo $pem_expenses_add->TableLeftColumnClass ?>"><span id="elh_pem_expenses_exp_remarks"><?php echo $pem_expenses->exp_remarks->caption() ?><?php echo ($pem_expenses->exp_remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_expenses->exp_remarks->cellAttributes() ?>>
<span id="el_pem_expenses_exp_remarks">
<textarea data-table="pem_expenses" data-field="x_exp_remarks" name="x_exp_remarks" id="x_exp_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_expenses->exp_remarks->getPlaceHolder()) ?>"<?php echo $pem_expenses->exp_remarks->editAttributes() ?>><?php echo $pem_expenses->exp_remarks->EditValue ?></textarea>
</span>
<?php echo $pem_expenses->exp_remarks->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_expenses_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$pem_expenses_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pem_expenses_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_expenses_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$pem_expenses_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$pem_expenses_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_expenses_add->terminate();
?>
