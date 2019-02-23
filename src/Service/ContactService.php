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
use App\Transformers\ContactDTOToContactTransformer;

class ContactService implements ContactServiceInterface
{

    /**
     * @var ContactRepositoryInterface
     */
    private $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
}
