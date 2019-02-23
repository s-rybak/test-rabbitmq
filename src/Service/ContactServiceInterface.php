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

interface ContactServiceInterface
{
    public function save(Contact $contact): Contact;

    public function create(ContactDTO $contactDTO): Contact;
}
