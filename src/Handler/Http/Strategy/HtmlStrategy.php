<?php
/**
 * This class provides functionality of rendering HTML response for PHP exceptions
 */

namespace Maleficarum\Handler\Http\Strategy;

class HtmlStrategy extends \Maleficarum\Handler\Http\Strategy\AbstractStrategy
{
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
        $reasonPhrase = $this->getReasonPhrase($throwable);
        $message = $this->getMessage($throwable, $debugLevel);
        $details = $this->getExceptionDetails($throwable, $debugLevel);

        try {
            $this
                ->getResponse()
                ->setStatusCode($statusCode)
                ->render('exceptions/generic', [
                    'statusCode' => $statusCode,
                    'reasonPhrase' => $reasonPhrase,
                    'message' => $message,
                    'details' => $details
                ])
                ->output();
        } catch (\Throwable $thr) {
            $errorPage = $this->getErrorPage($statusCode, $reasonPhrase, $message, $details);

            $this->attachHeaders($statusCode, $reasonPhrase, 'text/html');
            $this->renderGeneric($errorPage);
            $this->terminate();
        }
    }

    /**
     * Render HTML response
     *
     * @param string $errorPage
     *
     * @return void
     */
    protected function renderGeneric(string $errorPage = '') {
        echo $errorPage;
    }

    /**
     * Get exception details
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return array
     */
    protected function getExceptionDetails(\Throwable $throwable, int $debugLevel) : array {
        $details = parent::getExceptionDetails($throwable, $debugLevel);

        if (isset($details['trace'])) {
            $details['trace'] = $throwable->getTraceAsString();
        }

        return $details;
    }
    /* ------------------------------------ AbstractStrategy methods END ------------------------------- */

    /* ------------------------------------ HtmlStrategy methods START --------------------------------- */
    /**
     * Get error page
     *
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param string $message
     * @param array $details
     *
     * @return string
     */
    private function getErrorPage(int $statusCode, string $reasonPhrase, string $message, array $details) : string {
        $body = $this->getBody($message, $details);

        return '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>' . sprintf('%d %s', $statusCode, $reasonPhrase) . '</title>
    </head>
    <body>
        ' . $body . '
    </body>
</html>';
    }

    /**
     * Get error page body
     *
     * @param string $message
     * @param array $details
     *
     * @return string
     */
    private function getBody(string $message, array $details) : string {
        $html = '<h2>Error: ' . $message . '</h2>';

        if (isset($details['file'], $details['line'], $details['trace'])) {
            $html .= '<p>File: ' . $details['file'] . ':' . $details['line'] . '</p>';
            $html .= '<h3>Trace:</h3>';
            $html .= '<p>' . $details['trace'] . '</p>';
        }

        return $html;
    }
    /* ------------------------------------ HtmlStrategy methods END ----------------------------------- */
}
