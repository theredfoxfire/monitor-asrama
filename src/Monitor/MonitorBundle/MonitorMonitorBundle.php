<?php

namespace Monitor\MonitorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonitorMonitorBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
