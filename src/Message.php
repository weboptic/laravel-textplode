<?php

namespace Weboptic\Textplode;

class Message
{
	protected $mergeData = [];
	protected $message;
	protected $from;

	public function send(): Response
    {
		$data = [
			'recipients' => json_encode($this->mergeData),
			'message'	 => $this->message,
			'from'		 =>	$this->from,
		];

		return Request::make('messages/send', $data);
	}

	public function addRecipient($phone_number, $merge_data = []): self
    {
		$this->mergeData[] = ['phone_number' => $phone_number, 'merge' => $merge_data];
		return $this;
	}

	public function message($message): self
    {
		$this->message = $message;
		return $this;
	}

	public function from($from): self
    {
		$this->from = $from;
		return $this;
	}
}
