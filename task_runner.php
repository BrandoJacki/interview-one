<?php
require 'autoload.php';

$loop = \React\EventLoop\Factory::create();
$counter= 0;
$max_process = 100000;

$loop->addPeriodicTimer(1, function() use (&$counter) {
    $counter++;
    if ($counter < $max_process) {
        $task = MinHeap::pop();
        ProcessTask($task);
    } else {
        $counter = ResetProcessors();
    }
});
$loop->run();


function AverageProcessingTime(){
    $db = new DBConnection();
    $so_far_tasks = $db->queryAll();

    $sum = 0;
    foreach ($so_far_tasks as $task) {
        $sum += $task['end_time'] - $task['start_time'];
    }
    $avg = $sum / count($so_far_tasks);

    return $avg;

}

function ProcessTask($task) {
    $db = new DBConnection();
    $task['end_time'] = time();
    $processor_id = $db->insert($task);

    return $processor_id;
}


function ResetProcessors() {
    // after a delay, we can reset
    return 0;
}

