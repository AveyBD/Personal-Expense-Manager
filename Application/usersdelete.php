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
$users_delete = new users_delete();

// Run the page
$users_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fusersdelete = currentForm = new ew.Form("fusersdelete", "delete");

// Form_CustomValidate event
fusersdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersdelete.lists["x_user_level"] = <?php echo $users_delete->user_level->Lookup->toClientList() ?>;
fusersdelete.lists["x_user_level"].options = <?php echo JsonEncode($users_delete->user_level->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $users_delete->showPageHeader(); ?>
<?php
$users_delete->showMessage();
?>
<form name="fusersdelete" id="fusersdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($users_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($users->id->Visible) { // id ?>
		<th class="<?php echo $users->id->headerCellClass() ?>"><span id="elh_users_id" class="users_id"><?php echo $users->id->caption() ?></span></th>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
		<th class="<?php echo $users->name->headerCellClass() ?>"><span id="elh_users_name" class="users_name"><?php echo $users->name->caption() ?></span></th>
<?php } ?>
<?php if ($users->_login->Visible) { // login ?>
		<th class="<?php echo $users->_login->headerCellClass() ?>"><span id="elh_users__login" class="users__login"><?php echo $users->_login->caption() ?></span></th>
<?php } ?>
<?php if ($users->user_level->Visible) { // user_level ?>
		<th class="<?php echo $users->user_level->headerCellClass() ?>"><span id="elh_users_user_level" class="users_user_level"><?php echo $users->user_level->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$users_delete->RecCnt = 0;
$i = 0;
while (!$users_delete->Recordset->EOF) {
	$users_delete->RecCnt++;
	$users_delete->RowCnt++;

	// Set row properties
	$users->resetAttributes();
	$users->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$users_delete->loadRowValues($users_delete->Recordset);

	// Render row
	$users_delete->renderRow();
?>
	<tr<?php echo $users->rowAttributes() ?>>
<?php if ($users->id->Visible) { // id ?>
		<td<?php echo $users->id->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->viewAttributes() ?>>
<?php echo $users->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
		<td<?php echo $users->name->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_name" class="users_name">
<span<?php echo $users->name->viewAttributes() ?>>
<?php echo $users->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->_login->Visible) { // login ?>
		<td<?php echo $users->_login->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users__login" class="users__login">
<span<?php echo $users->_login->viewAttributes() ?>>
<?php echo $users->_login->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->user_level->Visible) { // user_level ?>
		<td<?php echo $users->user_level->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_user_level" class="users_user_level">
<span<?php echo $users->user_level->viewAttributes() ?>>
<?php echo $users->user_level->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$users_delete->Recordset->moveNext();
}
$users_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $users_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$users_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_delete->terminate();
?>
