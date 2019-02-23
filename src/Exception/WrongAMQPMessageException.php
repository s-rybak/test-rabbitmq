<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exception;

/**
 * Exception throws when
 * AMQP message is wrong
 * or contains wrong data.
 */
class WrongAMQPMessageException extends \DomainException
{

}
