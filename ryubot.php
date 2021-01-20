<?php
/**
* RyuBots Script //
* 
* @copyright 2021
* @version 1.0-2021
*  
*
**/

@session_start();
@ob_start();

Class RyuBot{

	private $config;
	private $ip;
	private $ua;
	public function __construct()
	{


		/**
		* SETTING HERE
		* @var $this->config
		* --------------------------------------------/ 
		* | This is configuration for your API Client
		* | You can enable config with  "true"  and 
		* | Also   can disable config with "false"
		* ----------------------------------------/
		*/
		$this->config['log_bot'] = true;
		$this->config['log_visitor'] = true;
		$this->config['one_time_access'] = true;
		$this->config['bot']['ip'] = true; // IP Address bot
		$this->config['bot']['ua'] = true; // UserAgent bot


		/**
		* SETTING HERE
		* @var $this->config
		* --------------------------------------------/ 
		* | This is configuration for your API Client
		* | You can edit your URLs here for redirect 
		* | More desc will be present in each config
		* ----------------------------------------/
		*/
		
		/** This is work if not detect bot or not detect country listed ( Direct By Country ) **/
		$this->config['direct']['default'] = 'https://google.com';
		
		/** This is work if you enable one_time_access set to true **/
		$this->config['direct']['onetime'] = 'https://facebook.com';

		/** This is work if bot detected **/
		$this->config['direct']['bot'] = 'https://twitter.com';

		/** This is work if detect visitor from country listed here **/

		// This is example code  direct by country single URL.
		$this->config['direct']['by_country']['ID'] = 'https://google.co.id';
		$this->config['direct']['by_country']['US'] = 'https://google.us';

		// This is example code direct by country MASS URLs and access by random.
		$this->config['direct']['by_country']['CA'][0] = 'https://w3schools.com';
		
		$this->config['direct']['by_country']['CA'][1] = 'https://php.net';

		$this->config['direct']['by_country']['CA'][2] = 'https://7inc.store';

		
		/** CONFIGURATION END **/
		/** DON'T CHANGE ANYTHING START FROM HERE **/
		/** if error is not our responsibility **/
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->ua = $_SERVER['HTTP_USER_AGENT'];
	}

	public function get($method,$param = [])
	{
		

		$setup = [CURLOPT_URL => 'http://7inc.store/xapi/?api='.$method.'&'.http_build_query($param),
				 CURLOPT_RETURNTRANSFER=>true,
				 CURLOPT_USERAGENT=>'RyuBots',
				 CURLOPT_SSL_VERIFYPEER=>false
				];
		$c = curl_init();
		curl_setopt_array($c,$setup);
		$exe = curl_exec($c);
		return json_decode($exe,true);
		curl_close($c);
	}
	public function getCountry()
	{
		$get =$this->get('country',['ip' => $this->ip ]);
		return $get['countryCode'];
	}
	public function is_bot($code)
	{
		$get = $this->get('bot',['ip' => $this->ip , 'ua' => $this->ua]);

		if($get['is_bot'] == true )
		{

			if($get['type_bot'] == 'agent' && $this->config['bot']['ua'] == true){

			if($this->config['log_bot'] == true)
			{
				file_put_contents('ryu-bot.log','BOT USERAGENT DETECTED => '.$this->ip .'|'.$this->ua."\n",FILE_APPEND);
			}
			@header('location: '.$this->config['direct']['bot'],true,303);
			exit;

			}

			if($get['type_bot'] == 'ip' && $this->config['bot']['ip'] == true){

			if($this->config['log_bot'] == true)
			{
				file_put_contents('ryu-bot.log','BOT IP DETECTED => '.$this->ip .'|'.$this->ua."\n",FILE_APPEND);
			}
			@header('location: '.$this->config['direct']['bot'],true,303);
			exit;

			}

		}else{
			if($this->config['log_visitor'] == true)
			{
				file_put_contents('ryu-visitor.log','VISITOR => '.$code.'|'.$this->ip .'|'.$this->ua."\n",FILE_APPEND);
			}
		}
	}
	public function randomUri($array)
	{
		$size = count($array);
    $randomIndex = rand(0, $size - 1);
    $randomUrl = $target[$randomIndex];
    return $randomUrl;
	}
	public function one_time()
	{
		$file = 'onetime.log';
		if(!file_exists($file))
		{
			file_put_contents($file,$this->ip."\n",FILE_APPEND);
		}else{
	
			$gt = explode("\n",file_get_contents($file));

			if(in_array($this->ip,$gt))
			{
				@header('location: '.$this->config['direct']['onetime'],true,303);exit;
			}else{
				file_put_contents($file,$this->ip."\n",FILE_APPEND);
			}
		}
	}
	public function run()
	{

		$code = $this->getCountry();

		$this->is_bot($code);

		if($this->config['one_time_access'] == true)
		{
			$this->one_time();
		}

		if(array_key_exists($code, $this->config['direct']['by_country']))
		{

			/** checking if using mass random direct **/
			if(is_array($this->config['direct']['by_country'][$code]))
			{
				@header('location: '.$this->randomUri($this->config['direct']['by_country'][$code]),true,303);
				exit;
			}else
			{
				@header('location: '.$this->config['direct']['by_country'][$code],true,303);
				exit;
			}
		}
		else{
			@header('location: '.$this->config['direct']['default'],true,303);
			exit;
		}
	}
}

$RYU = new RyuBot;
$RYU->run();
