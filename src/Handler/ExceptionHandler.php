<?php
/**
 * This class provides functionality of handling PHP exceptions
 */

namespace Maleficarum\Handler;

class ExceptionHandler extends \Maleficarum\Handler\AbstractHandler
{
    /**
     * Handle exception
     *
     * @param \Throwable $throwable
     * 
     * @return void
     */
    public function handle(\Throwable $throwable) {
        $type = preg_replace('/Exception$/', '', get_class($throwable));
        $type = explode('\\', $type);
        $type = array_pop($type);
        $type = 'Maleficarum\Handler\Exception\\' . $type;

        if (class_exists($type, true)) {
            $handler = \Maleficarum\Ioc\Container::get($type);
        } else {
            //no type specific handling available, use the default handler
            $handler = \Maleficarum\Ioc\Container::get('Maleficarum\Handler\Exception\Generic');
        }

        $handler->handle($throwable, self::$debugLevel);
    }
}
