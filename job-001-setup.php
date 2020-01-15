<?php 

class setup {

	function Proc($source, $staging, $target) {
		WriteLog($source->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($staging->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($target->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog('Done with setup');
	}
}
