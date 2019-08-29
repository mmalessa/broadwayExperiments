<?php

namespace App\Infrastructure;

use Broadway\Domain\Metadata;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;

class CurrentTimeMetadataEnricher implements MetadataEnricher
{
    public function enrich(Metadata $metadata): Metadata
    {
        return $metadata->merge(
            Metadata::kv(
                'current_time',
                Date('Y-m-d H:i:s')
            )
        );
    }

}
