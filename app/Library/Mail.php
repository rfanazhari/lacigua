<?php

/*
 * This file is mail library support | invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class Mail extends \App\Library\GlobalFunctionsCall
{
	var $destination = 'emails.';
	
	public function _send($condition = array()) {
		return \Mail::send($this->destination.$condition['template'], $condition['data'], function($message) use ($condition) {
			if(isset($condition['to']) && $condition['to'])
				foreach ($condition['to'] as $email => $name)
					if($name) $message = $message->to($email, $name);
					else $message = $message->to($email);
			if(isset($condition['cc']) && $condition['cc'])
				foreach ($condition['cc'] as $email => $name)
					if($name) $message = $message->cc($email, $name);
					else $message = $message->cc($email);
			if(isset($condition['bcc']) && $condition['bcc'])
				foreach ($condition['bcc'] as $email => $name)
					if($name) $message = $message->bcc($email, $name);
					else $message = $message->bcc($email);
			$message->subject($condition['subject']);
		});
	}
}