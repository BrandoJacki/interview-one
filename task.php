<?php
class Task extends MinHeap {
    private static $_instance = null;
    private static $_data;
    private static $_verb;

    private function __clone() {}   

    private function __construct() {}  

    public static function &getInstance(): Task {
        if ( !(self::$_instance instanceof self) && is_null(self::$_instance) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function setVerb($verb) {
        self::$_verb = $verb;

        return self::$_instance;
    }

    public function setData($data) {
        self::$_data = $data;

        return self::$_instance;
    }

    public function run() {
        $result = array();
        $job_id = self::$_data['job_id'] ? self::$_data['job_id'] : null;
        switch (self::$_verb) {
            case "GET":
                if (!is_null($job_id)) {
                    $result = $this->query($job_id);
                } else {
                    $result = $this->dequeue();
                }
                break;

            case "POST":
                $result = $this->enqueue(self::$_data);
                break;

            default:
                $result = "None";

        }

        return $result;
    }

    public function enqueue($data) {
        $job_id = $data['job_id'];
        $submitter_id = $data['submitter_id'];

        $this->push([
            $job_id => [
                'process_id' => null,
                'submitter_id' => $submitter_id,
                'start_time' => time(),
                'status' => 'Queued',
            ],
        ]);

        return;
    }

    public function dequeue() {
        // pop the highest priority
        // the first element in heap
        return $this->pop();
    }

    public function query($job_id): ?array {
        $job = $this->get($job_id);
        if (is_null($job)) {
            $db = new DBConnection();
            $job = $db->query(['job_id' => $job_id]);
        }

        return $job;
    }

}
