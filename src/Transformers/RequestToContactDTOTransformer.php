<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\DTO\ContactDTO;
use Symfony\Component\HttpFoundation\Request;

/**
 * Transform Request to ContactDTO.
 *
 * Class AMQPMessageToArrayTransformer
 */
class RequestToContactDTOTransformer
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function transform(): ContactDTO
    {
        return (new ContactDTO())
            ->setFirstName($this->request->get('firstName'))
            ->setLastName($this->request->get('lastName'))
            ->setPhoneNumbers($this->request->get('phoneNumbers'));
    }
}
