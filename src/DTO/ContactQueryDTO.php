<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

/**
 * Class ContactQueryDTO.
 */
class ContactQueryDTO
{
    private $start = 0;
    private $length = 10;
    private $search;
    private $orderBy;
    private $orderDir;

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     *
     * @return ContactQueryDTO
     */
    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     *
     * @return ContactQueryDTO
     */
    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string $search
     *
     * @return ContactQueryDTO
     */
    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     *
     * @return ContactQueryDTO
     */
    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderDir(): ?string
    {
        return $this->orderDir;
    }

    /**
     * @param string $orderDir
     *
     * @return ContactQueryDTO
     */
    public function setOrderDir(string $orderDir): self
    {
        $this->orderDir = $orderDir;

        return $this;
    }
}
