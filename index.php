<?php 



$orderTime = [
    'hours' => 01,
    'minutes' => 23,
    'seconds' => 28,
    'weekday' => 5,
    'day' => 28,
    'month' => 2,
    'year' => 2023,
];

$workTime = [
    'start' => 10,
    'finish' => 19,
];



function contractTime(array $orderTime, array $workTime) :array
{
    $arrayMonth = [
        1 => 31,
        2 => 28,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31,
    ];
    $timer = 24;
    $currentDaysInMonth = 0;

    if($orderTime['hours'] >= $workTime['start'] && $orderTime['hours'] < $workTime['finish']) 
    {
        $timer = $timer - ($workTime['finish']- $orderTime['hours']);
        $orderTime['weekday'] += 1;
        $orderTime['day'] += 1; 
    }

    while ($timer >= 9) {
        if ($orderTime['weekday'] > 7)
        {
            $orderTime['weekday'] -= 7;
        }



        if($orderTime['weekday'] == 5 && $orderTime['hours'] >= $workTime['finish'])
        {
            $orderTime['weekday'] += 1;
            $orderTime['day'] += 1;
        }
        if($orderTime['weekday'] == 6 || $orderTime['weekday'] == 7)
        {
            $orderTime['weekday'] += 1;
            $orderTime['day'] += 1;
        }
        else 
        {
            $timer -= 9;
            $orderTime['weekday'] += 1;
            $orderTime['day'] += 1;
        }   
    }

    
    $orderTime['hours'] = $workTime['start'] + $timer;

    
    foreach($arrayMonth as $month => $value)
    {
        if ($month == $orderTime['month']) {
            $currentDaysInMonth += $value;
        }
    }
    

    foreach ($orderTime as $key => $value) {
        if ($key == 'day')
        {
            if($value > $currentDaysInMonth) {
                $orderTime['day'] = $value - $currentDaysInMonth;
                $orderTime['month'] += 1;
            }
        } 
    }
    
    foreach ($orderTime as $key => $value) 
    {
        if ($key == 'month') {
            if ($value > 12) {
                $orderTime['month'] = 1;
                $orderTime['year'] += 1;
            }
        }
    }

    return $orderTime;
}


print_r(contractTime($orderTime,$workTime));
