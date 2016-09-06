<?php

class Mailer {
    // Implementation...
}

class NotifySubscriber {
    public function notify($emailTo) {
        $mailer = new Mailer();
        $mailer->send('Thank you for...', $emailTo);
    }
}
