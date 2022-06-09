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

        switch ($casbinConfig->type) {
            case CasbinConfig::CONFIG_TYPE_FILE:
                $model->loadModel($casbinConfig->content);
                break;
            case CasbinConfig::CONFIG_TYPE_TEXT:
                $model->loadModelFromText($casbinConfig->content);
                break;
            case CasbinConfig::CONFIG_TYPE_CODE:
                $model->AddDef("r", "r", $casbinConfig->content['r']);
                $model->AddDef("p", "p", $casbinConfig->content['p']);
                $model->AddDef("g", "g", $casbinConfig->content['g']);
                $model->AddDef("e", "e", $casbinConfig->content['e']);
                $model->AddDef("m", "m", $casbinConfig->content['m']);
                break;
            default:;
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
