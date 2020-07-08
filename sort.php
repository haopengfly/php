<?php

$arr = [10,13,42,23,67,365,87665,54,68,3];

/*
 * 1 快速排序
 * 2 冒泡排序
 * 3 选择排序
 * 4 插入排序
 */
function quick($arr)
{
    if(count($arr)<=1){
        return $arr;
    }

    $middle = $arr[0];
    $left = [];
    $right = [];

    foreach ($arr as $v){
        if($v<$middle){
            $left[] = $v;
        }elseif($v>$middle){
            $right[] = $v;
        }
    }

    return array_merge(quick($left),[$middle],quick($right));
}

function bubble($arr)
{
    $length = count($arr);

    for($i=0;$i<$length-1;$i++){
        for ($j=0;$j<$length-$i-1;$j++){
            if($arr[$j]>$arr[($j+1)]){
                $tmp = $arr[$j];
                $arr[$j] = $arr[($j+1)];
                $arr[$j+1] = $tmp;
            }
        }
    }

    return $arr;
}

function selection($arr)
{
    $len = count($arr);
    for ($i=0;$i<$len-1;$i++){
        $minIndex = $i;
        $minValue = $arr[$i];
        for ($j=$i+1;$j<$len;$j++){
            if($arr[$j]<$minValue){
                $minIndex = $j;
                $minValue = $arr[$j];
            }
        }

        $tmp = $arr[$i];
        $arr[$i] = $minValue;
        $arr[$minIndex] = $tmp;
    }

    return $arr;
}

function insert($arr){
    $len = count($arr);

    for($i=1;$i<$len;$i++){
        $tmp = $arr[$i];
        for($j=$i-1;$j>=0;$j--){
            if($tmp<$arr[$j]){
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            }else{
                break;
            }
        }
    }

    return $arr;
}


print_r(insert($arr));
