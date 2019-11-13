<?php
namespace App\Common\Client;


class ClingmeCore
{
	public $url;
	public $method;
	public $post_data = [];

	public function __construct($config) {
		$this->url = isset($config['base_url'])?$config['base_url']:'';

		if(isset($config['username'])) $this->post_data['username'] = $config['username'];
		if(isset($config['password'])) $this->post_data['password'] = $config['password'];
	}

	public function sendRequest($method, $path, $data) {

		$service_url = $this->url.$path;

		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if(strtolower($method) == 'post') {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		$curl_response = curl_exec($curl);
		curl_close($curl);

		return $curl_response;
	}

	public function makePost($path, $data) {

		if(!empty($this->post_data)) {
			$data = array_merge($data, $this->post_data);
		}
		return $this->sendRequest('post', $path, $data);
	}

	public function makeGet($url, $data) {
		return $this->sendRequest('get', $url, $data);
	}

}