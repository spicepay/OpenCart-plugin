<?php

class ControllerPaymentSpicepay extends Controller {
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        
		$this->data['spicepay_login'] = $this->config->get('spicepay_login');
	    $this->data['spicepay_key']= $this->config->get('spicepay_key');

		// Номер заказа
		$this->data['inv_id'] = $this->session->data['order_id'];


		
$this->data['action']="https://www.spicepay.com/pay.php";


		
		$this->data['merchant_url'] = $this->data['action'] . '?siteId=' . $this->data['spicepay_login'] .
				'&amountUSD='			. $order_info['total'] .
				'&orderId='			. $this->data['inv_id']	.
				'&language=en';

	

		$this->id = 'payment';

		$this->model_checkout_order->confirm($this->session->data['order_id'], 1);
        // $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('spicepay_status'));
        $this->cart->clear();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/spicepay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/spicepay.tpl';
		} else {
			$this->template = 'default/template/payment/spicepay.tpl';
		}

		$this->render();
	}





	public function callback() {
	
        
        
	if (isset($_POST['paymentId']) && isset($_POST['orderId']) && isset($_POST['hash']) 
&& isset($_POST['paymentAmountBTC']) && isset($_POST['paymentAmountUSD']) 
&& isset($_POST['receivedAmountBTC']) && isset($_POST['receivedAmountUSD'])) {
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($_POST['orderId']);
        
        $paymentId = $_POST['paymentId'];
    $orderId = $_POST['orderId'];
    $hash = $_POST['hash'];    
    $clientId = $_POST['clientId'];
    $paymentAmountBTC = $_POST['paymentAmountBTC'];
    $paymentAmountUSD = $_POST['paymentAmountUSD'];
    $receivedAmountBTC = $_POST['receivedAmountBTC'];
    $receivedAmountUSD = $_POST['receivedAmountUSD'];
    $status = $_POST['status'];
    $secretCode = $this->session->data['secret_key'];


        
        if (strcmp($_SERVER['REMOTE_ADDR'], '217.23.11.119') == 0 || strcmp($_SERVER['REMOTE_ADDR'], '51.254.46.119') == 0) {           
        if (0 == strcmp(md5($secretCode . $paymentId . $orderId . $clientId . $paymentAmountBTC . $paymentAmountUSD . $receivedAmountBTC . $receivedAmountUSD . $status), $hash)) {
            
        
       $sum = (float)$order_info['total']; 
       $sum = round($sum,2);
      if ($sum != $receivedAmountUSD) {
                echo  'не совпадает сумма заказа';
      } else {
            //$order->payment_complete();
          $this->model_checkout_order->confirm($orderId, 5, 'SpicePay');
          echo 'OK';
      
      }
            
        }
        }
        
        
    } elseif (isset($_GET['paymentId']) && isset($_GET['orderId']) && isset($_GET['hash']) 
&& isset($_GET['paymentAmountBTC']) && isset($_GET['paymentAmountUSD']) 
&& isset($_GET['receivedAmountBTC']) && isset($_GET['receivedAmountUSD'])) {
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($_GET['orderId']);
        
        $paymentId = $_GET['paymentId'];
    $orderId = $_GET['orderId'];
    $hash = $_GET['hash'];    
    $clientId = $_GET['clientId'];
    $paymentAmountBTC = $_GET['paymentAmountBTC'];
    $paymentAmountUSD = $_GET['paymentAmountUSD'];
    $receivedAmountBTC = $_GET['receivedAmountBTC'];
    $receivedAmountUSD = $_GET['receivedAmountUSD'];
    $status = $_GET['status'];
    $secretCode = $this->session->data['secret_key'];


        
        if (strcmp($_SERVER['REMOTE_ADDR'], '217.23.11.119') == 0 || strcmp($_SERVER['REMOTE_ADDR'], '51.254.46.119') == 0) {
        if (0 == strcmp(md5($secretCode . $paymentId . $orderId . $clientId . $paymentAmountBTC . $paymentAmountUSD . $receivedAmountBTC . $receivedAmountUSD . $status), $hash)) {
            
        
       $sum = (float)$order_info['total']; 
       $sum = round($sum,2);
      if ($sum != $receivedAmountUSD) {
                echo  'не совпадает сумма заказа';
      } else {
            //$order->payment_complete();
          $this->model_checkout_order->confirm($orderId, 5, 'SpicePay');
          echo 'OK';
      
      }
            
        }
        }
        
        
    } else {
        echo 'fail';
        $this->load->model('checkout/order');
    }

	}

   
}
?>