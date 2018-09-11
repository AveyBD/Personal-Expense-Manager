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
$pem_accounts_edit = new pem_accounts_edit();

// Run the page
$pem_accounts_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_accounts_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fpem_accountsedit = currentForm = new ew.Form("fpem_accountsedit", "edit");

// Validate form
fpem_accountsedit.validate = function() {
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
		<?php if ($pem_accounts_edit->acc_id->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_id");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_id->caption(), $pem_accounts->acc_id->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_accounts_edit->acc_name->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_name->caption(), $pem_accounts->acc_name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_accounts_edit->acc_number->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_number");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_number->caption(), $pem_accounts->acc_number->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_accounts_edit->acc_balance->Required) { ?>
			elm = this.getElements("x" + infix + "_acc_balance");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->acc_balance->caption(), $pem_accounts->acc_balance->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_acc_balance");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($pem_accounts->acc_balance->errorMessage()) ?>");
		<?php if ($pem_accounts_edit->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_accounts->remarks->caption(), $pem_accounts->remarks->RequiredErrorMessage)) ?>");
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
fpem_accountsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_accountsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_accounts_edit->showPageHeader(); ?>
<?php
$pem_accounts_edit->showMessage();
?>
<form name="fpem_accountsedit" id="fpem_accountsedit" class="<?php echo $pem_accounts_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_accounts_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_accounts_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_accounts">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$pem_accounts_edit->IsModal ?>">
<?php if (!$pem_accounts_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_pem_accountsedit" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($pem_accounts->acc_id->Visible) { // acc_id ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
	<div id="r_acc_id" class="form-group row">
		<label id="elh_pem_accounts_acc_id" class="<?php echo $pem_accounts_edit->LeftColumnClass ?>"><?php echo $pem_accounts->acc_id->caption() ?><?php echo ($pem_accounts->acc_id->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_accounts_edit->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_id->cellAttributes() ?>>
<span id="el_pem_accounts_acc_id">
<span<?php echo $pem_accounts->acc_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($pem_accounts->acc_id->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_id" name="x_acc_id" id="x_acc_id" value="<?php echo HtmlEncode($pem_accounts->acc_id->CurrentValue) ?>">
<?php echo $pem_accounts->acc_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_acc_id">
		<td class="<?php echo $pem_accounts_edit->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_id"><?php echo $pem_accounts->acc_id->caption() ?><?php echo ($pem_accounts->acc_id->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_accounts->acc_id->cellAttributes() ?>>
<span id="el_pem_accounts_acc_id">
<span<?php echo $pem_accounts->acc_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($pem_accounts->acc_id->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="pem_accounts" data-field="x_acc_id" name="x_acc_id" id="x_acc_id" value="<?php echo HtmlEncode($pem_accounts->acc_id->CurrentValue) ?>">
<?php echo $pem_accounts->acc_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_accounts->acc_name->Visible) { // acc_name ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
	<div id="r_acc_name" class="form-group row">
		<label id="elh_pem_accounts_acc_name" for="x_acc_name" class="<?php echo $pem_accounts_edit->LeftColumnClass ?>"><?php echo $pem_accounts->acc_name->caption() ?><?php echo ($pem_accounts->acc_name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_accounts_edit->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<span id="el_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x_acc_name" id="x_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_name->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_acc_name">
		<td class="<?php echo $pem_accounts_edit->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_name"><?php echo $pem_accounts->acc_name->caption() ?><?php echo ($pem_accounts->acc_name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_accounts->acc_name->cellAttributes() ?>>
<span id="el_pem_accounts_acc_name">
<input type="text" data-table="pem_accounts" data-field="x_acc_name" name="x_acc_name" id="x_acc_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_name->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_name->EditValue ?>"<?php echo $pem_accounts->acc_name->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_accounts->acc_number->Visible) { // acc_number ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
	<div id="r_acc_number" class="form-group row">
		<label id="elh_pem_accounts_acc_number" for="x_acc_number" class="<?php echo $pem_accounts_edit->LeftColumnClass ?>"><?php echo $pem_accounts->acc_number->caption() ?><?php echo ($pem_accounts->acc_number->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_accounts_edit->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<span id="el_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x_acc_number" id="x_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_acc_number">
		<td class="<?php echo $pem_accounts_edit->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_number"><?php echo $pem_accounts->acc_number->caption() ?><?php echo ($pem_accounts->acc_number->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_accounts->acc_number->cellAttributes() ?>>
<span id="el_pem_accounts_acc_number">
<input type="text" data-table="pem_accounts" data-field="x_acc_number" name="x_acc_number" id="x_acc_number" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_accounts->acc_number->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_number->EditValue ?>"<?php echo $pem_accounts->acc_number->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_accounts->acc_balance->Visible) { // acc_balance ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
	<div id="r_acc_balance" class="form-group row">
		<label id="elh_pem_accounts_acc_balance" for="x_acc_balance" class="<?php echo $pem_accounts_edit->LeftColumnClass ?>"><?php echo $pem_accounts->acc_balance->caption() ?><?php echo ($pem_accounts->acc_balance->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_accounts_edit->RightColumnClass ?>"><div<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<span id="el_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x_acc_balance" id="x_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_balance->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_acc_balance">
		<td class="<?php echo $pem_accounts_edit->TableLeftColumnClass ?>"><span id="elh_pem_accounts_acc_balance"><?php echo $pem_accounts->acc_balance->caption() ?><?php echo ($pem_accounts->acc_balance->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_accounts->acc_balance->cellAttributes() ?>>
<span id="el_pem_accounts_acc_balance">
<input type="text" data-table="pem_accounts" data-field="x_acc_balance" name="x_acc_balance" id="x_acc_balance" size="30" placeholder="<?php echo HtmlEncode($pem_accounts->acc_balance->getPlaceHolder()) ?>" value="<?php echo $pem_accounts->acc_balance->EditValue ?>"<?php echo $pem_accounts->acc_balance->editAttributes() ?>>
</span>
<?php echo $pem_accounts->acc_balance->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_accounts->remarks->Visible) { // remarks ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
	<div id="r_remarks" class="form-group row">
		<label id="elh_pem_accounts_remarks" for="x_remarks" class="<?php echo $pem_accounts_edit->LeftColumnClass ?>"><?php echo $pem_accounts->remarks->caption() ?><?php echo ($pem_accounts->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_accounts_edit->RightColumnClass ?>"><div<?php echo $pem_accounts->remarks->cellAttributes() ?>>
<span id="el_pem_accounts_remarks">
<textarea data-table="pem_accounts" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_accounts->remarks->getPlaceHolder()) ?>"<?php echo $pem_accounts->remarks->editAttributes() ?>><?php echo $pem_accounts->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_accounts->remarks->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_accounts_edit->TableLeftColumnClass ?>"><span id="elh_pem_accounts_remarks"><?php echo $pem_accounts->remarks->caption() ?><?php echo ($pem_accounts->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_accounts->remarks->cellAttributes() ?>>
<span id="el_pem_accounts_remarks">
<textarea data-table="pem_accounts" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_accounts->remarks->getPlaceHolder()) ?>"<?php echo $pem_accounts->remarks->editAttributes() ?>><?php echo $pem_accounts->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_accounts->remarks->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_accounts_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$pem_accounts_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pem_accounts_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_accounts_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$pem_accounts_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$pem_accounts_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_accounts_edit->terminate();
?>
