<?php

namespace Cblink\HyperfCasbin;

use Casbin\Enforcer as BaseEnforcer;
use Casbin\Model\Model;
use InvalidArgumentException;
use phpDocumentor\Reflection\Types\Self_;

class EnforcerFactory
{
    public static $enforcers;

    public function make(CasbinConfig $casbinConfig = null)
    {
        if (empty($casbinConfig)) {
            $config = config('casbin');
            if (is_null($config)) {
                throw new InvalidArgumentException("Enforcer config is not defined.");
            }

            $casbinConfig = new CasbinConfig(
                $config['model']['config_type'],
                $config['model']['config_content'],
                $config['adapter']['class']
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

        $adapter = make($casbinConfig->adapterClass, ['tableName' => $casbinConfig->adapterTableName]);

        if (empty(self::$enforcers[$casbinConfig->key])) {
            self::$enforcers[$casbinConfig->key] = new BaseEnforcer($model, $adapter);
        }

        return self::$enforcers[$casbinConfig->key];
    }
}
