<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Client;

use GibsonOS\Core\Dto\Web\Body;
use GibsonOS\Core\Dto\Web\Request;
use GibsonOS\Core\Service\WebService;
use GibsonOS\Core\Utility\JsonUtility;

class MouldKingClient
{
    public function __construct(private readonly WebService $webService)
    {
    }

    public function connect(string $host, int $deviceId): void
    {
        $this->webService->post($this->getRequest($host, 'connect', ['device' => $deviceId]));
    }

    public function stop(string $host, int $deviceId): void
    {
        $this->webService->post($this->getRequest($host, 'stop', ['device' => $deviceId]));
    }

    public function control(string $host, int $deviceId, int $channel, float $power): void
    {
        $this->webService->post($this->getRequest(
            $host,
            'control',
            [
                'device' => $deviceId,
                'channel' => $channel,
                'power' => $power,
            ],
        ));
    }

    public function btStop(string $host): void
    {
        $this->webService->post($this->getRequest($host, 'btstop'));
    }

    private function getRequest(string $host, string $endpoint, ?array $body = null)
    {
        $request = new Request(sprintf('%s/api/%s', $host, $endpoint));

        if ($body !== null) {
            $jsonBody = JsonUtility::encode($body);
            $request->setBody(new Body()->setContent($jsonBody, strlen($jsonBody)));
        }

        return $request;
    }
}
