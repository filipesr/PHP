<?php
class ControllerPaymentMercadopago extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/mercadopago');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('mercadopago', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_dolar'] = $this->language->get('text_dolar');
		$this->data['text_pesos'] = $this->language->get('text_pesos');

		$this->data['entry_id_comercio'] = $this->language->get('entry_id_comercio');
		$this->data['entry_clave'] = $this->language->get('entry_clave');
        $this->data['entry_type_currency'] = $this->language->get('entry_type_currency');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        if (isset($this->error['id_comercio'])) {
			$this->data['error_id_comercio'] = $this->error['id_comercio'];
		} else {
			$this->data['error_id_comercio'] = '';
		}

		if (isset($this->error['clave'])) {
			$this->data['error_clave'] = $this->error['clave'];
		} else {
			$this->data['error_clave'] = '';
		}

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment',
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/mercadopago',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/mercadopago&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		if (isset($this->request->post['mercadopago_id_comercio'])) {
			$this->data['mercadopago_id_comercio'] = $this->request->post['mercadopago_id_comercio'];
		} else {
			$this->data['mercadopago_id_comercio'] = $this->config->get('mercadopago_id_comercio');
		}

		if (isset($this->request->post['mercadopago_clave'])) {
			$this->data['mercadopago_clave'] = $this->request->post['mercadopago_clave'];
		} else {
			$this->data['mercadopago_clave'] = $this->config->get('mercadopago_clave');
		}

		if (isset($this->request->post['mercadopago_currency'])) {
			$this->data['mercadopago_currency'] = $this->request->post['mercadopago_currency'];
		} else {
			$this->data['mercadopago_currency'] = $this->config->get('mercadopago_currency');
		}

		if (isset($this->request->post['mercadopago_order_status_id'])) {
			$this->data['mercadopago_order_status_id'] = $this->request->post['mercadopago_order_status_id'];
		} else {
			$this->data['mercadopago_order_status_id'] = $this->config->get('mercadopago_order_status_id');
		}

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['mercadopago_geo_zone_id'])) {
			$this->data['mercadopago_geo_zone_id'] = $this->request->post['mercadopago_geo_zone_id'];
		} else {
			$this->data['mercadopago_geo_zone_id'] = $this->config->get('mercadopago_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['mercadopago_status'])) {
			$this->data['mercadopago_status'] = $this->request->post['mercadopago_status'];
		} else {
			$this->data['mercadopago_status'] = $this->config->get('mercadopago_status');
		}

		if (isset($this->request->post['mercadopago_sort_order'])) {
			$this->data['mercadopago_sort_order'] = $this->request->post['mercadopago_sort_order'];
		} else {
			$this->data['mercadopago_sort_order'] = $this->config->get('mercadopago_sort_order');
		}

		$this->template = 'payment/mercadopago.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/mercadopago')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['mercadopago_id_comercio']) {
			$this->error['id_comercio'] = $this->language->get('error_id_comercio');
		}

		if (!$this->request->post['mercadopago_clave']) {
			$this->error['clave'] = $this->language->get('error_clave');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>