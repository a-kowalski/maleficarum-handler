<?php
/**
 * This class is a base for all handler classes
 */
declare(strict_types=1);

namespace Maleficarum\Handler;

abstract class AbstractHandler {
    /**
     * Definitions of available debug levels.
     */
    const DEBUG_LEVEL_FULL = 10;
    const DEBUG_LEVEL_LIMITED = 5;
    const DEBUG_LEVEL_CRUCIAL = 0;

    /**
     * Internal storage for the handler debug level. (by default set to crucial)
     *
     * @var int
     */
    protected static $debugLevel = self::DEBUG_LEVEL_CRUCIAL;

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * Log message
     *
     * @param int $priority
     * @param string $message
     */
    protected function log(int $priority, string $message) {
        syslog($priority, $message);
    }

    /**
     * Terminate execution
     */
    protected function terminate() {
        exit;
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Set debug level for all handlers in the application (both error and exception)
     *
     * @param int $level
     *
     * @return void
     */
    public static function setDebugLevel(int $level) {
        self::$debugLevel = $level;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
