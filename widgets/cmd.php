<?php
abstract class cmdWidget
{
	protected $command=""; #set this to the command you want to run, or...
	protected $file; #set this to the name of the file you want to read (eg. from /proc)
	protected $regex='/(.*)/'; #set this. This is the regular expression to extract the text out of the command output. By default
	protected $result;
	protected $result_formatted;
	protected $max; #set this if you want a bar graph. Otherwise leave it alone.
	protected $icon; #set this if you want an icon. Otherwise leave it alone.
	function __construct ($options) { #override this!
		
	}
	public function value() {
		if(!isset($this->result)) {
			if($this->file) {
				$this->mapResults(cmdWidget::get($this->file, $this->regex));
			}
			else {
				$this->mapResults(cmdWidget::run($this->command, $this->regex));
			}
		}
		return $this->result;
	}
	protected function mapResults($results) { #override this to set what matches go to what properties. Is called from value(). You can use this to get max values, status, etc.
		$this->result=$results[1];
		$this->result_formatted=$this->format($results[1]);
	}
	static protected function format($in) {
		return $in;
	}
	static protected function get($file, $regex) {
		if(is_readable("$file")) {
			return cmdWidget::extract(explode("\n", file_get_contents($file)), $regex);
		}
		else {
			return cmdWidget::run("cat $file", $regex);
		}
	}
	static protected function run($command, $regex) {
		exec($command, $lines);
		return cmdWidget::extract($lines, $regex);
	}
	static private function extract($lines, $regex) {
		$lines=implode($lines);
		$results=[];
		if(is_array($regex)) {
			foreach($regex as $r) {
				preg_match($r, $lines, $result);
				unset($result[0]);
				$results=array_merge($results, $result);
			}
		}
		else {
			preg_match($regex, $lines, $results);
		}
		return $results;
	}
	public function timeout() {
		return 10;
	}
	public function title() { #override this if you want something other than the command as your title.
		return preg_replace('/ .*$/', "", $this->command);
	}
	public function status() { #probably override this.
		return "normal";
	}
	public function html() {
		$this->value();
		$icon="";
		$class="";
		if(isset($this->icon)) {
			$icon=" data-icon='$this->icon'";
		}
		if(isset($this->class)) {
			$class=" class='$this->class'";
		}
		if(isset($this->max)) {
			$percent=round(min($this->result/$this->max*100, 100), 2);
			return "<div class='has-bar'$icon>\n\t<span$class>$this->result_formatted</span>\n</div>\n<span class='bargraph' style='width:$percent%'></span>";
		}
		else {
			return "<div$icon>\n\t<span$class>$this->result_formatted</span>\n</div>";
		}
	}
}
