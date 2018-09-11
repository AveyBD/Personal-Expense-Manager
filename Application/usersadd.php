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
$users_add = new users_add();

// Run the page
$users_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fusersadd = currentForm = new ew.Form("fusersadd", "add");

// Validate form
fusersadd.validate = function() {
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
		<?php if ($users_add->name->Required) { ?>
			elm = this.getElements("x" + infix + "_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->name->caption(), $users->name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->_email->Required) { ?>
			elm = this.getElements("x" + infix + "__email");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->_email->caption(), $users->_email->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->_login->Required) { ?>
			elm = this.getElements("x" + infix + "__login");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->_login->caption(), $users->_login->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->password->Required) { ?>
			elm = this.getElements("x" + infix + "_password");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->password->caption(), $users->password->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->user_level->Required) { ?>
			elm = this.getElements("x" + infix + "_user_level");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->user_level->caption(), $users->user_level->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->profile_photo->Required) { ?>
			elm = this.getElements("x" + infix + "_profile_photo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->profile_photo->caption(), $users->profile_photo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->profile_info->Required) { ?>
			elm = this.getElements("x" + infix + "_profile_info");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->profile_info->caption(), $users->profile_info->RequiredErrorMessage)) ?>");
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
fusersadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersadd.lists["x_user_level"] = <?php echo $users_add->user_level->Lookup->toClientList() ?>;
fusersadd.lists["x_user_level"].options = <?php echo JsonEncode($users_add->user_level->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $users_add->showPageHeader(); ?>
<?php
$users_add->showMessage();
?>
<form name="fusersadd" id="fusersadd" class="<?php echo $users_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$users_add->IsModal ?>">
<!-- Fields to prevent google autofill -->
<input class="d-none" type="text" name="<?php echo Encrypt(Random()) ?>">
<input class="d-none" type="password" name="<?php echo Encrypt(Random()) ?>">
<?php if (!$users_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($users_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_usersadd" class="table ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r_name" class="form-group row">
		<label id="elh_users_name" for="x_name" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->name->caption() ?><?php echo ($users->name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->name->cellAttributes() ?>>
<span id="el_users_name">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->editAttributes() ?>>
</span>
<?php echo $users->name->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_name">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users_name"><?php echo $users->name->caption() ?><?php echo ($users->name->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->name->cellAttributes() ?>>
<span id="el_users_name">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->editAttributes() ?>>
</span>
<?php echo $users->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r__email" class="form-group row">
		<label id="elh_users__email" for="x__email" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->_email->caption() ?><?php echo ($users->_email->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->editAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r__email">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users__email"><?php echo $users->_email->caption() ?><?php echo ($users->_email->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->editAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->_login->Visible) { // login ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r__login" class="form-group row">
		<label id="elh_users__login" for="x__login" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->_login->caption() ?><?php echo ($users->_login->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->_login->cellAttributes() ?>>
<span id="el_users__login">
<input type="text" data-table="users" data-field="x__login" name="x__login" id="x__login" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->_login->getPlaceHolder()) ?>" value="<?php echo $users->_login->EditValue ?>"<?php echo $users->_login->editAttributes() ?>>
</span>
<?php echo $users->_login->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r__login">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users__login"><?php echo $users->_login->caption() ?><?php echo ($users->_login->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->_login->cellAttributes() ?>>
<span id="el_users__login">
<input type="text" data-table="users" data-field="x__login" name="x__login" id="x__login" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->_login->getPlaceHolder()) ?>" value="<?php echo $users->_login->EditValue ?>"<?php echo $users->_login->editAttributes() ?>>
</span>
<?php echo $users->_login->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r_password" class="form-group row">
		<label id="elh_users_password" for="x_password" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->password->caption() ?><?php echo ($users->password->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->password->cellAttributes() ?>>
<span id="el_users_password">
<input type="text" data-table="users" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->password->getPlaceHolder()) ?>" value="<?php echo $users->password->EditValue ?>"<?php echo $users->password->editAttributes() ?>>
</span>
<?php echo $users->password->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_password">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users_password"><?php echo $users->password->caption() ?><?php echo ($users->password->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->password->cellAttributes() ?>>
<span id="el_users_password">
<input type="text" data-table="users" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($users->password->getPlaceHolder()) ?>" value="<?php echo $users->password->EditValue ?>"<?php echo $users->password->editAttributes() ?>>
</span>
<?php echo $users->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->user_level->Visible) { // user_level ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r_user_level" class="form-group row">
		<label id="elh_users_user_level" for="x_user_level" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->user_level->caption() ?><?php echo ($users->user_level->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->user_level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_user_level">
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->user_level->EditValue) ?>">
</span>
<?php } else { ?>
<span id="el_users_user_level">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_user_level" data-value-separator="<?php echo $users->user_level->displayValueSeparatorAttribute() ?>" id="x_user_level" name="x_user_level"<?php echo $users->user_level->editAttributes() ?>>
		<?php echo $users->user_level->selectOptionListHtml("x_user_level") ?>
	</select>
<?php echo $users->user_level->Lookup->getParamTag("p_x_user_level") ?>
</div>
</span>
<?php } ?>
<?php echo $users->user_level->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_user_level">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users_user_level"><?php echo $users->user_level->caption() ?><?php echo ($users->user_level->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->user_level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_user_level">
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->user_level->EditValue) ?>">
</span>
<?php } else { ?>
<span id="el_users_user_level">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_user_level" data-value-separator="<?php echo $users->user_level->displayValueSeparatorAttribute() ?>" id="x_user_level" name="x_user_level"<?php echo $users->user_level->editAttributes() ?>>
		<?php echo $users->user_level->selectOptionListHtml("x_user_level") ?>
	</select>
<?php echo $users->user_level->Lookup->getParamTag("p_x_user_level") ?>
</div>
</span>
<?php } ?>
<?php echo $users->user_level->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->profile_photo->Visible) { // profile_photo ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r_profile_photo" class="form-group row">
		<label id="elh_users_profile_photo" for="x_profile_photo" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->profile_photo->caption() ?><?php echo ($users->profile_photo->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->profile_photo->cellAttributes() ?>>
<span id="el_users_profile_photo">
<input type="text" data-table="users" data-field="x_profile_photo" name="x_profile_photo" id="x_profile_photo" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($users->profile_photo->getPlaceHolder()) ?>" value="<?php echo $users->profile_photo->EditValue ?>"<?php echo $users->profile_photo->editAttributes() ?>>
</span>
<?php echo $users->profile_photo->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_profile_photo">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users_profile_photo"><?php echo $users->profile_photo->caption() ?><?php echo ($users->profile_photo->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->profile_photo->cellAttributes() ?>>
<span id="el_users_profile_photo">
<input type="text" data-table="users" data-field="x_profile_photo" name="x_profile_photo" id="x_profile_photo" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($users->profile_photo->getPlaceHolder()) ?>" value="<?php echo $users->profile_photo->EditValue ?>"<?php echo $users->profile_photo->editAttributes() ?>>
</span>
<?php echo $users->profile_photo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users->profile_info->Visible) { // profile_info ?>
<?php if ($users_add->IsMobileOrModal) { ?>
	<div id="r_profile_info" class="form-group row">
		<label id="elh_users_profile_info" for="x_profile_info" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->profile_info->caption() ?><?php echo ($users->profile_info->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->profile_info->cellAttributes() ?>>
<span id="el_users_profile_info">
<textarea data-table="users" data-field="x_profile_info" name="x_profile_info" id="x_profile_info" cols="35" rows="4" placeholder="<?php echo HtmlEncode($users->profile_info->getPlaceHolder()) ?>"<?php echo $users->profile_info->editAttributes() ?>><?php echo $users->profile_info->EditValue ?></textarea>
</span>
<?php echo $users->profile_info->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_profile_info">
		<td class="<?php echo $users_add->TableLeftColumnClass ?>"><span id="elh_users_profile_info"><?php echo $users->profile_info->caption() ?><?php echo ($users->profile_info->Required) ? $Language->Phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $users->profile_info->cellAttributes() ?>>
<span id="el_users_profile_info">
<textarea data-table="users" data-field="x_profile_info" name="x_profile_info" id="x_profile_info" cols="35" rows="4" placeholder="<?php echo HtmlEncode($users->profile_info->getPlaceHolder()) ?>"<?php echo $users->profile_info->editAttributes() ?>><?php echo $users->profile_info->EditValue ?></textarea>
</span>
<?php echo $users->profile_info->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($users_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$users_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $users_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $users_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$users_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$users_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_add->terminate();
?>
