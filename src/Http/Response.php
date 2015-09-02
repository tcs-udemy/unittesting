<?php
namespace Acme\Http;

use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use Acme\Http\Session;

/**
 * Class Response
 * @package Acme\Http
 */
class Response {

    protected $data;
    protected $view;
    protected $with;
    protected $response_type;
    protected $response_code;
    protected $flash;
    protected $signer;
    protected $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blade = new BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));
        $this->response_type = 'text/html';
        $this->signer = new SignatureGenerator(getenv('CSRF_SECRET'));
        $this->with['signer'] = $this->signer;
        $this->session = new Session();
    }


    /**
     * Render a page
     */
    public function render()
    {
        $this->with['_session'] = $this->session;
        $html = $this->blade->render($this->view, $this->with);
        $this->renderOutput($html);
    }


    /**
     *
     */
    public function json()
    {
        $this->response_type = 'application/json';
        return $this;
    }


    /**
     * @param $view
     * @return $this
     */
    public function withView($view)
    {
        $this->view = $view;
        return $this;
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function with($name, $value)
    {
        $this->with[$name] = $value;
        return $this;
    }


    /**
     * @param $code
     * @return $this
     */
    public function withResponseCode($code)
    {
        $this->response_code = $code;
        return $this;
    }


    /**
     * @param $message
     * @return $this
     */
    public function withError($message)
    {
        $this->session->put('_error', $message);
        return $this;
    }


    /**
     * @param $message
     * @return $this
     */
    public function withMessage($message)
    {
        $this->session->put('_message', $message);
        return $this;
    }


    public function redirectTo($target)
    {
        header("Location: " . $target);
    }


    /**
     * @param $payload
     */
    private function renderOutput($payload)
    {
        if ($this->response_code != null) {
            switch ($this->response_code) {
                case (404):
                    header("HTTP/1.0 404 Not Found");
                    break;
                default:
                    // nothing
            }
        }

        header('Content-Type: ' . $this->response_type);
        echo $payload;

        if ($this->session->has('_message'))
            $this->session->forget('_message');

        if ($this->session->has('_error'))
            $this->session->forget('_error');
    }

}
