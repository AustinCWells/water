<?php

// CONNECT TO DB
try
{
    $m = new MongoClient(); // connect
    $db = $m->selectDB("water");
}
catch ( MongoConnectionException $e )
{
    echo "\nCouldn't connect to mongodb, is the 'mongo' process running?\n\n";
    exit();
}

// CREATE COLLECTION VARIABLES
$items = new MongoCollection($db, 'items');     // Items Collection
//$notifications = new MongoCollection($db, 'notifications');     // Users Collection



/**
 * Function to determine whether all the arguments of the source
 * are identical to the test arguments.
 *
 * @param $source - Source of original arguments
 * @param $args - Test arguments to compare with source
 * @return bool - Value indicating whether the args are identical
 */
function attributesPresent($source, $args) {         // Accept source with args and the test arguments to compare against
    $argc = count($args);                                   // Get count of arguments
    for ($i = 0; $i < $argc; $i++) {                        // One at a time, compare the actual arg against test arg
        if (!isset($source[$args[$i]])) {
            return false;
        }
    }
    return true;                                            // If all args are identical (order sensitive), return TRUE
}

/**
 * Function to determine whether POST arguments exist.
 *
 * @return bool - Represents whether arguments passed to it are
 * identical to those included within the first parameter
 */
function POSTAttributesPresent() {
// func_get_args is an array of the args passed to THIS function
    return attributesPresent($_POST, func_get_args());      // Check args in POST against test args passed to THIS function
}

/**
 * Function to determine whether GET arguments exist.
 *
 * @return bool - Represents whether arguments passed to it are
 * identical to those included within the first parameter
 */
function GETAttributesPresent() {
// func_get_args is an array of the args passed to THIS function
    return attributesPresent($_GET, func_get_args());      // Check args in POST against test args passed to THIS function
}
