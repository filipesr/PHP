<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div style="font-weight: bold;"><?php echo $text_modules_tip;?><hr/></div>
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><select name="team_msn_chat_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="team_msn_chat_module[<?php echo $module_row; ?>][position]">
                <?php if ($module['position'] == 'content_top') { ?>
                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                <?php } else { ?>
                <option value="content_top"><?php echo $text_content_top; ?></option>
                <?php } ?>  
                <?php if ($module['position'] == 'content_bottom') { ?>
                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                <?php } else { ?>
                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                <?php } ?>     
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="team_msn_chat_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="team_msn_chat_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="4"></td>
            <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
       <div style="font-weight: bold;"><?php echo $text_accounts_tip;?><hr/></div>
      <table id="account" class="list">
        <thead>
          <tr>
           <td class="left"><?php echo $entry_name; ?></td>
            <td class="left"><?php echo $entry_html; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td></td>
          </tr>
        </thead>
    <?php $account_row = 0; ?>
        <?php foreach ($accounts as $account) { ?>
        <tbody id="account-row<?php echo $account_row; ?>">
          <tr>
            <td class="left">
                <input style="width:97%;"  type="text" name="team_msn_chat_accounts[<?php echo $account_row; ?>][name]" value="<?php echo $account['name']; ?>" size="30" />
                <?php if (isset($account['error']['name'])){?>
                
                <br/><span style="color:red;"><?php echo $account['error']['name']; ?></span>
                
               <?php } ?>
            </td>
            <td class="left">
               <?php if (isset($account['error']['html'])){?>
                 <?php echo $text_html_tip;?><br/>
                 <textarea  style="width:97%;" rows="7" cols="25" name="team_msn_chat_accounts[<?php echo $account_row; ?>][html]"   size="30" /><?php echo $account['html']; ?></textarea>
                <br/><span style="color:red;"><?php echo $account['error']['html']; ?></span>
               <?php }else{ ?>
                <input style="width:97%;" type="text" name="team_msn_chat_accounts[<?php echo $account_row; ?>][html]" value="<?php echo $account['html']; ?>" size="60" />
                <?php } ?>
            </td>
            <td class="left">
                <select   name="team_msn_chat_accounts[<?php echo $account_row; ?>][status]">
                    <?php if ($account['status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="left"><a onclick="$('#account-row<?php echo $account_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $account_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td class="left"><a onclick="addAccount();" class="button"><span><?php echo $button_add_account; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
      <div><?php echo $text_guide;?></div>
  </div>
</div>
<script type="text/javascript"><!--
var account_row = <?php echo $account_row; ?>;

function addAccount() {	
	html  = '<tbody id="account-row' + account_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input  style="width:97%;" type="text" name="team_msn_chat_accounts[' + account_row + '][name]"   size="30" /></td>';
	html += '    <td class="left"><?php echo $text_html_tip;?><br/><textarea  style="width:97%;" rows="7" cols="25" name="team_msn_chat_accounts[' + account_row + '][html]"   size="30" /></td>';	
	html += '    <td class="left"><select name="team_msn_chat_accounts[' + account_row + '][status]">';
        html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
        html += '      <option value="0"><?php echo $text_disabled; ?></option>';
        html += '    </select></td>';
	html += '    <td class="left"><a onclick="$(\'#account-row' + account_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#account tfoot').before(html);
	
	account_row++;
}
//--></script>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="team_msn_chat_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="team_msn_chat_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="team_msn_chat_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="team_msn_chat_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
<?php echo $footer; ?>