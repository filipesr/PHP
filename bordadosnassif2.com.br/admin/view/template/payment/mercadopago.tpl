<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="form">
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_id_comercio; ?></td>
        <td><input type="text" name="mercadopago_id_comercio" value="<?php echo $mercadopago_id_comercio; ?>" /></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_clave; ?></td>
        <td><input type="text" name="mercadopago_clave" value="<?php echo $mercadopago_clave; ?>" /></td>
      </tr>
      <tr>
      	<td><?php echo $entry_type_currency; ?></td>
        <td><select name="mercadopago_currency">
            <?php if ($mercadopago_currency) { ?>
            <option value="1" selected="selected"><?php echo $text_pesos; ?></option>
            <option value="0"><?php echo $text_dolar; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_pesos; ?></option>
            <option value="0" selected="selected"><?php echo $text_dolar; ?></option>
            <?php } ?>
        </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="mercadopago_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $mercadopago_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_geo_zone; ?></td>
        <td><select name="mercadopago_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $mercadopago_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="mercadopago_status">
            <?php if ($mercadopago_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input type="text" name="mercadopago_sort_order" value="<?php echo $mercadopago_sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<?php echo $footer; ?>