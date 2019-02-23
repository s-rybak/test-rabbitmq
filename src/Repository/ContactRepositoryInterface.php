<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Contact;

/**
 * Contacts repository interface.
 * Implements repository fucntions.
 *
 * Interface ContactRepositoryInterface
 */
interface ContactRepositoryInterface
{
    public function save(Contact $contact): Contact;
}