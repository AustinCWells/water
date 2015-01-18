<?php

require_once dirname(__FILE__) . "/utilities.php";
require '../sendgrid-php/vendor/autoload.php';

$args = $_GET;
$numArgs = count($args);


if ($numArgs == 1) {
    if(GETAttributesPresent('userToken'))
    {
        $userToken = $_GET['userToken'];

        // ROUTE REQUEST TO getTrackedItems()
        getTrackedItems($userToken);

        // getTrackedItemsDemo($userToken);
    }
    else if (GETAttributesPresent('itemNum'))
    {
        removeTrackedItem($_GET['itemNum']);
    }
    else if (GETAttributesPresent('testEmail'))
    {
        $email = $_GET['testEmail'];
        $subject = "Testing";
        $text = "Testing";
        $html = '<strong>Check out your notification!</strong>';


        sendgridNotification($email, $subject, $text, $html);
    }
}
else if (GETAttributesPresent('itemNum', 'setAlert'))
{
    itemChanged($_GET['itemNum'], $_GET['setAlert']);
}
else if (GETAttributesPresent('itemNum', 'success'))
{
    notificationSuccess($_GET['itemNum']);
}
else if (GETAttributesPresent('userToken', 'description', 'notificationMethod', 'url', 'recurrence')) {
    $userToken = $_GET['userToken'];
    $description = $_GET['description'];
    $notificationMethod = $_GET['notificationMethod'];
    $url = $_GET['url'];
    $recurrence = $_GET['recurrence'];

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

//    echo "\nUser [".$userToken."]:\n";
    echo json_encode(iterator_to_array($userItems));
}


/**
 * Function that accepts a series of parameters and adds a new item to the DB, returns
 * information for the item that was just added.
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
        'notificationMethod' => $notificationMethod, 'url' => $url, 'recurrence' => $recurrence, 'alert' => false);
    $items->insert($newItem);

    $addedItem = $items->find(array('description' => $description));

//    echo "\nItem Added: \n";
    echo json_encode(iterator_to_array($addedItem));
}


/**
 * Function to find an active item and remove it from the list of tracked items
 *
 * @param $itemNum - Unique identifier (primary key) for an individual item
 */
function removeTrackedItem($itemNum) {
    global $items;

    $items->remove(array('_id' => new MongoId($itemNum)));

//    echo "\nItem Removed";
}


/**
 * Function used to indicate an item has changed and an alert should be signaled.
 *
 * @param $itemNum - Unique identifier (primary key) for an individual item
 * @param $setAlert - boolean value indicating whether the alert flag should be set
 */
function itemChanged($itemNum, $setAlert) {
    global $items;

    $items->update(array('_id' => new MongoId($itemNum)), array('$set' => array('alert' => $setAlert)));

//    if (strcmp($setAlert, "true") == 0)
//        echo "\nALERT ACTIVE\n";
//    else
//        echo "\nALERT CLEARED\n";
}


/**
 * Function to determine whether an item is recurring or a single use. Depending on the outcome,
 * the item is either removed or its alert flag is cleared.
 *
 * @param $itemNum - Unique identifier (primary key) for an individual item
 */
function notificationSuccess($itemNum) {
    global $items;

    $item = $items->findOne(array('_id' => new MongoId($itemNum)));
    //findOne returns a different type of object which can be used to access elements

    if (strcmp($item['recurrence'], "once") == 0)
    {
        removeTrackedItem($itemNum);
    }
    else
    {
        itemChanged($itemNum, false);
    }
}





function sendgridNotification($email, $subject, $text, $html ) {
    $sendgrid = new SendGrid('skaiser@smu.edu', 'mhackswinners');
//    echo $sendgrid;

    $email = new SendGrid\Email();
    $email->addTo($email)->
        setFrom('Water@MHacks.com')->
        setSubject($subject)->
        setText($text)->
        setHtml($html);

    $sendgrid->send($email);
}













function getTrackedItemsDemo($userToken) {
    $item = array('itemNumber' => 123, 'category' => "Facebook", 'description' => "trackLikesForMyPost", 'contactMethod' => "phone", 'url' => "http://www.facebook.com");
    $item2 = array('itemNumber' => 456, 'category' => "Twitter", 'description' => "trackRetweetsForMyTwat", 'contactMethod' => "all the things", 'url' => "http://www.jankopotomous.com");
    $item3 = array('itemNumber' => 789, 'category' => "LinkedIn", 'description' => "trackPageViews", 'contactMethod' => "email", 'url' => "http://www.linkedin.com");
    $items = array($item, $item2, $item3);

    echo json_encode($items);
}
