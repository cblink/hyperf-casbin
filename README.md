<h1 align="center"> hyperf-casbin </h1>

<p align="center"> .</p>


This library is casbin for hyperf. It allows you to easily use casbin in hyperf. Note that it must use Redis, so make sure your project has Redis.

Thanks for the reference provided by the project:
https://github.com/donjan-deng/hyperf-casbin


### Installation

```
composer require cblink/hyperf-casbin
```
## Usage

```
$enforcer = new Enforcer();

//add permission for user
$enforcer->addPermissionForUser('permission', 'user', 'obj', 'act');

//todo
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/cblink/hyperf-casbin/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/cblink/hyperf-casbin/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
