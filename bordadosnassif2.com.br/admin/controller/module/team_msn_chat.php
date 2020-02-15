<?php

class ControllerModuleTeamMsnChat extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/team_msn_chat');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('team_msn_chat', $this->request->post);

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
        $this->data['text_guide'] = $this->language->get('text_guide');
        $this->data['text_modules_tip'] = $this->language->get('text_modules_tip');
        $this->data['text_accounts_tip'] = $this->language->get('text_accounts_tip');
        $this->data['text_html_tip'] = $this->language->get('text_html_tip');

        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_position'] = $this->language->get('entry_position');
        
        $this->data['entry_name'] = $this->language->get('entry_account_name');
        $this->data['entry_html'] = $this->language->get('entry_account_html');

        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_module'] = $this->language->get('button_add_module');
        $this->data['button_add_account'] = $this->language->get('button_add_account');
        $this->data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/team_msn_chat', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/team_msn_chat', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

 
        $this->data['accounts'] = array();
        $this->data['modules'] =array();
        
        if (isset($this->request->post['team_msn_chat_module'])){
            
          $this->data['modules'] = $this->request->post['team_msn_chat_module'];
          
        }elseif ($this->config->get('team_msn_chat_module')){
            $this->data['modules'] = $this->config->get('team_msn_chat_module');
        }
        
        if (isset($this->request->post['team_msn_chat_accounts'])){
            
          $this->data['accounts'] = $this->request->post['team_msn_chat_accounts'];
          
        }elseif ($this->config->get('team_msn_chat_accounts')){
            $this->data['accounts'] = $this->config->get('team_msn_chat_accounts');
        }

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();


        $this->template = 'module/team_msn_chat.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/team_msn_chat')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        $i = 0;

        if (!empty($this->request->post)) {
            
            if (
                empty ($this->request->post['team_msn_chat_module'])
                &&
                !empty ($this->request->post['team_msn_chat_accounts'])
                ){
                
                $this->error['warning'] = $this->language->get('error_module');
     
                
            }
           
            foreach ($this->request->post['team_msn_chat_accounts'] as $account_id =>  &$account) {
 
                $account['html'] = str_replace('&amp;', '&', $account['html']);
                
                if (preg_match('/([a-zA-Z0-9]+?\@apps\.messenger\.live\.com)\&mkt\=[a-zA-Z]{1,8}?\-[a-zA-Z]{1,8}/m', $account['html'], $regs)) {
                    $account['html'] = $regs[0];
                } else {
        
                    $account['error']['html'] = $this->language->get('error_html');
                    $this->error['warning'] = $this->language->get('error_html');
                }
                
                if (!$account['name']){
                    
                    $account['error']['name'] = $this->language->get('error_name');
                    $this->error['warning'] =   $this->language->get('error_name');
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>