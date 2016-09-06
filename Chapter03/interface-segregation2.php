<?php

interface MailerInterface {
    // Implementation...
}

class Mailer implements MailerInterface {
    // Implementation...
}

class NotifySubscriber {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function notify($emailTo) {
        $this->mailer->send('Thank you for...', $emailTo);
    }
}
