<?php

namespace Tests\Traits;

trait AgentTrait
{

    public $isMobile = false;

    public $agentSpec;

    protected function registerAgentSpecification($agentString)
    {
        $this->app['agent']->setUserAgent($agentString);
    }

    public function setDesktopAgent()
    {
        $this->isMobile = false;
        $this->agentSpec = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36';
        $this->registerAgentSpecification($this->agentSpec);
        return $this;
    }

    public function setMobileAgent()
    {
        $this->isMobile = true;
        $this->agentSpec = 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1';
        $this->registerAgentSpecification($this->agentSpec);
        return $this;
    }

    public function pipe($callback)
    {
        if (!empty($callback)) {
            $callback();
        }
        return $this;
    }
}
