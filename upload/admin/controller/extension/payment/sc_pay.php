<?php
class ControllerExtensionPaymentSCPAY extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/sc_pay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sc_pay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_sale'] = $this->language->get('text_sale');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_button_link'] = $this->language->get('entry_button_link');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_transaction'] = $this->language->get('entry_transaction');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$data['entry_denied_status'] = $this->language->get('entry_denied_status');
		$data['entry_expired_status'] = $this->language->get('entry_expired_status');
		$data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$data['entry_processed_status'] = $this->language->get('entry_processed_status');
		$data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$data['entry_reversed_status'] = $this->language->get('entry_reversed_status');
		$data['entry_voided_status'] = $this->language->get('entry_voided_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_test'] = $this->language->get('help_test');
		$data['help_debug'] = $this->language->get('help_debug');
		$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_order_status'] = $this->language->get('tab_order_status');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['button_link'])) {
			$data['error_button_link'] = $this->error['button_link'];
		} else {
			$data['error_button_link'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/sc_pay', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/sc_pay', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['sc_pay_email'])) {
			$data['sc_pay_email'] = $this->request->post['sc_pay_email'];
		} else {
			$data['sc_pay_email'] = $this->config->get('sc_pay_email');
		}

		if (isset($this->request->post['sc_pay_button_link'])) {
			$data['sc_pay_button_link'] = $this->request->post['sc_pay_button_link'];
		} else {
			$data['sc_pay_button_link'] = $this->config->get('sc_pay_button_link');
		}

		if (isset($this->request->post['sc_pay_test'])) {
			$data['sc_pay_test'] = $this->request->post['sc_pay_test'];
		} else {
			$data['sc_pay_test'] = $this->config->get('sc_pay_test');
		}

		if (isset($this->request->post['sc_pay_transaction'])) {
			$data['sc_pay_transaction'] = $this->request->post['sc_pay_transaction'];
		} else {
			$data['sc_pay_transaction'] = $this->config->get('sc_pay_transaction');
		}

		if (isset($this->request->post['sc_pay_debug'])) {
			$data['sc_pay_debug'] = $this->request->post['sc_pay_debug'];
		} else {
			$data['sc_pay_debug'] = $this->config->get('sc_pay_debug');
		}

		if (isset($this->request->post['sc_pay_total'])) {
			$data['sc_pay_total'] = $this->request->post['sc_pay_total'];
		} else {
			$data['sc_pay_total'] = $this->config->get('sc_pay_total');
		}

		if (isset($this->request->post['sc_pay_canceled_reversal_status_id'])) {
			$data['sc_pay_canceled_reversal_status_id'] = $this->request->post['sc_pay_canceled_reversal_status_id'];
		} else {
			$data['sc_pay_canceled_reversal_status_id'] = $this->config->get('sc_pay_canceled_reversal_status_id');
		}

		if (isset($this->request->post['sc_pay_completed_status_id'])) {
			$data['sc_pay_completed_status_id'] = $this->request->post['sc_pay_completed_status_id'];
		} else {
			$data['sc_pay_completed_status_id'] = $this->config->get('sc_pay_completed_status_id');
		}

		if (isset($this->request->post['sc_pay_denied_status_id'])) {
			$data['sc_pay_denied_status_id'] = $this->request->post['sc_pay_denied_status_id'];
		} else {
			$data['sc_pay_denied_status_id'] = $this->config->get('sc_pay_denied_status_id');
		}

		if (isset($this->request->post['sc_pay_expired_status_id'])) {
			$data['sc_pay_expired_status_id'] = $this->request->post['sc_pay_expired_status_id'];
		} else {
			$data['sc_pay_expired_status_id'] = $this->config->get('sc_pay_expired_status_id');
		}

		if (isset($this->request->post['sc_pay_failed_status_id'])) {
			$data['sc_pay_failed_status_id'] = $this->request->post['sc_pay_failed_status_id'];
		} else {
			$data['sc_pay_failed_status_id'] = $this->config->get('sc_pay_failed_status_id');
		}

		if (isset($this->request->post['sc_pay_pending_status_id'])) {
			$data['sc_pay_pending_status_id'] = $this->request->post['sc_pay_pending_status_id'];
		} else {
			$data['sc_pay_pending_status_id'] = $this->config->get('sc_pay_pending_status_id');
		}

		if (isset($this->request->post['sc_pay_processed_status_id'])) {
			$data['sc_pay_processed_status_id'] = $this->request->post['sc_pay_processed_status_id'];
		} else {
			$data['sc_pay_processed_status_id'] = $this->config->get('sc_pay_processed_status_id');
		}

		if (isset($this->request->post['sc_pay_refunded_status_id'])) {
			$data['sc_pay_refunded_status_id'] = $this->request->post['sc_pay_refunded_status_id'];
		} else {
			$data['sc_pay_refunded_status_id'] = $this->config->get('sc_pay_refunded_status_id');
		}

		if (isset($this->request->post['sc_pay_reversed_status_id'])) {
			$data['sc_pay_reversed_status_id'] = $this->request->post['sc_pay_reversed_status_id'];
		} else {
			$data['sc_pay_reversed_status_id'] = $this->config->get('sc_pay_reversed_status_id');
		}

		if (isset($this->request->post['sc_pay_voided_status_id'])) {
			$data['sc_pay_voided_status_id'] = $this->request->post['sc_pay_voided_status_id'];
		} else {
			$data['sc_pay_voided_status_id'] = $this->config->get('sc_pay_voided_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['sc_pay_geo_zone_id'])) {
			$data['sc_pay_geo_zone_id'] = $this->request->post['sc_pay_geo_zone_id'];
		} else {
			$data['sc_pay_geo_zone_id'] = $this->config->get('sc_pay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['sc_pay_status'])) {
			$data['sc_pay_status'] = $this->request->post['sc_pay_status'];
		} else {
			$data['sc_pay_status'] = $this->config->get('sc_pay_status');
		}

		if (isset($this->request->post['sc_pay_sort_order'])) {
			$data['sc_pay_sort_order'] = $this->request->post['sc_pay_sort_order'];
		} else {
			$data['sc_pay_sort_order'] = $this->config->get('sc_pay_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/sc_pay', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/sc_pay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['sc_pay_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}


		if (!$this->request->post['sc_pay_button_link']) {
			$this->error['button_link'] = $this->language->get('error_button_link');
		}

		return !$this->error;
	}
}