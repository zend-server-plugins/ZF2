<?php

class ZF2Plugin extends ZAppsPlugin {
	
	public function resolveMVCEnter($context) {
	}
	
	public function resolveMVCLeave($context) {
		if (!$this->resolved) {
			$routeMatch = $context['functionArgs'][0];
			if ($routeMatch) {
				$params = $routeMatch->getParams();
				if ($params) {
					$this->resolved = true;
					$mvc = array();
					if (isset($params['module'])) {
						$mvc['module'] = $params['module'];
					}
					if (isset($params['controller'])) {
						$mvc['controller'] = $params['controller'];
					}
					if (isset($params['action'])) {
						$mvc['action'] = $params['action'];
					}
					
					$this->setRequestMVC($mvc);
				}
			}
		}
	}		
	
	private $resolved = false;
}

$zf2Plugin = new ZF2Plugin();
$zf2Plugin->setWatchedFunction("Zend\Mvc\MvcEvent::setRouteMatch", array($zf2Plugin, "resolveMVCEnter"), array($zf2Plugin, "resolveMVCLeave"));