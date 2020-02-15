<?php  
class ControllerModuledisplaymessage extends Controller {
	protected function index($setting) {
		$this->language->load('module/displaymessage');
		
    		$this->data['header'] = html_entity_decode($setting['header'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
    	
		$this->data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/displaymessage.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/displaymessage.tpl';
		} else {
			$this->template = 'default/template/module/displaymessage.tpl';
		}
		
		$this->render();
	}
}
?>