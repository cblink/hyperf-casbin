<?php

return [
    /*
     * Casbin model setting.
     */
    'model' => [
        'config_type' => \Cblink\HyperfCasbin\CasbinConfig::CONFIG_TYPE_FILE,
        'config_content' => BASE_PATH . '/config/autoload/casbin-model/rbac-model.conf',
    ],
    /*
     * Casbin adapter .
     */
    'adapter' => [
        'class' => \Cblink\HyperfCasbin\Adapters\Mysql\DatabaseAdapter::class,
    ],
    'log' => [
        'enabled' => false,
    ]
];
