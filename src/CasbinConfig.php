<?php

namespace Cblink\HyperfCasbin;

use Hyperf\Contract\ConfigInterface;

class CasbinConfig
{
    const CONFIG_TYPE_FILE = 1;
    const CONFIG_TYPE_TEXT = 2;

    public $type;

    public $content;

    public $adapterTableName;

    public $adapterClass;

    public function __construct($type, $content, $adapterClass, $adapterTableName = 'casbin_rule')
    {
        $this->type = $type;
        $this->content = $content;
        $this->adapterClass = $adapterClass;
        $this->adapterTableName = $adapterTableName;
    }
}
