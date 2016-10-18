<?php

namespace Maleficarum\Handler;

class ExceptionHandler extends \Maleficarum\Handler\AbstractHandler
{
    /**
     * Handle exception
     *
     * @param \Exception|\Throwable $exception
     */
    public function handle($exception) {
        if (!$exception instanceof \Exception && $exception instanceof \Throwable) {
            throw new \InvalidArgumentException('Invalid exception parameter provided. \Maleficarum\Handler\ExceptionHandler::handle()');
        }

        $type = preg_replace('/Exception$/', '', get_class($exception));
        $type = explode('\\', $type);
        $type = array_pop($type);
        $type = 'Maleficarum\Handler\Exception\\' . $type;

        if (class_exists($type, true)) {
            $handler = \Maleficarum\Ioc\Container::get($type);
        } else {
            //no type specific handling available, use the default handler
            $handler = \Maleficarum\Ioc\Container::get('Maleficarum\Handler\Exception\Generic');
        }

        $handler->handle($exception, self::$debugLevel);
    }
}
