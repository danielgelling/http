<?php

namespace Http;

class Factory
{
	public static function get($url, $params = [])
	{
		$curl = curl_init();

		foreach($params as $param => $value)
		{
			if(is_array($value))
				$value = implode(',', $value);

			$url .= '&' . $param . '=' . $value;
		}

		curl_setopt_array($curl, array[
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
		]);

		$response = new \stdClass();
		$response->response = json_decode(curl_exec($curl));
		$response->request_info = curl_getinfo($curl);

		curl_close($curl);

		return json_decode(json_encode($response));
	}

	public static function post($url, $params = [])
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

		$response = new \stdClass();
		$response->response = json_decode(curl_exec($curl));
		$response->request_info = curl_getinfo($curl);

		curl_close($curl);

		return json_decode(json_encode($response));
	}
}
