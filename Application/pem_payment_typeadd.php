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
$pem_payment_type_add = new pem_payment_type_add();

// Run the page
$pem_payment_type_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_payment_type_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fpem_payment_typeadd = currentForm = new ew.Form("fpem_payment_typeadd", "add");

// Validate form
fpem_payment_typeadd.validate = function() {
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
		<?php if ($pem_payment_type_add->payment_type->Required) { ?>
			elm = this.getElements("x" + infix + "_payment_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_payment_type->payment_type->caption(), $pem_payment_type->payment_type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_payment_type_add->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_payment_type->remarks->caption(), $pem_payment_type->remarks->RequiredErrorMessage)) ?>");
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
fpem_payment_typeadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_payment_typeadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_payment_type_add->showPageHeader(); ?>
<?php
$pem_payment_type_add->showMessage();
?>
<form name="fpem_payment_typeadd" id="fpem_payment_typeadd" class="<?php echo $pem_payment_type_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_payment_type_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_payment_type_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_payment_type">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$pem_payment_type_add->IsModal ?>">
<?php if (!$pem_payment_type_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($pem_payment_type_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_pem_payment_typeadd" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($pem_payment_type->payment_type->Visible) { // payment_type ?>
<?php if ($pem_payment_type_add->IsMobileOrModal) { ?>
	<div id="r_payment_type" class="form-group row">
		<label id="elh_pem_payment_type_payment_type" for="x_payment_type" class="<?php echo $pem_payment_type_add->LeftColumnClass ?>"><?php echo $pem_payment_type->payment_type->caption() ?><?php echo ($pem_payment_type->payment_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_payment_type_add->RightColumnClass ?>"><div<?php echo $pem_payment_type->payment_type->cellAttributes() ?>>
<span id="el_pem_payment_type_payment_type">
<input type="text" data-table="pem_payment_type" data-field="x_payment_type" name="x_payment_type" id="x_payment_type" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_payment_type->payment_type->getPlaceHolder()) ?>" value="<?php echo $pem_payment_type->payment_type->EditValue ?>"<?php echo $pem_payment_type->payment_type->editAttributes() ?>>
</span>
<?php echo $pem_payment_type->payment_type->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_type">
		<td class="<?php echo $pem_payment_type_add->TableLeftColumnClass ?>"><span id="elh_pem_payment_type_payment_type"><?php echo $pem_payment_type->payment_type->caption() ?><?php echo ($pem_payment_type->payment_type->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_payment_type->payment_type->cellAttributes() ?>>
<span id="el_pem_payment_type_payment_type">
<input type="text" data-table="pem_payment_type" data-field="x_payment_type" name="x_payment_type" id="x_payment_type" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_payment_type->payment_type->getPlaceHolder()) ?>" value="<?php echo $pem_payment_type->payment_type->EditValue ?>"<?php echo $pem_payment_type->payment_type->editAttributes() ?>>
</span>
<?php echo $pem_payment_type->payment_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_payment_type->remarks->Visible) { // remarks ?>
<?php if ($pem_payment_type_add->IsMobileOrModal) { ?>
	<div id="r_remarks" class="form-group row">
		<label id="elh_pem_payment_type_remarks" for="x_remarks" class="<?php echo $pem_payment_type_add->LeftColumnClass ?>"><?php echo $pem_payment_type->remarks->caption() ?><?php echo ($pem_payment_type->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_payment_type_add->RightColumnClass ?>"><div<?php echo $pem_payment_type->remarks->cellAttributes() ?>>
<span id="el_pem_payment_type_remarks">
<textarea data-table="pem_payment_type" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_payment_type->remarks->getPlaceHolder()) ?>"<?php echo $pem_payment_type->remarks->editAttributes() ?>><?php echo $pem_payment_type->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_payment_type->remarks->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_payment_type_add->TableLeftColumnClass ?>"><span id="elh_pem_payment_type_remarks"><?php echo $pem_payment_type->remarks->caption() ?><?php echo ($pem_payment_type->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_payment_type->remarks->cellAttributes() ?>>
<span id="el_pem_payment_type_remarks">
<textarea data-table="pem_payment_type" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_payment_type->remarks->getPlaceHolder()) ?>"<?php echo $pem_payment_type->remarks->editAttributes() ?>><?php echo $pem_payment_type->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_payment_type->remarks->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_payment_type_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$pem_payment_type_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pem_payment_type_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_payment_type_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$pem_payment_type_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$pem_payment_type_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_payment_type_add->terminate();
?>
