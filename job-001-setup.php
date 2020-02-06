<?php 

class setup {

	function Proc($source, $staging, $target,$aws_resource) {
		WriteLog($source->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($staging->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($target->getAttribute(PDO::ATTR_CONNECTION_STATUS));

		$source->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$staging->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$target->setAttribute(PDO::ATTR_AUTOCOMMIT,0);

		WriteLog('Done with setup');

	}
}
