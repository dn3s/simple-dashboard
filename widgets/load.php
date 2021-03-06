<?php
class loadWidget
{
	private $load;
	private $normload;
	private $warn=50;
	private $critical=75;
	private $cpus=1;
	function __construct ($options) {
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
		if(isset($options->critical)) {
			$this->critical=$options->critical;
		}
		if(isset($options->cpus)) {
			$this->cpus=$options->cpus;
		}
	}
	public function value() {
		if($this->load===null) {
			$this->load=sys_getloadavg()[0];
			$this->normload=round($this->load/$this->cpus*100, 2);
		}
		return $this->load;
	}
	public function timeout() {
		return "10";
	}
	public function title() {
		return "load avg";
	}
	public function status() {
		$this->value();
		if($this->normload >= $this->critical) {
			return "critical";
		}
		else if($this->normload >= $this->warn) {
			return "warn";
		}
		else if(isset($this->normload)){
			return "good";
		}
		else {
			return "failed";
		}
	}
	public function html() {
		$this->value();
		return "<div class='has-bar' data-icon='&#9881'>\n\t<span>$this->load</span>\n</div>\n\t<span class='bargraph' style='width:$this->normload%'></span>";
	}
}
