<?php
namespace Interop\Framework;

use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 *  This interface as a base building-block to build framework-agnostic modules that provide
 *  a HTTP middleware (see http://stackphp.com/ for more information about middlewares)
 */
interface HttpModuleInterface extends ModuleInterface
{
	/**
	 * You should return a PSR-7 middleware (in the formats understood by zend/stratigility,
	 * i.e. a callable or an object implementing the MiddlewareInterface).
	 *
	 * @return MiddlewareInterface|callable
	 */
	public function getHttpMiddleware();
}
