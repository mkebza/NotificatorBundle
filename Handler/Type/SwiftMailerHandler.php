<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Handler\Type;

use MKebza\Notificator\Exception\InvalidNotificationContentException;
use MKebza\Notificator\Handler\NotificationHandlerInterface;
use MKebza\Notificator\Notification;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwiftMailerHandler implements NotificationHandlerInterface
{
    /**
     * @var array
     */
    protected $default;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * SwiftMailerHandler constructor.
     *
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function configure(array $options): void
    {
        $resolver = (new OptionsResolver())
            ->setDefaults([
                'from_name' => 'FooBar',
                'from_email' => 'foo@bar.com',
            ])
            ->setAllowedTypes('from_name', ['string'])
            ->setAllowedTypes('from_email', ['string']);

        $this->default = $resolver->resolve($options);
    }

    public function handle(Notification $notification): void
    {
        $message = $notification->getContent();
        if (!$message instanceof \Swift_Message) {
            throw new InvalidNotificationContentException(sprintf(
                'Content for %s has to be instance of %s. Did you forget to call $notification->setContent() in your notification?',
                self::class, \Swift_Message::class
            ));
        }

        $message->setTo($notification->getTarget());

        if (empty($message->getFrom())) {
            $message->setFrom([$this->default['from_email'] => $this->default['from_name']]);
        }

        $this->mailer->send($message);
    }
}
