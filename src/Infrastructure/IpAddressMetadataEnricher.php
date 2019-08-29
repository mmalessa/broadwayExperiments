<?php

namespace App\Infrastructure;

use Broadway\Domain\Metadata;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class IpAddressMetadataEnricher implements MetadataEnricher
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function enrich(Metadata $metadata): Metadata
    {
        return $metadata->merge(
            Metadata::kv(
                'ip_address',
                $this->getClientIp()
            )
        );
    }

    private function getClientIp(): string
    {
        $currentRequest = $this->requestStack->getCurrentRequest();

        return $currentRequest instanceof Request ? $currentRequest->getClientIp() : '';
    }
}
