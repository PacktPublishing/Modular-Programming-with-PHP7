<?php

abstract class SocialNotifier {
    private $notifyNext = null;

    public function notifyNext(SocialNotifier $notifier) {
        $this->notifyNext = $notifier;
        return $this->notifyNext;
    }

    final public function push($message) {
        $this->publish($message);

        if ($this->notifyNext !== null) {
            $this->notifyNext->push($message);
        }
    }

    abstract protected function publish($message);
}

class TwitterSocialNotifier extends SocialNotifier {
    public function publish($message) {
        // Implementation...
    }
}

class FacebookSocialNotifier extends SocialNotifier {
    protected function publish($message) {
        // Implementation...
    }
}

class PinterestSocialNotifier extends SocialNotifier {
    protected function publish($message) {
        // Implementation...
    }
}

// Client
$notifier = new TwitterSocialNotifier();

$notifier->notifyNext(new FacebookSocialNotifier())
    ->notifyNext(new PinterestSocialNotifier());

$notifier->push('Awesome new product available!');
