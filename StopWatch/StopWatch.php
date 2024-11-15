<?php
class StopWatch
{
    private $startTime;
    private $endTime;
    public function __construct()
    {
        $this->startTime = date("h:i:s");
    }
    public function getStartTime()
    {
        return $this->startTime;
    }
    public function getEndTime()
    {
        return $this->endTime;
    }
    public function start()
    {
        $this->startTime = date("h:i:s");
    }
    public function stop()
    {
        $this->endTime = date("h:i:s");
    }
    public function getElapsedTime()
    {
        return strtotime($this->endTime) - strtotime($this->startTime);
    }
}

$newStopWatch = new StopWatch();
// $line = readline("Command: ");
// if ($line == "start") {
//     $newStopWatch->start();
// }
// $line = readline("Command: ");
// if ($line == "stop") {
//     $newStopWatch->stop();
//     echo "Start time " . $newStopWatch->getStartTime() . "\n";
//     echo "End time " . $newStopWatch->getEndTime() . "\n";
//     echo "Elapsed time " . $newStopWatch->getElapsedTime() . "\n";
// }

// 
function selection_sort($data)
{
    for ($i = 0; $i < count($data) - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < count($data); $j++) {
            if ($data[$j] < $data[$min]) {
                $min = $j;
            }
        }
        $data = swap_positions($data, $i, $min);
    }
    return $data;
}

function swap_positions($data1, $left, $right)
{
    $backup_old_data_right_value = $data1[$right];
    $data1[$right] = $data1[$left];
    $data1[$left] = $backup_old_data_right_value;
    return $data1;
}
$my_array = range(-50000, 50000);
$newStopWatch->start();
echo "Start time :" . $newStopWatch->getStartTime() . "\n";
selection_sort($my_array);
$newStopWatch->stop();
echo "End time " . $newStopWatch->getEndTime() . "\n";
echo "Elapsed time " . $newStopWatch->getElapsedTime() . "\n";
