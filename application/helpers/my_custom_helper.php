<?php defined('BASEPATH') OR exit('No direct script access allowed');

function clean_input($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);    
    return $value;
}

// string format in comma separated
function comma_format($string = '')
{
    if($string !== ''){
        // temp array variable
        $tempArray = Array();
        // result array variable
        $resultArray = Array();

        // string to array convert
        $copyArray = explode(',', $string);
        
        foreach ($copyArray as $key => $value) {
            // clean inputs and push into result array
            array_push($resultArray, clean_input($value));
        }

        // array to string convert
        $resultArray = implode (",", $resultArray);

        return $resultArray;
    }
}