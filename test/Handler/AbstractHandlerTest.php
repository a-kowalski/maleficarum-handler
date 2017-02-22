<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\AbstractHandler class.
 */

namespace Maleficarum\Handler\Tests;

class AbstractHandlerTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: Setup START ---------------------------------------- */
    protected function setUp() {
        parent::setUp();

        $property = new \ReflectionProperty('Maleficarum\Handler\AbstractHandler', 'debugLevel');
        $property->setAccessible(true);
        $property->setValue(0);
        $property->setAccessible(false);
    }
    /* ------------------------------------ Method: Setup END ------------------------------------------ */

    /* ------------------------------------ Method: setDebugLevel START -------------------------------- */
    public function testSetDebugLevel() {
        \Maleficarum\Handler\AbstractHandler::setDebugLevel(15);

        $property = new \ReflectionProperty('Maleficarum\Handler\AbstractHandler', 'debugLevel');
        $property->setAccessible(true);
        $this->assertSame(15,$property->getValue());
        $property->setAccessible(false);
    }
    /* ------------------------------------ Method: setDebugLevel END ---------------------------------- */
}
