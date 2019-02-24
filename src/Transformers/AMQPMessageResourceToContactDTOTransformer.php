<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\DTO\ContactDTO;
use App\Exceptions\WrongAMQPMessageException;
use App\Resource\AMQPMessageResource;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Transform AMQPMessage to ContactDTO.
 *
 * Class AMQPMessageToContactDTOTransformer
 */
class AMQPMessageResourceToContactDTOTransformer
{
    /**
     * @var AMQPMessageResource
     */
    private $AMQPMessage;

    public function __construct(AMQPMessageResource $AMQPMessage)
    {
        $this->AMQPMessage = $AMQPMessage;
    }

    public function transform(): ContactDTO
    {
        try {
            $data = $this->AMQPMessage->getData();

            return (new ContactDTO())
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setPhoneNumbers($data['phoneNumbers']);
        } catch (\Exception $exception) {
            throw new WrongAMQPMessageException($exception->getMessage());
        }
    }
}
