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
$users_view = new users_view();

// Run the page
$users_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$users->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fusersview = currentForm = new ew.Form("fusersview", "view");

// Form_CustomValidate event
fusersview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersview.lists["x_user_level"] = <?php echo $users_view->user_level->Lookup->toClientList() ?>;
fusersview.lists["x_user_level"].options = <?php echo JsonEncode($users_view->user_level->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$users->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $users_view->ExportOptions->render("body") ?>
<?php
	foreach ($users_view->OtherOptions as &$option)
		$option->render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $users_view->showPageHeader(); ?>
<?php
$users_view->showMessage();
?>
<form name="fusersview" id="fusersview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="modal" value="<?php echo (int)$users_view->IsModal ?>">
<table class="table ew-view-table">
<?php if ($users->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_id"><?php echo $users->id->caption() ?></span></td>
		<td data-name="id"<?php echo $users->id->cellAttributes() ?>>
<span id="el_users_id">
<span<?php echo $users->id->viewAttributes() ?>>
<?php echo $users->id->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_name"><?php echo $users->name->caption() ?></span></td>
		<td data-name="name"<?php echo $users->name->cellAttributes() ?>>
<span id="el_users_name">
<span<?php echo $users->name->viewAttributes() ?>>
<?php echo $users->name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<tr id="r__email">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users__email"><?php echo $users->_email->caption() ?></span></td>
		<td data-name="_email"<?php echo $users->_email->cellAttributes() ?>>
<span id="el_users__email">
<span<?php echo $users->_email->viewAttributes() ?>>
<?php if ((!EmptyString($users->_email->getViewValue())) && $users->_email->linkAttributes() <> "") { ?>
<a<?php echo $users->_email->linkAttributes() ?>><?php echo $users->_email->getViewValue() ?></a>
<?php } else { ?>
<?php echo $users->_email->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->_login->Visible) { // login ?>
	<tr id="r__login">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users__login"><?php echo $users->_login->caption() ?></span></td>
		<td data-name="_login"<?php echo $users->_login->cellAttributes() ?>>
<span id="el_users__login">
<span<?php echo $users->_login->viewAttributes() ?>>
<?php echo $users->_login->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<tr id="r_password">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_password"><?php echo $users->password->caption() ?></span></td>
		<td data-name="password"<?php echo $users->password->cellAttributes() ?>>
<span id="el_users_password">
<span<?php echo $users->password->viewAttributes() ?>>
<?php echo $users->password->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->user_level->Visible) { // user_level ?>
	<tr id="r_user_level">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_user_level"><?php echo $users->user_level->caption() ?></span></td>
		<td data-name="user_level"<?php echo $users->user_level->cellAttributes() ?>>
<span id="el_users_user_level">
<span<?php echo $users->user_level->viewAttributes() ?>>
<?php echo $users->user_level->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->profile_photo->Visible) { // profile_photo ?>
	<tr id="r_profile_photo">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_profile_photo"><?php echo $users->profile_photo->caption() ?></span></td>
		<td data-name="profile_photo"<?php echo $users->profile_photo->cellAttributes() ?>>
<span id="el_users_profile_photo">
<span<?php echo $users->profile_photo->viewAttributes() ?>>
<?php echo $users->profile_photo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->profile_info->Visible) { // profile_info ?>
	<tr id="r_profile_info">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_profile_info"><?php echo $users->profile_info->caption() ?></span></td>
		<td data-name="profile_info"<?php echo $users->profile_info->cellAttributes() ?>>
<span id="el_users_profile_info">
<span<?php echo $users->profile_info->viewAttributes() ?>>
<?php echo $users->profile_info->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$users_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$users->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_view->terminate();
?>
