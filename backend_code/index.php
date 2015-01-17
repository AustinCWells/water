<?php

require_once dirname(__FILE__) . "/utilities.php";

//$counter = 0;
//while (isset($_POST[$counter]))
//{
//    echo $_POST[$counter];
//    $counter += 1;
//}

$values = $_POST;
$count = count($values);

echo "NUM PARAMS: ".$count;


if (POSTAttributesPresent('userToken')) {
    $userToken = $_POST['userToken'];

    // ROUTE REQUEST TO getTrackedItems()
    getTrackedItems($userToken);

    // getTrackedItemsDemo($userToken);
}
else if (POSTAttributesPresent('userToken', 'category', 'description', 'notificationMethod', 'url')) {
    $userToken = $_POST['userToken'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $notificationMethod = $_POST['notificationMethod'];
    $url = $_POST['url'];

    // ROUTE REQUEST TO addTrackedItem()
    addTrackedItem($userToken, $category, $description, $notificationMethod, $url);
}
else {
    echo "\nNo Parameters\n\n";
}




function getTrackedItems($userToken) {
//    tasks = db.users.$userToken.find();

}

function getTrackedItemsDemo($userToken) {
    $task = array('itemNumber' => 123, 'category' => "Facebook", 'description' => "trackLikesForMyPost", 'contactMethod' => "phone", 'url' => "http://www.facebook.com");
    $task2 = array('itemNumber' => 456, 'category' => "Twitter", 'description' => "trackRetweetsForMyTwat", 'contactMethod' => "all the things", 'url' => "http://www.jankopotomous.com");
    $task3 = array('itemNumber' => 789, 'category' => "LinkedIn", 'description' => "trackPageViews", 'contactMethod' => "email", 'url' => "http://www.linkedin.com");
    $tasks = array($task, $task2, $task3);

    echo json_encode($tasks);
}


function addTrackedItem($userToken, $category, $description, $notificationMethod, $url) {

}