<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Slack {

    var $WebhookURL = 'https://hooks.slack.com/services/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';
	
    function SendMessage($Message) {
      $this->CI =& get_instance();
      $message = array('payload' => json_encode(array('channel' => $this->CI->config->item('depot.slack.channel'), 'username' => $this->CI->config->item('depot.slack.botname'), 'text' => $Message)));
      $c = curl_init($this->CI->config->item('depot.slack.webhookurl'));
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_POST, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, $message);
      if ($this->CI->config->item('depot.slack.aktiv')) {
        curl_exec($c);
        curl_close($c);
      }
    }
    
  }
/* End of file Slack.php */
/* Location: ./system/application/libraries/Slack.php */
