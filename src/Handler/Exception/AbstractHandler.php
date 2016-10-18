<?php

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
     * @param \Exception|\Throwable $exception
     * @param int $debugLevel
     *
     * @return mixed
     */
    public function handle($exception, $debugLevel) {
        if (!is_int($debugLevel)) {
            throw new \InvalidArgumentException(sprintf('Incorrect debug level - integer expected. \%s::handle()', get_class($this)));
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
     * @param \Exception|\Throwable $exception
     * @param int $debugLevel
     *
     * @return mixed
     */
    abstract protected function handleResponse($exception, $debugLevel);

    /**
     * Get response status code
     * 
     * @return int
     */
    abstract protected function getResponseStatusCode();

    /**
     * Get default message
     * 
     * @return string
     */
    abstract protected function getDefaultMessage();
    /* ------------------------------------ Abstract methods END --------------------------------------- */
}
