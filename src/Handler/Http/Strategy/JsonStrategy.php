<?php
/**
 * This class provides functionality of rendering JSON response for PHP exceptions
 */
declare(strict_types=1);

namespace Maleficarum\Handler\Http\Strategy;

class JsonStrategy extends \Maleficarum\Handler\Http\Strategy\AbstractStrategy {
    /* ------------------------------------ AbstractStrategy methods START ----------------------------- */
    /**
     * Render JSON through response object or plain PHP otherwise
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return void
     */
    public function render(\Throwable $throwable, int $debugLevel) {
        $statusCode = $this->getStatusCode($throwable);
        $meta = $this->getMeta($throwable, $debugLevel);
        $data = $this->getData($throwable);

        try {
            $this
                ->getResponse()
                ->setStatusCode($statusCode)
                ->render($data, $meta, false)
                ->output();
        } catch (\Throwable $thr) {
            $reasonPhrase = $this->getReasonPhrase($throwable);

            $this->attachHeaders($statusCode, $reasonPhrase, 'application/json');
            $this->renderGeneric($meta, $data);
            $this->terminate();
        }
    }

    /**
     * Render JSON response
     *
     * @param array $meta
     * @param array $data
     *
     * @return void
     */
    protected function renderGeneric(array $meta = [], array $data = []) {
        echo json_encode([
            'meta' => $meta,
            'data' => $data,
        ]);
    }
    /* ------------------------------------ AbstractStrategy methods END ------------------------------- */

    /* ------------------------------------ JsonStrategy methods START --------------------------------- */
    /**
     * Get response meta
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return array
     */
    private function getMeta(\Throwable $throwable, int $debugLevel): array {
        $meta = [
            'status' => 'failure',
            'msg' => $this->getMessage($throwable, $debugLevel),
        ];

        $exceptionDetails = $this->getExceptionDetails($throwable, $debugLevel);
        $meta = array_merge($meta, $exceptionDetails);

        return $meta;
    }

    /**
     * Get response data
     *
     * @param \Throwable $throwable
     *
     * @return array
     */
    private function getData(\Throwable $throwable): array {
        $errors = $this->getErrors($throwable);

        return empty($errors) ? [] : ['errors' => $errors];
    }
    /* ------------------------------------ JsonStrategy methods END ----------------------------------- */
}
