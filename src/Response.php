<?php

namespace Weboptic\Textplode;

class Response
{
	public $data;

	public static function make($responseBody, $data): self
    {
		return new self(json_decode($responseBody, true), $data);
	}

	public function __construct($data, $params)
    {
		unset($params['api_key']);

		if(isset($data['data']['error'])){
			unset($data['data']['error']);
		}

		if(is_array($data['data'])){
			if(count($data['data']) == 1){
				$this->data = reset($data['data']);
			}else{
				$this->data = array_values($data['data']);
			}
		}else{
			$this->data = $data['data'];
		}
	}
}
