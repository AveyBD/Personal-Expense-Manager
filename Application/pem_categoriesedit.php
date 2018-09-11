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
$pem_categories_edit = new pem_categories_edit();

// Run the page
$pem_categories_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pem_categories_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fpem_categoriesedit = currentForm = new ew.Form("fpem_categoriesedit", "edit");

// Validate form
fpem_categoriesedit.validate = function() {
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
		<?php if ($pem_categories_edit->cat_id->Required) { ?>
			elm = this.getElements("x" + infix + "_cat_id");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->cat_id->caption(), $pem_categories->cat_id->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_categories_edit->category->Required) { ?>
			elm = this.getElements("x" + infix + "_category");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->category->caption(), $pem_categories->category->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($pem_categories_edit->remarks->Required) { ?>
			elm = this.getElements("x" + infix + "_remarks");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pem_categories->remarks->caption(), $pem_categories->remarks->RequiredErrorMessage)) ?>");
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
fpem_categoriesedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fpem_categoriesedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $pem_categories_edit->showPageHeader(); ?>
<?php
$pem_categories_edit->showMessage();
?>
<form name="fpem_categoriesedit" id="fpem_categoriesedit" class="<?php echo $pem_categories_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($pem_categories_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $pem_categories_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pem_categories">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$pem_categories_edit->IsModal ?>">
<?php if (!$pem_categories_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($pem_categories_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_pem_categoriesedit" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($pem_categories->cat_id->Visible) { // cat_id ?>
<?php if ($pem_categories_edit->IsMobileOrModal) { ?>
	<div id="r_cat_id" class="form-group row">
		<label id="elh_pem_categories_cat_id" class="<?php echo $pem_categories_edit->LeftColumnClass ?>"><?php echo $pem_categories->cat_id->caption() ?><?php echo ($pem_categories->cat_id->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_categories_edit->RightColumnClass ?>"><div<?php echo $pem_categories->cat_id->cellAttributes() ?>>
<span id="el_pem_categories_cat_id">
<span<?php echo $pem_categories->cat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($pem_categories->cat_id->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="pem_categories" data-field="x_cat_id" name="x_cat_id" id="x_cat_id" value="<?php echo HtmlEncode($pem_categories->cat_id->CurrentValue) ?>">
<?php echo $pem_categories->cat_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_cat_id">
		<td class="<?php echo $pem_categories_edit->TableLeftColumnClass ?>"><span id="elh_pem_categories_cat_id"><?php echo $pem_categories->cat_id->caption() ?><?php echo ($pem_categories->cat_id->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_categories->cat_id->cellAttributes() ?>>
<span id="el_pem_categories_cat_id">
<span<?php echo $pem_categories->cat_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($pem_categories->cat_id->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="pem_categories" data-field="x_cat_id" name="x_cat_id" id="x_cat_id" value="<?php echo HtmlEncode($pem_categories->cat_id->CurrentValue) ?>">
<?php echo $pem_categories->cat_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_categories->category->Visible) { // category ?>
<?php if ($pem_categories_edit->IsMobileOrModal) { ?>
	<div id="r_category" class="form-group row">
		<label id="elh_pem_categories_category" for="x_category" class="<?php echo $pem_categories_edit->LeftColumnClass ?>"><?php echo $pem_categories->category->caption() ?><?php echo ($pem_categories->category->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_categories_edit->RightColumnClass ?>"><div<?php echo $pem_categories->category->cellAttributes() ?>>
<span id="el_pem_categories_category">
<input type="text" data-table="pem_categories" data-field="x_category" name="x_category" id="x_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</span>
<?php echo $pem_categories->category->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_category">
		<td class="<?php echo $pem_categories_edit->TableLeftColumnClass ?>"><span id="elh_pem_categories_category"><?php echo $pem_categories->category->caption() ?><?php echo ($pem_categories->category->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_categories->category->cellAttributes() ?>>
<span id="el_pem_categories_category">
<input type="text" data-table="pem_categories" data-field="x_category" name="x_category" id="x_category" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($pem_categories->category->getPlaceHolder()) ?>" value="<?php echo $pem_categories->category->EditValue ?>"<?php echo $pem_categories->category->editAttributes() ?>>
</span>
<?php echo $pem_categories->category->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_categories->remarks->Visible) { // remarks ?>
<?php if ($pem_categories_edit->IsMobileOrModal) { ?>
	<div id="r_remarks" class="form-group row">
		<label id="elh_pem_categories_remarks" for="x_remarks" class="<?php echo $pem_categories_edit->LeftColumnClass ?>"><?php echo $pem_categories->remarks->caption() ?><?php echo ($pem_categories->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pem_categories_edit->RightColumnClass ?>"><div<?php echo $pem_categories->remarks->cellAttributes() ?>>
<span id="el_pem_categories_remarks">
<textarea data-table="pem_categories" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_categories->remarks->getPlaceHolder()) ?>"<?php echo $pem_categories->remarks->editAttributes() ?>><?php echo $pem_categories->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_categories->remarks->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_remarks">
		<td class="<?php echo $pem_categories_edit->TableLeftColumnClass ?>"><span id="elh_pem_categories_remarks"><?php echo $pem_categories->remarks->caption() ?><?php echo ($pem_categories->remarks->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $pem_categories->remarks->cellAttributes() ?>>
<span id="el_pem_categories_remarks">
<textarea data-table="pem_categories" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pem_categories->remarks->getPlaceHolder()) ?>"<?php echo $pem_categories->remarks->editAttributes() ?>><?php echo $pem_categories->remarks->EditValue ?></textarea>
</span>
<?php echo $pem_categories->remarks->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($pem_categories_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$pem_categories_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pem_categories_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pem_categories_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$pem_categories_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$pem_categories_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pem_categories_edit->terminate();
?>
