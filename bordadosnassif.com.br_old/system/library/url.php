<?php
class Url {
	private $url;
	private $ssl;
	private $rewrite = array();
	
	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}
		
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}
		
	public function link($route, $args = '', $connection = 'NONSSL') {
		if ($connection ==  'NONSSL') {
			$url = $this->url;	
		} else {
			$url = $this->ssl;	
		}
		
		$url .= 'index.php?route=' . $route;
			
		if ($args) {
			$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&')); 
		}
		
		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
				
		return $url;
	}

	public function getURLVar($urlVarName, $url) {
		if ($url == '') {
			$url = $this->url;
		}
		$url = explode("?",$url);
		$url = explode("&",$url[1]);
		foreach ($url as $urlHalve) {
			$urlHalve = explode("=",$urlHalve);
			if ($urlHalve[0] == $urlVarName){
				return $urlHalve[1];
			}
		}
		
		return '';
	}
}
?>