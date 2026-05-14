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

    public function connect(string $host, int $port, int $deviceId): void
    {
        $this->webService->post($this->getRequest($host, $port, 'connect', ['device' => $deviceId]));
    }

    public function stop(string $host, int $port, int $deviceId): void
    {
        $this->webService->post($this->getRequest($host, $port, 'stop', ['device' => $deviceId]));
    }

    public function control(string $host, int $port, int $deviceId, int $channel, float $power): void
    {
        $this->webService->post($this->getRequest(
            $host,
            $port,
            'control',
            [
                'device' => $deviceId,
                'channel' => $channel,
                'power' => $power,
            ],
        ));
    }

    public function btStop(string $host, int $port): void
    {
        $this->webService->post($this->getRequest($host, $port, 'btstop'));
    }

    private function getRequest(string $host, int $port, string $endpoint, ?array $body = null)
    {
        $request = new Request(sprintf('%s/api/%s', $host, $endpoint))
            ->setPort($port)
            ->setHeaders(['Content-Type' => 'application/json'])
        ;

        if ($body !== null) {
            $jsonBody = JsonUtility::encode($body);
            $request->setBody(new Body()->setContent($jsonBody, strlen($jsonBody)));
        }

        return $request;
    }
}
