HttpModuleInterface
===================

This package contains the base interface to build framework-agnostic **modules**
that provides a [PSR-7 middleware](http://stackphp.com).

##Framework-agnostic modules?

Have a look at [the demo](http://github.com/framework-interop/framework-interop-demo).
It shows 3 modules, one using Symfony 2, one using Silex and one using Zend Framework 1.

## How it works

Framework agnostic modules should implement the [`ModuleInterface`](http://github.com/framework-interop/module-interface).

If your module provides a router, or should catch incoming HTTP requests,
you should implement the `HttpModuleInterface`. It is a special kind of
module that allows you to provide a PSR-7 middleware. The middleware can
catch incoming requests and react accordingly.

## PSR-7 middleware?

PSR-7 does not directly specify middlewares, it's only a PSR about request and response objects. However, 
middlewares have been built on top of PSR-7. The most common one is the middleware used by *zend/stratigility* and 
the one you should use to work with the `HttpModuleInterface`. 

## How to write an HTTP module

You start by writing a class that implements `Interop\Framework\HttpModuleInterface`:

```php
namespace Acme\BlogModule;

class Slim3Module extends ModuleInterface
{
    private $rootContainer;

    public function getName()
    {
        return 'slim3Router';
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
            "slimApp" => function() { return new Slim\Slim(); }
        ], $rootContainer);
    }

		/**
		 * You can do things on init.
		 */
		public function init() {
		    // Do stuff.
		}

    public function getHttpMiddleware(HttpKernelInterface $app) {
		    return new TODO CHANGE REFERENCE TO SLIM SilexMiddleware($app, $this->rootContainer->get('silexApp'));
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
