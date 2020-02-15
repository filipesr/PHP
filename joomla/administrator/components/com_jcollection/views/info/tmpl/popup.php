<?php
defined('_JEXEC') or die('Restricted access');
global $option;
?>

<form action="index.php" method="post" name="adminForm" autocomplete="off">
  <fieldset>
    <div style="float: right">
      <button type="button" onclick="submitbutton('save');window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close();window.parent.location.reload()', 700);">
      <?php echo JText::_( 'Save' );?></button>
      <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();">
      <?php echo JText::_( 'Cancel' );?></button>
    </div>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo JText::_( 'Associated item and type' ); ?>
    </legend>
    <table class="admintable">
      <tr>
        <td width="100" align="right" class="key">
          <label for="itemid">
            <?php echo JText::_( 'Item' ); ?>:
          </label>
        </td>
        <td>
          <?php echo $this->lists['itemid']; ?>
        </td>
      </tr>
      <tr>
        <td width="100" align="right" class="key">
          <label for="typeid">
            <?php echo JText::_( 'Type' ); ?>:
          </label>
        </td>
        <td>
          <?php echo $this->lists['typeid']; ?>
        </td>
      </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo JText::_( 'Info fields' ); ?>
    </legend>
    <table class="admintable">
      <tr>
        <td width="100" align="right" class="key">
          <label for="info1">
            <?php echo JText::_( 'Info #1' ); ?>:
          </label>
        </td>
        <td>
          <input class="text_area" type="text" name="info1" id="info1" size="32" maxlength="250" value="<?php echo $this->item->info1; ?>" />
        </td>
      </tr>
      <tr>
        <td width="100" align="right" class="key">
          <label for="info2">
            <?php echo JText::_( 'Info #2' ); ?>:
          </label>
        </td>
        <td>
          <input class="text_area" type="text" name="info2" id="info2" size="32" maxlength="250" value="<?php echo $this->item->info2; ?>" />
        </td>
      </tr>
      <tr>
        <td width="100" align="right" class="key">
          <label for="info3">
            <?php echo JText::_( 'Info #3' ); ?>:
          </label>
        </td>
        <td>
          <input class="text_area" type="text" name="info3" id="info3" size="32" maxlength="250" value="<?php echo $this->item->info3; ?>" />
        </td>
      </tr>

    </table>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo JText::_( 'Parameters' ); ?>
    </legend>
    <?php echo $this->params->render(); ?>
  </fieldset>

  <input type="hidden" name="id" value="<?php echo intval($this->item->id); ?>" />
  <input type="hidden" name="itemid" value="<?php echo intval($this->item->itemid); ?>" />
  <input type="hidden" name="option" value="<? echo $option; ?>" />

  <input type="hidden" name="controller" value="infos" />
  <input type="hidden" name="view" value="info" />
  <input type="hidden" name="task" value="" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>
