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

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
		));


		$response = array_merge(
			json_decode(curl_exec($curl), true),
			curl_getinfo($curl)
		);

		curl_close($curl);

		return json_encode(json_decode($response));
	}

	public static function post($url, $params = [])
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => $params
		));

		$response = array_merge(
			json_decode(curl_exec($curl), true),
			curl_getinfo($curl)
		);

		curl_close($curl);

		return json_encode(json_decode($response));
	}
}
