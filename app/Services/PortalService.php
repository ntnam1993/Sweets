<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;

class PortalService extends Service
{
    const EXCEPTION_API = true;

    protected $portalDomain;
    protected $redirectUri;

    public function __construct()
    {
        parent::__construct();

        $this->portalDomain = env('EPARK_PORTAL_DOMAIN');
        $this->redirectUri = env('EPARK_REDIRECT_URI');
    }

    public function uri()
    {
        return env('EPARK_PORTAL_MEMBER');
    }

    public function memberRefer($query)
    {
        $query = array_merge([
            'portal_domain' => $this->portalDomain,
            'redirect_uri' => $this->redirectUri
        ], $query);
        $this->response = $this->client->request('GET', 'portalMemberRefer', compact('query'));
        return $this;
    }

    public function memberUpdate($query)
    {
        try {
            $query = array_merge([
                'portal_domain' => $this->portalDomain
            ], $query);
            $this->response = $this->client->request('GET', 'portalMemberUpdate', compact('query'));
            return $this;
        } catch (RequestException $e) {
            $statusCode = '';
            if ($e->hasResponse() && isset($e->getResponse()->statusCode)) {
                $statusCode = $e->getResponse()->statusCode;
            }
            Log::error($statusCode.' '.$e->getMessage());

            return [
                'status' => self::EXCEPTION_API
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => self::EXCEPTION_API
            ];
        }
    }

    public function sweetsMemberRefer($query)
    {
        try {
            $query = array_merge([
                'portal_domain' => $this->portalDomain
            ], $query);

            $this->response = $this->client->request('GET', 'sweetsMemberRefer', compact('query'));
            return $this;
        } catch (RequestException $e) {
            $statusCode = '';
            if ($e->hasResponse() && isset($e->getResponse()->statusCode)) {
                $statusCode = $e->getResponse()->statusCode;
            }
            Log::error($statusCode.' '.$e->getMessage());

            return [
                'status' => self::EXCEPTION_API,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => self::EXCEPTION_API
            ];
        }
    }
}
