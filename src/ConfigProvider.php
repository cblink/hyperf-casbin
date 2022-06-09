<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Cblink\HyperfCasbin;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Enforcer::class => EnforcerFactory::class,
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'casbin_table',
                    'description' => 'add casbin table migration', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/2022_03_01_070115_create_casbin_rule_table.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/migrations/2022_03_01_070115_create_casbin_rule_table.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'casbin_config',
                    'description' => 'add casbin config', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/casbin.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/casbin.php', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'casbin_rbac_model_conf',
                    'description' => 'add casbin rbac model config', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/rbac-model.conf',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/casbin-model/rbac-model.conf', // 复制为这个路径下的该文件
                ],
                [
                    'id' => 'casbin_rbac_with_domains_model_conf',
                    'description' => 'add casbin rbac with domains model config', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/rbac-with-domains-model.conf',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/casbin-model/rbac-with-domains-model.conf', // 复制为这个路径下的该文件
                ],
            ],
        ];
    }
}
