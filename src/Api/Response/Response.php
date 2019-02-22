<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Response;

/**
 * Api response object.
 *
 * Class Response.
 */
final class Response implements \JsonSerializable
{
    private $links = [];
    private $status = 'undefined';
    private $message = '';
    private $data = [];

    /**
     * @param iterable $links
     *
     * @return Response
     */
    public function setLinks(iterable $links): self
    {
        $this->links = $links;

        return $this;
    }

    /**
     * @param $data
     *
     * @return Response
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return Response
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'links' => $this->links,
            'data' => $this->data,
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}
