<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Consumer;

use App\Exception\WrongAMQPMessageException;
use App\Resource\AMQPMessageResource;
use App\Service\ContactServiceInterface;
use App\Transformers\AMQPMessageResourceToContactDTOTransformer;
use App\Transformers\AMQPMessageToAMQPResourceTransformer;
use Doctrine\ORM\ORMException;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

/**
 * Trys to add new contact.
 *
 * Class AddContactConsumer
 */
class AddContactConsumer implements ConsumerInterface
{
    /**
     * @var ContactServiceInterface
     */
    private $contactService;
    /**
     * @var ProducerInterface
     */
    private $retryProducer;

    /**
     * @var int
     */
    private $maxRetrys = 2;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ContactServiceInterface $contactService,
        ProducerInterface $retryProducer,
        LoggerInterface $logger
    ) {
        $this->retryProducer = $retryProducer;
        $this->contactService = $contactService;
        $this->logger = $logger;

        gc_enable();
    }

    /**
     * Try to add new contact row.
     *
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        try {
            $message = (new AMQPMessageToAMQPResourceTransformer($msg))->transform();

            $contact = $this->contactService->create(
                (new AMQPMessageResourceToContactDTOTransformer($message))
                    ->transform()
            );

            $this->logger->info(
                \sprintf("AddContactConsumer Added: %s \r\n %s %s",
                    $contact->getId(),
                    $contact->getFirstName(),
                    $contact->getLastName()
                )
            );
        } catch (WrongAMQPMessageException $exception) {
            $this->logger->error(
                \sprintf("AddContactConsumer WrongAMQPMessageException: %s \r\n %s \r\n Body: %s",
                    $exception->getMessage(),
                    $exception->getTraceAsString(),
                    $msg->getBody()
                )
            );
        } catch (ORMException $exception) {
            $this->retry($message);
        } catch (\Exception $exception) {
            $this->logger->error(
                \sprintf("AddContactConsumer Error: %s \r\n %s \r\n Message Body: %s",
                    $exception->getMessage(),
                    $exception->getTraceAsString(),
                    $msg->getBody()
                )
            );
        }

        $this->contactService->forceCloseDBConnection();

        gc_collect_cycles();

    }

    /**
     * Retry add new contact row.
     *
     * @param AMQPMessageResource $message
     */
    public function retry(AMQPMessageResource $message)
    {
        if ($message->getTrys() >= $this->maxRetrys) {
            $this->logger->error(
                \sprintf("AddContactConsumer trys limit exceeded : %s \r\n %s",
                    "Limit exceeded ({$message->getTrys()}): {$message->getName()}",
                    \json_encode($message)
                )
            );
        } else {
            $message->setTrys(
                $message->getTrys() + 1
            );

            $this->retryProducer->publish(\json_encode($message));

            $this->logger->notice(
                \sprintf("AddContactConsumer Retry(%d): %s \r\n %s",
                    $message->getTrys(),
                    $message->getName(),
                    $message->getDescription()
                )
            );
        }
    }
}
