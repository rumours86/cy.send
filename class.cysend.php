<?php

class CySend {
    public $lang = 'ru';
    public $sms_notification = 'yes';
    public $reseller_client_mobile = '+79000000000';
    public $params = array('username' => 'username');
    public function get_balance() {
        $this->params['function'] = __FUNCTION__;
        return $this->execute();
    }
    public function get_countries() {
        $this->params['function'] = __FUNCTION__;
        $this->params['lang'] = $this->lang;
        return $this->execute();
    }
    public function get_operators($countries) {
        $this->params['function'] = __FUNCTION__;
        $this->params['countries'] = $countries;
        $this->params['lang'] = $this->lang;
        return $this->execute();
    }
    public function get_values($operators) {
        $this->params['function'] = __FUNCTION__;
        $this->params['operators'] = $operators;
        return $this->execute();
    }
    public function check_mobile($mobile) {
        $this->params['function'] = __FUNCTION__;
        $this->params['mobile'] = $mobile;
        $this->params['lang'] = $this->lang;
        return $this->execute();
    }
    public function top_up($mobile, $value, $tid) {
        $this->params['function'] = __FUNCTION__;
        $this->params['mobile'] = $mobile;
        $this->params['value'] = $value;
        $this->params['tid'] = $tid;
        $this->params['sms_notification'] = $this->sms_notification;
        $this->params['reseller_client_mobile'] = $this->reseller_client_mobile;
        return $this->execute();
    }
    public function transaction_status($tid, $cysend_tid) {
        $this->params['function'] = __FUNCTION__;
        $this->params['tid'] = $tid;
        $this->params['cysend_tid'] = $cysend_tid;
        return $this->execute();
    }

    public function execute() {
        $this->params['hash'] = md5(implode('|', $this->params).'|password');
        foreach($this->params as $key => $par)
            if(empty($par)) return 'Незадан параметр ' . $key;

        $ch = curl_init("https://www.cysend.com:274/cy_send_api_3wX5u5nRLchj.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        $getResult = curl_exec($ch);
        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return "Error contacting CY.SEND API.<br />".
            print_r(curl_getinfo($ch), true)."<br />".
            "Error number: ".curl_errno($ch)."<br />".
            "Error: ".curl_error($ch)."<br />";
        } else {
            return $getResult;
        }
    }
}