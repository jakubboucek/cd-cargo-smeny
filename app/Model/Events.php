<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Day;
use App\Entity\DayEvent;
use App\Entity\SingleEvent;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Http\Discovery\Psr18Client;
use IteratorAggregate;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Nette\Utils\Json;
use Traversable;

class Events implements IteratorAggregate
{
    private const URL = 'https://script.google.com/macros/s/AKfycbwVNN2SV4BGwvKiV2ZHSzAvKFIEAlodFQ9uvp70l2-ujHnXZuLPXrGWdt9RhD10T4pk/exec';
    private const CACHE_TTL = '20 minutes';

    private Cache $cache;

    public function __construct()
    {
        $this->cache = new Cache(new FileStorage(__DIR__ . '/../../temp'), __CLASS__);
    }

    public function getDaysEvents(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): iterable
    {
        $data = $this->getSourceData($from, $to);

        $tz = new DateTimeZone($data['timezone']);

        $events = [];
        foreach ($data['events'] as $eventData) {
            $event = SingleEvent::fromArray($eventData, $tz);
            $events[$event->getId()] = $event;
        }

        $days = [];
        foreach ($data['days'] as $date => $dayData) {
            $date = new DateTimeImmutable($date, $tz);

            $dayEvents = [];
            foreach ($dayData as $eventData) {
                $dayEvents[] = new DayEvent(
                    $events[$eventData['id']],
                    $eventData['start'],
                    $eventData['end']
                );
            }

            $days[] = new Day($date, $dayEvents);
        }

        return $days;
    }

    public function getIterator(): Traversable
    {
        yield from $this->getDaysEvents();
    }

    public function getSourceData(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        return $this->cache->load(['events', $from, $to], function (&$params) use ($from, $to) {
            $params[Cache::Expire] = self::CACHE_TTL;
            return $this->loadSourceData($from, $to);
        });
    }

    private function loadSourceData(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $client = new Psr18Client();

        $request = $client->createRequest('GET', self::URL);
        $request->withUri(
            $request->getUri()->withQuery(
                http_build_query([
                    'from' => $from ? $from->format('Y-m-d') : null,
                    'to' => $to ? $to->format('Y-m-d') : null,
                ])
            )
        );
        $response = $client->sendRequest($request);
        $json = (string)$response->getBody();
        $data = Json::decode($json, Json::FORCE_ARRAY);

        if (!$data['status']) {
            throw new ServerException((string)$data['error']);
        }

        return $data['payload'];
    }
}
