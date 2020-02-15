<?php
class ControllerModuleTeamMsnChat extends Controller {
	protected function index($setting) {
      
		$this->language->load('module/team_msn_chat');
 
                $this->data['heading_title'] = $this->language->get('heading_title');
				
		$this->data['button_cart'] = $this->language->get('button_cart');
		
                $accounts = $this->config->get('team_msn_chat_accounts');
                
                $this->data['accounts'] = array();
                
                if ($accounts){
                    
                    
                    $i = 0;
                    
                    foreach ($accounts as $account){
                        
                        if ($account['status']){
                        
                            $account_info = explode('&mkt=', $account['html']);

                            $this->data['accounts'][$i]['name'] = $account['name'];

                            $this->data['accounts'][$i]['address'] = $account_info[0];

                            $this->data['accounts'][$i]['language'] = $account_info[1];


                            $i++;
                        
                        }
                          
                    }
                    
                }
 
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/team_msn_chat.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/team_msn_chat.tpl';
		} else {
			$this->template = 'default/template/module/team_msn_chat.tpl';
		}

		$this->render();
	}
}
?>