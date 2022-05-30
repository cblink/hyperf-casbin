<?php

namespace Cblink\HyperfCasbin;

use Casbin\Enforcer as BaseEnforcer;
use Casbin\Model\Model;
use Psr\Container\ContainerInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * Enforcer
 * @method bool enforce(...$rvals)
 * @method array getRolesForUser(string $name, string ...$domain)
 * @method array getUsersForRole(string $name, string ...$domain)
 * @method bool hasRoleForUser(string $name, string $role, string ...$domain)
 * @method bool addRoleForUser(string $user, string $role, string ...$domain)
 * @method bool deleteRoleForUser(string $user, string $role, string ...$domain)
 * @method bool deleteRolesForUser(string $user, string ...$domain)
 * @method bool deleteUser(string $user)
 * @method bool deleteRole(string $role)
 * @method bool deletePermission(string ...$permission)
 * @method bool addPermissionForUser(string $user, string ...$permission)
 * @method bool deletePermissionForUser(string $user, string ...$permission)
 * @method bool deletePermissionsForUser(string $user)
 * @method array getPermissionsForUser(string $user)
 * @method bool hasPermissionForUser(string $user, string ...$permission)
 * @method array getImplicitRolesForUser(string $name, string ...$domain)
 * @method array getImplicitPermissionsForUser(string $user, string ...$domain)
 * @method array getImplicitUsersForPermission(string ...$permission)
 * @method array getUsersForRoleInDomain(string $name, string $domain)
 * @method array getRolesForUserInDomain(string $name, string $domain)
 * @method array getPermissionsForUserInDomain(string $name, string $domain)
 * @method bool addRoleForUserInDomain(string $user, string $role, string $domain)
 * @method bool deleteRoleForUserInDomain(string $user, string $role, string $domain)
 */
class Enforcer
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __call($method, $parameters)
    {
        return $this->container->get(BaseEnforcer::class)->{$method}(...$parameters);
    }

    /**
     * @param \Cblink\HyperfCasbin\CasbinConfig|null $casbinConfig
     *
     * @return \Casbin\Enforcer
     * @throws \Casbin\Exceptions\CasbinException
     */
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

        self::$enforcer = new BaseEnforcer($model, $adapter);

        return self;
    }
}
