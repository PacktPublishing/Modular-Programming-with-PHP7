<?php

interface KeyValuePersistentMembers {
    public function toArray();
}

class Ticket implements KeyValuePersistentMembers {
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'open';
    const SEVERITY_LOW = 'low';
    const SEVERITY_HIGH = 'high';
    protected $title;
    protected $severity;
    protected $status;

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSeverity($severity) {
        $this->severity = $severity;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function toArray() {
        return array(
            'title' => $this->title,
            'severity' => $this->severity,
            'status' => $this->status
        );
    }
}

class EntityManager {
    protected $conn;

    public function __construct(\PDO $conn) {
        $this->conn = $conn;
    }

    // Dirty, nasty & buggy; will do for example
    public function save(KeyValuePersistentMembers $entity)
    {
        $binds = array();
        $prepares = array();
        $props = $entity->toArray();
        $ref = new \ReflectionClass($entity);
        $table = strtolower($ref->name);
        foreach ($props as $n => $v) {
            $binds[':' . $n] = $v;
            $prepares[] = ':' . $n;
        }
        $stmt = $this->conn->prepare('INSERT INTO
                ' . $table . ' (' . implode(', ', array_keys($props)) . ')
                VALUES (' . implode(', ', $prepares) . ')'
        );
        $stmt->execute($binds);

        return $this->conn->lastInsertId();
    }
}

class Validator {
    public function validate(KeyValuePersistentMembers $entity) {
        $properties = $entity->toArray();
        foreach ($properties as $name => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
}

// Client
$conn = new PDO(
    'mysql:host=localhost;dbname=project;charset=utf8',
    'root', 'mysql'
);

$ticket = new Ticket();
$ticket->setTitle('Payment not working!');
$ticket->setStatus(Ticket::STATUS_OPEN);
$ticket->setSeverity(Ticket::SEVERITY_HIGH);

$validator = new Validator();

if ($validator->validate($ticket)) {
    $entityManager = new EntityManager($conn);
    $entityManager->save($ticket);
}
