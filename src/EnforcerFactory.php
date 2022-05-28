<?php

namespace Cblink\HyperfCasbin;

use Casbin\Enforcer as BaseEnforcer;
use Casbin\Model\Model;
use InvalidArgumentException;

class EnforcerFactory
{
    public static function make(CasbinConfig $casbinConfig = null)
    {
        if (empty($casbinConfig)) {
            $config = config('casbin');
            if (is_null($config)) {
                throw new InvalidArgumentException("Enforcer config is not defined.");
            }

            $casbinConfig = new CasbinConfig(
                $config['model']['config_type'],
                $config['model']['config_content'],
                $config['adapter']['class'],
                $config['adapter']['constructor']
            );
        }

        $model = new Model();

        if (CasbinConfig::CONFIG_TYPE_FILE == $casbinConfig->type) {
            $model->loadModel($casbinConfig->content);
        } elseif (CasbinConfig::CONFIG_TYPE_TEXT == $casbinConfig->type) {
            $model->loadModelFromText($casbinConfig->content);
        }

        if (!$casbinConfig->adapterClass) {
            throw new InvalidArgumentException("Enforcer adapter is not defined.");
        }

        $adapter = make($casbinConfig->adapterClass, ['table_name' => $casbinConfig->adapterTableName]);
        return new BaseEnforcer($model, $adapter);
    }
}
