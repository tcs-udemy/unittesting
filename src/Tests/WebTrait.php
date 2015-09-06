<?php
namespace Acme\Tests;

/**
 * Class WebTrait
 * @package Acme\Tests
 */
trait WebTrait {

    /**
     * retern response code when crawling a given url
     * @param $url
     * @return mixed
     */
    function crawl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,
            true);
        curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $response_code;
    }

}
