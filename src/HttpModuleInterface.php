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
	 * You should return a StackPHP middleware.
	 *
	 * @param $app HttpKernelInterface The kernel your middleware will be wrapping.
	 * @return HttpKernelInterface
	 */
	public function getHttpMiddleware(HttpKernelInterface $app);
}
