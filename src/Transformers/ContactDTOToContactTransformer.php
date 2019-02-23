<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\DTO\ContactDTO;
use App\Entity\Contact;

/**
 * Transform contactDTO to Contact entity
 *
 * Class ContactDTOToContactTransformer
 * @package App\Transformers
 */
class ContactDTOToContactTransformer
{
    private $contactDTO;

    public function __construct(ContactDTO $contactDTO)
    {

        $this->contactDTO = $contactDTO;

    }

    public function transform(): Contact
    {

        return (new Contact())
            ->setFirstName($this->contactDTO->getFirstName())
            ->setLastName($this->contactDTO->getLastName())
            ->setPhoneNumbers($this->contactDTO->getPhoneNumbers());

    }
}
