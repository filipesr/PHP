<?php defined('_JEXEC') or die('Restricted access');
global $option;
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
  <fieldset class="adminform">
    <legend><?php echo JText::_( 'Details' ); ?></legend>

    <table class="admintable">
    <tr>
      <td width="100" align="right" class="key">
        <label for="title">
          <?php echo JText::_( 'Title' ); ?>:
        </label>
      </td>
      <td>
        <input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->item->title; ?>" />
      </td>
    </tr>
    <tr>
      <td width="100" align="right" class="key">
        <label for="catid">
          <?php echo JText::_( 'Category' ); ?>:
        </label>
      </td>
      <td>
        <?php echo $lists['catid']; ?>
      </td>
    </tr>
  </table>
  </fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo _CM_NAME; ?>" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="items" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
