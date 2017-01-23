<?php
/**
 * This class is a base for all exceptions handlers
 */

namespace Maleficarum\Handler\Exception;

abstract class AbstractHandler
{
    /**
     * Use \Maleficarum\Response\Dependant functionality.
     *
     * @trait
     */
    use \Maleficarum\Response\Dependant;

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * Handle exception
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(\Throwable $exception, int $debugLevel) {
        if (!is_int($debugLevel)) {
            throw new \InvalidArgumentException(sprintf('Incorrect debug level - integer expected. \%s::handle()', static::class));
        }

        if ($this->getResponse() instanceof \Maleficarum\Response\Response) {
            // set response status code
            $responseStatusCode = $this->getResponseStatusCode();
            $this->getResponse()->setStatusCode($responseStatusCode);
        }

        // handle response
        $this->handleResponse($exception, $debugLevel);
    }

    /**
     * Render data
     *
     * @param array $data
     * @param array $meta
     *
     * @return void
     */
    protected function render(array $data, array $meta) {
        if ($this->getResponse() instanceof \Maleficarum\Response\Response) {
            if ($this->getResponse()->getHandler() instanceof \Maleficarum\Response\Handler\JsonHandler) {
                $response = $this->getResponse()->render($data, $meta, false);
            }

            if ($this->getResponse()->getHandler() instanceof \Maleficarum\Response\Handler\TemplateHandler) {
                $data = array_merge($data, $meta, ['code' => $this->getResponseStatusCode()]);
                $response = $this->getResponse()->render($data, [], false, 'exceptions/generic');
            }

            if (isset($response)) {
                $response->output();
                exit;
            }
        }

        if (empty($response)) {
            $this->renderGeneric($data, $meta);
        }

        exit;
    }

    /**
     * Render exception data as JSON
     * 
     * @param array $data
     * @param array $meta
     * 
     * @return void
     */
    protected function renderGeneric(array $data, array $meta) {
        header('HTTP/1.1 ' . $this->getDefaultMessage());
        header('Content-type: application/json');

        echo json_encode([
            'meta' => $meta,
            'data' => $data
        ]);
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */

    /* ------------------------------------ Abstract methods START ------------------------------------- */
    /**
     * Handle response
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     */
    abstract protected function handleResponse(\Throwable $exception, int $debugLevel);

    /**
     * Get response status code
     *
     * @return int
     */
    abstract protected function getResponseStatusCode() : int;

    /**
     * Get default message
     *
     * @return string
     */
    abstract protected function getDefaultMessage() : string;
    /* ------------------------------------ Abstract methods END --------------------------------------- */
}
