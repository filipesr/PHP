<?php
//-----------------------------------------------------
// TagCloud for Opencart v1.5.1    
// Created by villagedefrance                          
// contact@villagedefrance.net                                    
//-----------------------------------------------------

class ControllerModuleTagCloud extends Controller {

	private $_name = 'tagcloud';
	
	protected function index() {
		$this->load->language('module/' . $this->_name);

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title' . $language['language_id']])) {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->request->post[$this->_name . '_title' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->config->get($this->_name . '_title' . $language['language_id']);
			}
		}
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		$this->data['header'] = $this->config->get($this->_name . '_header');
		
		$this->data['icon'] = $this->config->get($this->_name . '_icon');
 
		if( !$this->data['title'] ) { 
			$this->data['title'] = $this->data['heading_title']; 
		} 
		
		if( !$this->data['header'] ) { 
			$this->data['title'] = ''; 
		}
		
		$this->data['box'] = $this->config->get($this->_name . '_box');

		$this->data['text_notags'] = $this->language->get('text_notags');
		
		$this->load->model('module/tagcloud');
		
		$this->data['tagcloud'] = $this->model_module_tagcloud->getRandomTags(
			$this->config->get($this->_name . '_limit'),
			(int)$this->config->get($this->_name . '_min_font_size'),
			(int)$this->config->get($this->_name . '_max_font_size'),
			$this->config->get($this->_name . '_font_weight')
		);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/module/' . $this->_name . '.tpl';
			}
			
		$this->render();
	}
}
?>
