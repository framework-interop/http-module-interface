HttpModuleInterface
===================

This package contains the base interface to build framework-agnostic **modules**
that provides a [StackPHP middleware](http://stackphp.com).

##Framework-agnostic modules?

Have a look at [the demo](http://github.com/framework-interop/framework-interop-demo).
It shows 3 modules, one using Symfony 2, one using Silex and one using Zend Framework 1.

## How it works

Framework agnostic modules should implement the [`ModuleInterface`](http://github.com/framework-interop/module-interface).

If your module provides a router, or should catch incoming HTTP requests,
you should implement the `HttpModuleInterface`. It is a special kind of
module that allows you to provide a StackPHP middleware. The middleware can
catch incoming requests and react accordingly.

## How to write an HTTP module

You start by writing a class that implements `Interop\Framework\HttpModuleInterface`:

```php
namespace Acme\BlogModule;

class SilexModule extends ModuleInterface
{
    private $rootContainer;

    public function getName()
    {
        return 'silexRouter';
    }

    /**
     * You can return a container if the module provides one.
     *
     * It will be chained to the application's root container.
     *
     * @return ContainerInterface|null
     */
    public function getContainer(ContainerInterface $rootContainer)
    {
        $rootContainer = $this->rootContainer;
        return new Picotainer([
            "silexApp" => function() { return new Silex\Application($rootContainer); }
        ], $rootContainer);
    }

		/**
		 * You can do things on init.
		 */
		public function init() {
		    // Do stuff.
		}

    public function getHttpMiddleware(HttpKernelInterface $app) {
		    return new SilexMiddleware($app, $this->rootContainer->get('silexApp'));
	  }
}
```

The `init` method is called **after** the `getContainer`.
Then the application is routing the HTTP message to the modules implementing `HttpModuleInterface`.

##Application? What application?

Obviously, you will need an application that register all modules and receives the
HTTP requests to pass them to the modules.

*framework-interop* provides a [default `Application`](http://github.com/framework-interop/application) class to bootstrap your project
but you can write your own!
