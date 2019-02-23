<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\DTO\ContactDTO;

/**
 * Transform ContactDTO to array.
 *
 * Class AMQPMessageToArrayTransformer
 */
class ContactDTOToArrayTransformer
{
    /**
     * @var ContactDTO
     */
    private $contactDTO;

    public function __construct(ContactDTO $contactDTO)
    {
        $this->contactDTO = $contactDTO;
    }

    public function transform(): array
    {
        return [
            'firstName' => $this->contactDTO->getFirstName(),
            'lastName' => $this->contactDTO->getLastName(),
            'phoneNumbers' => $this->contactDTO->getPhoneNumbers(),
        ];
    }
}
