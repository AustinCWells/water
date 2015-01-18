<?php

require_once dirname(__FILE__) . "/utilities.php";

$args = $_POST;
$numArgs = count($args);


if ($numArgs == 1) {
    if(POSTAttributesPresent('userToken'))
    {
        $userToken = $_POST['userToken'];

        // ROUTE REQUEST TO getTrackedItems()
        getTrackedItems($userToken);

        // getTrackedItemsDemo($userToken);
    }
    else if (POSTAttributesPresent('itemNum'))
    {
        removeTrackedItem($_POST['itemNum']);
    }
}
else if (POSTAttributesPresent('userToken', 'description', 'notificationMethod', 'url', 'recurrence')) {
    $userToken = $_POST['userToken'];
    $description = $_POST['description'];
    $notificationMethod = $_POST['notificationMethod'];
    $url = $_POST['url'];
    $recurrence = $_POST['recurrence'];

    // ROUTE REQUEST TO addTrackedItem()
    addTrackedItem($userToken, $description, $notificationMethod, $url, $recurrence);
}
else {
    $userItems = $items->find();
    echo json_encode(iterator_to_array($userItems));
}


/**
 * Function that accepts a user token and returns all active items being tracked
 *
 * @param $userToken - User token created by Google authentication
 */
function getTrackedItems($userToken) {
    global $items;

    $userItems = $items->find(array('userToken' => $userToken));

    echo "\nUser [".$userToken."]:\n";
    echo json_encode(iterator_to_array($userItems));
}


/**
 * Function that accepts a series of parameters and adds a new item to the DB
 *
 * @param $userToken - User token created by Google authentication
 * @param $description - Description of what is being tracked
 * @param $notificationMethod - Method in which the user will be notified (phone, email, notification, etc.)
 * @param $url - URL linking to the post (or page) being tracked
 * @param $recurrence - How often notifications will take place (once/recurring)
 */
function addTrackedItem($userToken, $description, $notificationMethod, $url, $recurrence) {
    global $items;

    $newItem = array('userToken' => $userToken, 'description' => $description,
        'notificationMethod' => $notificationMethod, 'url' => $url, 'recurrence' => $recurrence);
    $items->insert($newItem);

    echo "\nItem Added: \n";
    echo json_encode($newItem);
}


/**
 * Function to find an active item and remove it from the list of tracked items
 *
 * @param $itemNum - Unique identifier (primary key) for an individual item
 */
function removeTrackedItem($itemNum) {
    global $items;

    $items->remove(array('_id' => new MongoId($itemNum)));

    echo "\nItem Removed";
}







function getTrackedItemsDemo($userToken) {
    $item = array('itemNumber' => 123, 'category' => "Facebook", 'description' => "trackLikesForMyPost", 'contactMethod' => "phone", 'url' => "http://www.facebook.com");
    $item2 = array('itemNumber' => 456, 'category' => "Twitter", 'description' => "trackRetweetsForMyTwat", 'contactMethod' => "all the things", 'url' => "http://www.jankopotomous.com");
    $item3 = array('itemNumber' => 789, 'category' => "LinkedIn", 'description' => "trackPageViews", 'contactMethod' => "email", 'url' => "http://www.linkedin.com");
    $items = array($item, $item2, $item3);

    echo json_encode($items);
}
