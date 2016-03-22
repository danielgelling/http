<?php

namespace Http;

class Factory
{
	public static function get($url, $params = [], $returnPlain = false)
	{
		$curl = curl_init();

		foreach($params as $param => $value)
		{
			if(is_array($value))
				$value = implode(',', $value);

			$url .= '&' . $param . '=' . $value;
		}

		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
		]);

		if($returnPlain)
			return curl_exec($curl);

		$response = new \stdClass();
		$response->response = json_decode(curl_exec($curl));
		$response->request_info = curl_getinfo($curl);

		curl_close($curl);

		return json_decode(json_encode($response));
	}

	public static function post($url, $params = [], $returnPlain = false)
	{
		$curl = curl_init();

		$params = json_encode($params);

		curl_setopt_array($curl, [
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => $params,
		    CURLOPT_HTTPHEADER => [
		    	'Content-Type: application/json',
		    	'Content-Length: ' . strlen($params)
		    ]
		]);

		if($returnPlain)
			return curl_exec($curl);

		$response = new \stdClass();
		$response->response = json_decode(curl_exec($curl));
		$response->request_info = curl_getinfo($curl);

		curl_close($curl);

		return json_decode(json_encode($response));
	}

	public static function postRaw($url, $body, $auth, $returnPlain = false)
	{
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_USERPWD => $auth,
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => $body,
		    CURLOPT_HTTPHEADER => [
		    	'Content-Type: application/json',
		    	'Accept: application/json; charset=UTF-8',
		    	'Authorization: Basic bmVvNGo6MQ=='
		    ]
		]);

		if($returnPlain)
			return curl_exec($curl);

		$response = new \stdClass();
		$response->response = json_decode(curl_exec($curl));
		$response->request_info = curl_getinfo($curl);

		curl_close($curl);

		return json_decode(json_encode($response));
	}
}
