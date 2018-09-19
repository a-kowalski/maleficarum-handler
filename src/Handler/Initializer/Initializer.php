<?php
/**
 * This class carries ioc initialization functionality used by this component.
 */
declare (strict_types=1);

namespace Maleficarum\Handler\Initializer;

class Initializer {
    /* ------------------------------------ Class Methods START ---------------------------------------- */

    /**
     * This method will initialize the entire package.
     *
     * @param array $opts
     *
     * @return string
     */
    static public function initialize(array $opts = []): string {
        // load default builder if skip not requested
        $builders = $opts['builders'] ?? [];
        is_array($builders) or $builders = [];
        if (!isset($builders['exception_handler']['skip'])) {
            \Maleficarum\Ioc\Container::registerBuilder('Maleficarum\Handler\Http\Strategy', function ($shares, $opts) {
                $class = $opts['__class'];

                /** @var \Maleficarum\Handler\Http\Strategy\AbstractStrategy $strategy */
                $strategy = new $class();
                if (isset($shares['Maleficarum\Response'])) {
                    $strategy->setResponse($shares['Maleficarum\Response']);
                }

                return $strategy;
            });
        }

        // return initializer name
        return __METHOD__;
    }

    /* ------------------------------------ Class Methods END ------------------------------------------ */
}
