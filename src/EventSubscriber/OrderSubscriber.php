<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\NewOrder;
use Bitrix\Main\Mail\Event;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NewOrder::class => 'onNotifyAboutNewOrder'
        ];
    }

    /**
     * @throws Exception
     */
    public function onNotifyAboutNewOrder(NewOrder $orderMail): void
    {
        NewOrder::EVENT_CHANNEL_MAIL !== $orderMail->getType() || $this->sendMail(NewOrder::EVENT_NAME, $orderMail->getData());
    }

    /**
     * @throws Exception
     */
    private function sendMail(string $event, array $data): void
    {
        $result = Event::send([
            'EVENT_NAME' => $event,
            'LID' => 's1',
            'C_FIELDS' => $data,
        ]);

        if (!$result->isSuccess()) {
            throw new Exception('проблемы с письмом.');
        }
    }
}
