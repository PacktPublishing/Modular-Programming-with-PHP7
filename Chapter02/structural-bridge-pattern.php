<?php

interface MailerInterface {
    public function setSender(MessagingInterface $sender);
    public function send($body);
}

abstract class Mailer implements MailerInterface {
    protected $sender;

    public function setSender(MessagingInterface $sender) {
        $this->sender = $sender;
    }
}

class PHPMailer extends Mailer {
    public function send($body) {
        $body .= "\n\n Sent from a phpmailer.";
        return $this->sender->send($body);
    }
}

class SwiftMailer extends Mailer {
    public function send($body) {
        $body .= "\n\n Sent from a SwiftMailer.";
        return $this->sender->send($body);
    }
}

interface MessagingInterface {
    public function send($body);
}

class TextMessage implements MessagingInterface {
    public function send($body) {
        echo 'TextMessage > send > $body: ' . $body;
    }
}

class HtmlMessage implements MessagingInterface {
    public function send($body) {
        echo 'HtmlMessage > send > $body: ' . $body;
    }
}

// Client
$phpmailer = new PHPMailer();
$phpmailer->setSender(new TextMessage());
$phpmailer->send('Hi!');

$swiftMailer = new SwiftMailer();
$swiftMailer->setSender(new HtmlMessage());
$swiftMailer->send('Hello!');
