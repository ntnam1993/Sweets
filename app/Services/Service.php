<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Promise\RejectedPromise;
use Monolog\Formatter\LineFormatter;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

abstract class Service
{
    protected $client;
    protected $response;
    protected $exception;
    protected $start;

    public function __construct()
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push($this->guzzleLog());
        $config = array_merge(['base_uri' => $this->uri()],
            $this->options(),
            ['timeout' => config('common.API_TIMEOUT')],
            ['curl'    => [CURLOPT_NOSIGNAL => true]],
            ['handler' => $stack]);
        
        $this->client = app(Client::class, $config);
    }

    abstract public function uri();

    public function options()
    {
        return [];
    }

    public function getBody($type = 'object')
    {
        return $this->parse($this->response, $type);
    }

    public function parse($response, $type = 'object')
    {
        if ($response->getStatusCode() == 200) {
            if ('object' == $type) {
                return json_decode($response->getBody()->getContents());
            }
            return $response->getBody()->getContents();
        }
        return null;
    }

    public function getBodyAsync($type = 'object')
    {
        if ($this->response instanceof Promise) {
            $this->response = $this->response->wait();
        }
        return $this->getBody($type);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getException()
    {
        return $this->exception;
    }
    
    public function guzzleLog() {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $startTime = microtime(true);
                $startTimeFormat = formatTimeWithMiliSecond($startTime);
                $url = $request->getUri()->getScheme() . '://';
                $url .= $request->getUri()->getHost();
                $url .= $request->getUri()->getPath();
                $url .= '?' . $request->getUri()->getQuery();
                
                return $handler($request, $options, $startTime, $url)->then(
                    function (Response $response) use ($request, $startTime, $startTimeFormat, $url) {
                        $endTime = microtime(true);
                        $timeTaken = ($endTime - $startTime) > 0 ? number_format($endTime - $startTime, 3, '.', '') : 0;
                        $log = "$url\t".
                            "$startTimeFormat\t" .
                            "$timeTaken\t".
                            $request->getUri()->getPath();
                        
                        $apiLog = new Logger('call_api');
                        $handle = new StreamHandler(storage_path('logs/call_api.log'), Logger::INFO);
                        $formatter = new LineFormatter(null, null, false, true);
                        $handle->setFormatter($formatter);
                        $apiLog->pushHandler($handle);
                        if ($timeTaken >= config('common.API_TIME_WARNING')) {
                            $log .= "\t API response time exceeded";
                            $apiLog->warn($log);
                        }else{
                            $apiLog->info($log);
                        }

                        return $response;
                    },
                    function (TransferException $e) use ($startTime, $startTimeFormat, $url, $request) {
                        $message = '';
                        $logLevel = Logger::ERROR;
                        $logLevelCode = 400;
                        if (strpos($e->getMessage(), 'cURL error 7') !== false) {
                            $message = 'Connection refused';
                        }elseif (strpos($e->getMessage(), 'cURL error 28') !== false) {
                            $message = 'Connection timed out after 10000 milliseconds';
                            $logLevel = Logger::CRITICAL;
                            $logLevelCode = 300;
                        }

                        $endTime = microtime(true);
                        $timeTaken = ($endTime - $startTime) > 0 ? number_format($endTime - $startTime, 3, '.', '') : 0;
                        $log = "$url\t".
                            "$startTimeFormat\t" .
                            "$timeTaken\t".
                            $request->getUri()->getPath()."\t".
                            $message;
    
                        $apiLog = new Logger('call_api');
                        $handle = new StreamHandler(storage_path('logs/call_api.log'), $logLevel);
                        $formatter = new LineFormatter(null, null, false, true);
                        $handle->setFormatter($formatter);
                        $apiLog->pushHandler($handle);
                        $apiLog->log($logLevelCode,$log);
                        
                        return new RejectedPromise($e);
                    }
                );
            };
        };
    }
}
