# NotificatorBundle

[![Build Status](https://travis-ci.org/mkebza/NotificatorBundle.svg?branch=master)](https://travis-ci.org/mkebza/NotificatorBundle)


This is simple bundle to manage notifications though different channels.

## Installation

### Applications that use Symfony Flex


Open a command console, enter your project directory and execute:

```console
$ composer require mkebza/notificator-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require mkebza/notificator-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new MKebza\Notificator\MKebzaNotificatorBundle(),
        );

        // ...
    }

    // ...
}
```

## Configuration

You need to define at least one handler, otherwise your messeges aren't 
gonna be send. For handler is mandatory to define service handler. 

```yaml
m_kebza_notificator:
    handlers:
        email:
            service: MKebza\Notificator\Handler\Type\SwiftMailerHandler
            options:
                from_name: Foo Bar
                from_email: foo@bar.com
        email_second:
            service: MKebza\Notificator\Handler\Type\SwiftMailerHandler
        sms: MKebza\Notificator\Handler\Type\SwiftMailerHandler
```

## Sending notification

First you have to implement your notification class, which has to implement 
`NotificationInterface` and service has to be tagged with `mkebza_notificator.notification`

```php
namespace App\Notification;

class TestNotification implements NotificationInterface
{
    public function getChannels(NotifiableInterface $target): array
    {
        // Returns which channels this notification implements
        return [
            'email'
        ];
    }

    // Renders notification for handler
    public function email(Notification $notification, array $options): Notification
    {
        $message = (new \Swift_Message())
            ->setSubject('Test subject')
            ->setBody('Test');

        return $notification->setContent($message);
    }
}
```

Then you can send your notification. Parameter to notifable is configuration for each channel.
```yaml
// $notificator is instance of service MKebza\Notificator\Notificator
$notificator->send(new Notifiable(['email' => 'foo@bar.com']), TestNotification::class, ['data' => 'will_be_passed']);
```

You can have your objects implement `MKebza\Notificator\NotifiableInterface` and then you can call

```php
$notificator->send($user, TestNotification::class, ['data' => 'will_be_passed']);
$notificator->send([$user1, $user2], TestNotification::class, ['data' => 'will_be_passed']);
```

## Handlers

New handlers can be implemented, handler has to implement `MKebza\Notificator\Handler\NotificationHandlerInterface`



