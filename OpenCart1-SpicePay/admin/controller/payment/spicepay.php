<?php
class ControllerPaymentSpicepay extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('payment/spicepay');

		$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('spicepay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_liqpay'] = $this->language->get('text_liqpay');
		$this->data['text_card'] = $this->language->get('text_card');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
         		
		
		$this->data['entry_login'] = $this->language->get('entry_login');
		$this->data['entry_password1'] = $this->language->get('entry_password1');
		

		// URL
		$this->data['copy_result_url'] 	= HTTP_CATALOG . 'index.php?route=payment/spicepay/callback';
		$this->data['copy_success_url']	= HTTP_CATALOG . 'index.php?route=payment/spicepay/success';
		$this->data['copy_fail_url'] 	= HTTP_CATALOG . 'index.php?route=payment/spicepay/fail';

		



		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		//
	
if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		//
		if (isset($this->error['login'])) {
			$this->data['error_login'] = $this->error['login'];
		} else {
			$this->data['error_login'] = '';
		}

		if (isset($this->error['password1'])) {
			$this->data['error_password1'] = $this->error['password1'];
		} else {
			$this->data['error_password1'] = '';
		}


		
$this->data['action'] = $this->url->link('payment/spicepay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/spicepay', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);



         	
		
		//
		if (isset($this->request->post['spicepay_login'])) {
			$this->data['spicepay_login'] = $this->request->post['spicepay_login'];
		} else {
			$this->data['spicepay_login'] = $this->config->get('spicepay_login');
		}


		//
		if (isset($this->request->post['spicepay_key'])) {
			$this->data['spicepay_key'] = $this->request->post['spicepay_key'];
		} else {
			$this->data['spicepay_key'] = $this->config->get('spicepay_key');
		}

		
		if (isset($this->request->post['spicepay_order_status_id'])) {
			$this->data['spicepay_order_status_id'] = $this->request->post['spicepay_order_status_id'];
		} else {
			$this->data['spicepay_order_status_id'] = $this->config->get('spicepay_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['spicepay_geo_zone_id'])) {
			$this->data['spicepay_geo_zone_id'] = $this->request->post['spicepay_geo_zone_id'];
		} else {
			$this->data['spicepay_geo_zone_id'] = $this->config->get('spicepay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['spicepay_status'])) {
			$this->data['spicepay_status'] = $this->request->post['spicepay_status'];
		} else {
			$this->data['spicepay_status'] = $this->config->get('spicepay_status');
		}

		if (isset($this->request->post['spicepay_sort_order'])) {
			$this->data['spicepay_sort_order'] = $this->request->post['spicepay_sort_order'];
		} else {
			$this->data['spicepay_sort_order'] = $this->config->get('spicepay_sort_order');
		}

		$this->template = 'payment/spicepay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/spicepay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['spicepay_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['spicepay_key']) {
			$this->error['password1'] = $this->language->get('error_password1');
		}

	
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>