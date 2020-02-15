<?php  
class ControllerModuleFacebook extends Controller {
	protected function index() {
		$this->language->load('module/facebook');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['code'] = html_entity_decode($this->config->get('facebook_code'));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebook.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/facebook.tpl';
		} else {
			$this->template = 'default/template/module/facebook.tpl';
		}
		
		$this->render();
	}
}
?>