<?php
class ControllerPaymentMercadopago extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

   		$this->data['action'] = 'https://www.mercadopago.com/mla/buybutton';

		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		// Check for supported currency, otherwise convert to USD. by Q
		$supported_currencies = array('ARS','USD');
		if (in_array($order_info['currency'], $supported_currencies)) {
			$currency = $order_info['currency'];
		} else {
			$currency = 'USD';
		}
		
		$shipping_total = 0;
		if ($this->cart->hasShipping()) {
			$shipping_total = $this->currency->format($this->session->data['shipping_method']['cost'], $currency, FALSE, FALSE);
		}

		$this->data['acc_id'] = $this->config->get('mercadopago_id_comercio');
		$this->data['enc'] = $this->config->get('mercadopago_clave');
		$this->data['name'] = $this->config->get('config_name');
        $this->data['item_id'] = $this->session->data['order_id'];
		$this->data['currency'] = $currency;
		$this->data['price'] =  $this->currency->format($this->cart->getSubTotal(), $currency, $order_info['value'], FALSE);
		$this->data['url_succesfull'] = HTTPS_SERVER . 'index.php?route=payment/mercadopago/confirm';
		if ($shipping_total) {
			$this->data['shipping_cost'] = $shipping_total;
		}
		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['url_cancel'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['url_cancel'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}
		
		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}
		
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mercadopago.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/mercadopago.tpl';
		} else {
			$this->template = 'default/template/payment/mercadopago.tpl';
		}	

		$this->render();		
	}
	
	public function confirm() {
		$this->load->model('checkout/order');
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('dineromail_order_status_id'));
		$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
	}
	
}
?>