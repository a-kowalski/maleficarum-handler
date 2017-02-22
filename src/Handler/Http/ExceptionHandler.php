<?php
/**
 * This class provides functionality of handling PHP exceptions
 */

namespace Maleficarum\Handler\Http;

class ExceptionHandler extends \Maleficarum\Handler\AbstractHandler
{
    /**
     * Internal storage for strategy
     *
     * @var \Maleficarum\Handler\Http\Strategy\AbstractStrategy
     */
    private $strategy;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * AbstractHandler constructor.
     *
     * @param \Maleficarum\Handler\Http\Strategy\AbstractStrategy $strategy
     */
    public function __construct(\Maleficarum\Handler\Http\Strategy\AbstractStrategy $strategy) {
        $this->strategy = $strategy;
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * Handle exception
     *
     * @param \Throwable $throwable
     *
     * @return void
     */
    public function handle(\Throwable $throwable) {
        if (!$throwable instanceof \Maleficarum\Exception\HttpException) {
            $this->log(\LOG_EMERG, '[PHP] GENERIC EXCEPTION HANDLER :: MSG: ' . $throwable->getMessage() . ' :: FILE: ' . $throwable->getFile() . ' :: LINE: ' . $throwable->getLine());
        }

        $this->strategy->render($throwable, self::$debugLevel);
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */
}
