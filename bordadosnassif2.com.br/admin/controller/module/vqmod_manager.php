<?php
class ControllerModuleVQModManager extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('module/vqmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

			// Upload VQMod
			if (isset($this->request->post['upload'])) {
				$this->vqmod_upload();
			
			// Settings
			} else {
				$this->model_setting_setting->editSetting('vqmod_manager', $this->request->post);
			
				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_vqmods'] = $this->language->get('heading_vqmods');
		$this->data['heading_settings'] = $this->language->get('heading_settings');
		$this->data['heading_error_log'] = $this->language->get('heading_error_log');
		
		$this->data['column_file_name'] = $this->language->get('column_file_name');
		$this->data['column_id'] = $this->language->get('column_id');
		$this->data['column_version'] = $this->language->get('column_version');
		$this->data['column_vqmver'] = $this->language->get('column_vqmver');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');		
		$this->data['column_delete'] = $this->language->get('column_delete');
		
		$this->data['entry_upload'] = $this->language->get('entry_upload');
		$this->data['entry_vqmod_path'] = $this->language->get('entry_vqmod_path');
		$this->data['entry_vqcache'] = $this->language->get('entry_vqcache');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_ext_version'] = $this->language->get('entry_ext_version');
		
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_install'] = $this->language->get('text_install');
		$this->data['text_uninstall'] = $this->language->get('text_uninstall');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_vqmod_path'] = $this->language->get('text_vqmod_path');
		$this->data['text_autodetect'] = $this->language->get('text_autodetect');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_vqcache_help'] = $this->language->get('text_vqcache_help');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');	
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_upload'] = $this->language->get('button_upload');
		
		$this->data['vqmod_manager_version'] = $this->language->get('vqmod_manager_version');
		
 		// Warning
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		// Error
		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

		// Breadcrumbs
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		// Action Buttons
		$this->data['action'] = $this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		// Clear Cache / Logs
		$this->data['clear_log'] = $this->url->link('module/vqmod_manager/clear_log', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear_vqcache'] = $this->url->link('module/vqmod_manager/clear_cache', 'token=' . $this->session->data['token'], 'SSL');

		/*// VQMod Enabled/Disabled status
		if (isset($this->request->post['vqmod_manager_status'])) {
			$this->data['vqmod_manager_status'] = $this->request->post['vqmod_manager_status'];
		} else {
			$this->data['vqmod_manager_status'] = $this->config->get('vqmod_manager_status');
		}*/
		
		// Get VQMod path
		if (isset($this->request->post['vqmod_path'])) {
			$this->data['vqmod_path'] = $this->request->post['vqmod_path'];
		} else {
			$this->data['vqmod_path'] = $this->config->get('vqmod_path');
		}
		
		// Attempts to autodetect VQMod path
		if (is_null($this->data['vqmod_path']) || strlen($this->data['vqmod_path']) < 1 || !is_dir($this->data['vqmod_path'])) {
			$this->data['path_set'] = FALSE;
			$path = substr_replace(DIR_SYSTEM, '', -7);
			
			if (is_dir($path . 'vqmod/')) {
				$this->data['vqmod_path'] = $path . 'vqmod/';
				
				$this->data['text_autodetect'] = $this->language->get('text_autodetect');
			} else {
				$this->data['text_autodetect'] = $this->language->get('text_autodetect_fail');
			}
		} else {
			$this->data['path_set'] = TRUE;
		}
		
		// Detect mods
		$vqmods = glob($this->data['vqmod_path'] . 'xml/*.xml*');
		
		if (isset($vqmods)) {
			foreach ($vqmods as $vqmod) {
				if (strpos($vqmod, '.xml_')) {
					$file = basename($vqmod, '.xml_');
				} else {
					$file = basename($vqmod, '.xml');
				}
	
				$action = array();
				
				if (strpos($vqmod, '.xml_')) {
					$action[] = array(
						'text' => $this->language->get('text_install'),
						'href' => $this->url->link('module/vqmod_manager/vqmod_install', 'token=' . $this->session->data['token'] . '&vqmod=' . $file, 'SSL')
					);
				} else {
					$action[] = array(
						'text' => $this->language->get('text_uninstall'),
						'href' => $this->url->link('module/vqmod_manager/vqmod_uninstall', 'token=' . $this->session->data['token'] . '&vqmod=' . $file, 'SSL')
					);
				}
				
				$xml = simplexml_load_file($vqmod);
				
				$this->data['vqmods'][$vqmod] = array(
					'file_name'  => basename($vqmod, ''),
					'id'         => isset($xml->id) ? $xml->id : $this->language->get('text_unavailable'),
					'version'    => isset($xml->version) ? $xml->version : $this->language->get('text_unavailable'),
					'vqmver'     => isset($xml->vqmver) ? $xml->vqmver : $this->language->get('text_unavailable'),
					'author'     => isset($xml->author) ? $xml->author : $this->language->get('text_unavailable'),
					'status'     => strpos($vqmod, '.xml_') ? $this->language->get('text_disabled') : $this->language->get('text_enabled'),
					'delete'     => $this->url->link('module/vqmod_manager/vqmod_delete', 'token=' . $this->session->data['token'] . '&vqmod=' . basename($vqmod), 'SSL'),
					'action'     => $action
				);
			}
		}
		
		// VQCache files
		if (isset($this->data['vqmod_path'])) {
			$vqcache_dir = $this->data['vqmod_path'] . 'vqcache/';
			$this->data['vqcache'] = array_diff(scandir($vqcache_dir), array('.', '..'));
		}
		
		// VQMod Error Log
		$log_file = $this->config->get('vqmod_path') . 'vqmod.log';
		
		if (file_exists($log_file)) {
			$this->data['log'] = file_get_contents($log_file, FILE_USE_INCLUDE_PATH, NULL);
		} else {
			$this->data['log'] = '';
		}
		
		// Template
		$this->template = 'module/vqmod_manager.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
	    $this->response->setOutput($this->render());
	}
	
	public function vqmod_install() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission'); 
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$path = $this->config->get('vqmod_path') . 'xml/';
			$vqmod = $this->request->get['vqmod'];
		
			if (file_exists($path . $vqmod . '.xml_')) {
				rename($path . $vqmod . '.xml_', $path . $vqmod . '.xml');
			} else {
				$this->error['warning'] = $this->language->get('error_install');
			}
		}
		
		$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function vqmod_uninstall() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission'); 
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$path = $this->config->get('vqmod_path') . 'xml/';
			$vqmod = $this->request->get['vqmod'];
			
			if (file_exists($path . $vqmod . '.xml')) {
				rename($path . $vqmod . '.xml', $path . $vqmod . '.xml_');
			
				$this->clear_cache();
			} else {
				$this->error['warning'] = $this->language->get('error_uninstall');
			}
		}
		
		$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmod_upload() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission');
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$file = $this->request->files['vqmod_file']['tmp_name'];
			$file_name = $this->request->files['vqmod_file']['name'];
				
			if ($this->request->files['vqmod_file']['error'] > 0) {
				
				switch($this->request->files['vqmod_file']['error']) {
					case 1:
						$this->error['warning'] = $this->language->get('error_ini_max_file_size');
						break;
					case 2:
						$this->error['warning'] = $this->language->get('error_form_max_file_size');
						break;
					case 3:
						$this->error['warning'] = $this->language->get('error_partial_upload');
						break;
					case 4:
						$this->error['warning'] = $this->language->get('error_no_upload');
						break;
					case 6:
						$this->error['warning'] = $this->language->get('error_no_temp_dir');
						break;
					case 7:
						$this->error['warning'] = $this->language->get('error_write_fail');
						break;
					case 8:
						$this->error['warning'] = $this->language->get('error_php_conflict');
						break;
					default:
						$this->error['warning'] = $this->language->get('error_unknown');
				}

			} else {
				if ($this->request->files['vqmod_file']['type'] != 'text/xml') {
					$this->error['warning'] = $this->language->get('error_filetype');
	
				} else {
					libxml_use_internal_errors(true);
					simplexml_load_file($file);
				
					if (libxml_get_errors()) {
						libxml_clear_errors();
						$this->error['warning'] = $this->language->get('error_invalid_xml');
	
					} elseif (move_uploaded_file($file, $this->config->get('vqmod_path') . 'xml/' . $file_name) == FALSE) {
						$this->error['warning'] = $this->language->get('error_move');
					}
				}
			}
		}
	}
	
	public function vqmod_delete() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission'); 
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$path = $this->config->get('vqmod_path') . 'xml/';
			$vqmod = $this->request->get['vqmod'];
			
			if (unlink($path . $vqmod)) {
				$this->clear_cache();
			} else {
				$this->error['warning'] = $this->language->get('error_delete');
			}
		}
		
		$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));	
	}
	
  	public function clear_cache() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission'); 
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$files = glob($this->config->get('vqmod_path') . 'vqcache/' . 'vq*');
		
			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						@touch($file);
						@unlink($file);
						clearstatcache();
					}
				}
			}
		
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
	
	public function clear_log() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
			$this->session->data['error'] = $this->language->get('error_permission');
			
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		} else {	
			$file = $this->config->get('vqmod_path') . 'vqmod.log';
		
			$handle = fopen($file, 'w+'); 
				
			fclose($handle); 			
		
			$this->redirect($this->url->link('module/vqmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/vqmod_manager')) {
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