<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\DTO\ContactDTO;
use App\Entity\Contact;
use App\Repository\ContactRepositoryInterface;
use App\Resource\AMQPMessageResource;
use App\Transformers\ContactDTOToArrayTransformer;
use App\Transformers\ContactDTOToContactTransformer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

/**
 * Contact Service.
 *
 * Class ContactService
 */
class ContactService implements ContactServiceInterface
{
    /**
     * @var ContactRepositoryInterface
     */
    private $repository;
    /**
     * @var ProducerInterface
     */
    private $producer;

    public function __construct(
        ContactRepositoryInterface $repository,
        ProducerInterface $producer
    ) {
        $this->repository = $repository;
        $this->producer = $producer;
    }

    public function save(Contact $contact): Contact
    {
        return $this->repository->save($contact);
    }

    public function create(ContactDTO $contactDTO): Contact
    {
        return $this->repository->save(
            (new ContactDTOToContactTransformer($contactDTO))
                ->transform()
        );
    }

    /**
     * Crate Contact.
     * Delay creation if db is busy.
     *
     * @param ContactDTO $contactDTO
     */
    public function lazyCreate(ContactDTO $contactDTO)
    {
        $this->producer->publish(\json_encode(
            (new AMQPMessageResource())
                ->setName('lasy-contact-create')
                ->setDescription('Lasy contact create message')
                ->setTrys(0)
                ->setData(
                    (new ContactDTOToArrayTransformer($contactDTO))
                        ->transform()
                )
        ));
    }

    public function forceCloseDBConnection()
    {
        $this->repository->forceCloseConnection();
    }
}
