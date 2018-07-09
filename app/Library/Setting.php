<?php

/*
 * This file is configuration setting invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class Setting {
	public static function loadconfig() {
		return [
			// Debug mode. -
			'debugmode' => true,
			'ssh' => [
				// You SSH user.
				'sshuser' => '',
				// You SSH password.
				'sshpass' => '',
			],
			'project' => [
				// Name, name you project.
				'name' => 'Invasma Core System',
				// Project Site, you site url (set '' if in localhost).
				'site' => '',
			],
			// Logo.
			'logo'	=> [
				'icon' => 'favicon.ico',
				'normal' => [
					'png' => 'logo.png',
				],
				'small' => [
					'png' => 'logo.png', // 110px x 40px.
				],
				'big' => [
					'png' => 'logo.png', // 250px x 86px.
				]
			],
			'backend' => [
				// Page, if you can move CMS to backend and you can use 'aliaspage' => 'YOU_LOCATION_PATH_ALIAS/'.
				'aliaspage' => 'admin/',
				// Limit Page, display record perpage.
		    	'limitpage' => 25,
		    	// Lang, set LANGUAGE. -
				'lang' => [
					['link' => 'en', 'alias' => 'EN', 'flag' => 'us.png', 'name' => 'English'],
					['link' => 'id', 'alias' => 'ID', 'flag' => 'id.png', 'name' => 'Indonesia'],
				],
			],
			'frontend' => [
				// Type, Select type frontend (1 for manual login, 2 for automatically).
		    	'type' => 1,
				// Limit Page, display record perpage.
		    	'limitpage' => 25,
		    	// Auto Lock set 1000 for 1 second. Set false for non active -
				'lang' => [
					['link' => 'en', 'alias' => 'EN', 'flag' => 'eng.png', 'name' => 'ENGLISH'],
					['link' => 'id', 'alias' => 'ID', 'flag' => 'ind.png', 'name' => 'INDONESIA'],
				],
			],
			// Time Zone set in\\ server.e Zone set in\\ server.
			'timezone' => 'Asia/Jakarta',
			'email' => [
				// 'protocol' => 'smtp',
				// 'smtp_host' => 'smtp_host',
				// 'smtp_port' => 'smtp_port',
				// 'smtp_name' => 'smtp_name',
				// 'smtp_user' => 'smtp_user',
				// 'smtp_pass' => 'smtp_pass',
				// 'mailtype' => 'html',
				// 'charset' => 'iso-8859-1',
				// 'wordwrap' => TRUE
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://srv12.niagahoster.com',
				'smtp_port' => 465,
				'smtp_name' => 'Auto System Invasma',
				'smtp_user' => 'no-reply@invasma.com',
				'smtp_pass' => 'no-reply!1nv45m4123!',
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			],
			'sellermenu' => [183,177,185,164,92,207,90,91,94,179,96,97,98,99,101,100],
			'JNETest' => false,
		];
	}
}