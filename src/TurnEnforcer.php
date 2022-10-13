<?php

namespace Cblink\HyperfCasbin;

use Casbin\Enforcer as BaseEnforcer;

class TurnEnforcer
{

    protected $model;

    protected $adapter;

    protected $enforcer;

    /**
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct($model, $adapter)
    {
        $this->model = $model;
        $this->adapter = $adapter;
        $this->enforcer = new BaseEnforcer($this->model, $this->adapter);
    }

    public function __call($method, $parameters)
    {
        $this->enforcer->loadPolicy();

        return $this->enforcer->{$method}(...$parameters);
    }
}
