<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\Exceptions\WrongAMQPMessageException;
use App\Resource\AMQPMessageResource;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Transform AMQPMessage to AMQPMessageResource.
 *
 * Class AMQPMessageToArrayTransformer
 */
class AMQPMessageToAMQPResourceTransformer
{
    /**
     * @var AMQPMessage
     */
    private $AMQPMessage;

    public function __construct(AMQPMessage $AMQPMessage)
    {
        $this->AMQPMessage = $AMQPMessage;
    }

    public function transform(): AMQPMessageResource
    {
        try {
            $message = \json_decode($this->AMQPMessage->getBody(), true);

            return (new AMQPMessageResource())
                ->setName($message['name'])
                ->setDescription($message['description'])
                ->setTrys($message['trys'])
                ->setData($message['data']);

        } catch (\Exception $exception) {
            throw new WrongAMQPMessageException($exception);
        }
    }
}
