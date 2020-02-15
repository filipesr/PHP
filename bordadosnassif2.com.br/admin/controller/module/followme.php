<?php
// -----------------------------------------------------
// Follow Me for Opencart v1.5.1    
// Modified by villagedefrance                          
// contact@villagedefrance.net                                      
// -----------------------------------------------------

class ControllerModuleFollowMe extends Controller {
	private $error = array();
	private $_name = 'followme';
	private $_version = '1.5.1 V2'; 

	public function index() {
		$this->load->language('module/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data[$this->_name . '_version'] = $this->_version;
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_villagedefrance'] = $this->language->get('text_villagedefrance');
		$this->data['text_module_settings'] = $this->language->get('text_module_settings');
		
		$this->data['entry_header'] = $this->language->get('entry_header'); 
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_box'] = $this->language->get('entry_box');
		$this->data['entry_yes'] = $this->language->get('entry_yes'); 
		$this->data['entry_no']	= $this->language->get('entry_no');
		
		$this->data['entry_facebook'] = $this->language->get('entry_facebook');
        $this->data['entry_twitter'] = $this->language->get('entry_twitter');
		$this->data['entry_google'] = $this->language->get('entry_google');
		$this->data['entry_face'] = $this->language->get('entry_face');
        $this->data['entry_twit'] = $this->language->get('entry_twit');
		$this->data['entry_gplus'] = $this->language->get('entry_gplus');
		
		$this->data['entry_template']	= $this->language->get('entry_template');
        
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['templates'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}	
		
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');			
		}	
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title' . $language['language_id']])) {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->request->post[$this->_name . '_title' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->config->get($this->_name . '_title' . $language['language_id']);
			}
		}
		
		$this->data['languages'] = $languages;
		
		if (isset($this->request->post[$this->_name . '_header'])) {
			$this->data[$this->_name . '_header'] = $this->request->post[$this->_name . '_header'];
		} else {
			$this->data[$this->_name . '_header'] = $this->config->get( $this->_name . '_header' );
		}
		
		if (isset($this->request->post[$this->_name . '_title'])) { 
			$this->data[$this->_name . '_title'] = $this->request->post[$this->_name . '_title']; 
		} else { 
			$this->data[$this->_name . '_title'] = $this->config->get($this->_name . '_title' ); 
		} 
		
		if (isset($this->request->post[$this->_name . '_icon'])) { 
			$this->data[$this->_name . '_icon'] = $this->request->post[$this->_name . '_icon']; 
		} else { 
			$this->data[$this->_name . '_icon'] = $this->config->get($this->_name . '_icon' ); 
		} 
		
		if (isset($this->request->post[$this->_name . '_box'])) { 
			$this->data[$this->_name . '_box'] = $this->request->post[$this->_name . '_box']; 
		} else { 
			$this->data[$this->_name . '_box'] = $this->config->get($this->_name . '_box' ); 
		}
		
		if (isset($this->request->post[$this->_name . '_facebook'])) {
			$this->data[$this->_name . '_facebook'] = $this->request->post[$this->_name . '_facebook'];
		} else {
			$this->data[$this->_name . '_facebook'] = $this->config->get($this->_name . '_facebook');
		}	
        
        if (isset($this->request->post[$this->_name . '_twitter'])) {
			$this->data[$this->_name . '_twitter'] = $this->request->post[$this->_name . '_twitter'];
		} else {
			$this->data[$this->_name . '_twitter'] = $this->config->get($this->_name . '_twitter');
		}
		
		if (isset($this->request->post[$this->_name . '_google'])) {
			$this->data[$this->_name . '_google'] = $this->request->post[$this->_name . '_google'];
		} else {
			$this->data[$this->_name . '_google'] = $this->config->get($this->_name . '_google');
		}
		
		if (isset($this->request->post[$this->_name . '_face'])) {
			$this->data[$this->_name . '_face'] = $this->request->post[$this->_name . '_face'];
		} else {
			$this->data[$this->_name . '_face'] = $this->config->get($this->_name . '_face');
		}	
        
        if (isset($this->request->post[$this->_name . '_twit'])) {
			$this->data[$this->_name . '_twit'] = $this->request->post[$this->_name . '_twit'];
		} else {
			$this->data[$this->_name . '_twit'] = $this->config->get($this->_name . '_twit');
		}
		
		 if (isset($this->request->post[$this->_name . '_gplus'])) {
			$this->data[$this->_name . '_gplus'] = $this->request->post[$this->_name . '_gplus'];
		} else {
			$this->data[$this->_name . '_gplus'] = $this->config->get($this->_name . '_gplus');
		}
		
		if (isset($this->request->post[$this->_name . '_template'])) {
			$this->data[$this->_name . '_template'] = $this->request->post[$this->_name . '_template'];
		} else {
			$this->data[$this->_name . '_template'] = $this->config->get($this->_name . '_template');
		}
	
		$this->data['modules'] = array();
		
		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) { 
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
	
		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>
