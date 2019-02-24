<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\DTO\ContactQueryDTO;
use Symfony\Component\HttpFoundation\Request;

/**
 * Transform Request to ContactQueryDTO.
 *
 * Class AMQPMessageToArrayTransformer
 */
class RequestToContactQueryDTOTransformer
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function transform(): ContactQueryDTO
    {
        return (new ContactQueryDTO())
            ->setLength($this->request->get('length'))
            ->setStart($this->request->get('start'))
            ->setSearch($this->request->get('search') ?? null)
            ->setOrderBy($this->request->get('order') ?? null)
            ->setOrderDir($this->request->get('dir') ?? null);
    }
}
