<?php

namespace Pmc\EventSourceLib\Storage;


/**
 *
 * @author Gargoyle <g@rgoyle.com>
 */
interface StorageEngine
{
    public function storeSerializedEvent(array $data): void;
    public function getSerialisedStream(string $streamId): array;
    public function purgeStream(string $streamId): array;
}
