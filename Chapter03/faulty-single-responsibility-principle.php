<?php

class Ticket {
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'open';
    const SEVERITY_LOW = 'low';
    const SEVERITY_HIGH = 'high';
    protected $title;
    protected $severity;
    protected $status;
    protected $conn;

    public function __construct(\PDO $conn) {
        $this->conn = $conn;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSeverity($severity) {
        $this->severity = $severity;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    private function validate() {
        if (!empty($this->title)
            && !empty($this->status)
            && !empty($this->severity)
        ) {
            return true;
        }
        return false;
    }

    public function save() {
        if ($this->validate()) {
            $stmt = $this->conn->prepare('INSERT INTO
                ticket (title, severity, status)
                VALUES (:title, :severity, :status)'
            );
            $stmt->execute(array(
                ':title' => $this->title,
                ':severity' => $this->severity,
                ':status' => $this->status,
            ));

            return $this->conn->lastInsertId();
        }
        return 0;
    }

}

// Client
$conn = new PDO(
    'mysql:host=localhost;dbname=project;charset=utf8',
    'root', 'mysql'
);

$ticket = new Ticket($conn);
$ticket->setTitle('Checkout not working!');
$ticket->setStatus(Ticket::STATUS_OPEN);
$ticket->setSeverity(Ticket::SEVERITY_HIGH);
$ticket->save();
