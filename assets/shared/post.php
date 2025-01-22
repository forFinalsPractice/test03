<?php

if (isset($_GET['userID']) && !isset($_SESSION['userID'])) {
    $_SESSION['userID'] = $_GET['userID'];
}

$userID = $_SESSION['userID'];

// array for population of posts
$postsList = array();

// Query for Post
$postQuery = "SELECT 
                        posts.postID, 
                        users.userName, 
                        users.profilePicture, 
                        posts.title, 
                        posts.description, 
                        posts.attachment, 
                        tags.tags AS tags, 
                        ratings.ratingValue AS rating
                    FROM users
                    LEFT JOIN posts ON users.userID = posts.userID
                    LEFT JOIN tags ON posts.tagID = tags.tagID
                    LEFT JOIN ratings ON posts.postID = ratings.postID
                    WHERE users.userID = posts.userID
                    ORDER BY posts.postID DESC;";

$postResults = executeQuery($postQuery);

while ($postRow = mysqli_fetch_assoc($postResults)) {
    // created class object to fetch data from the database and pass it to the object attributes
    $post = new Post(
        $postRow['postID'],
        $postRow['title'],
        $postRow['description'],
        $postRow['tags'],
        $postRow['attachment'],
        $postRow['userName'],
        $postRow['rating'],
        null,
        $postRow['profilePicture'],
        null
    );

    array_push($postsList, $post);
}

if (isset($_GET['postID'])) {
    // to get the unique postID of each post
    $postID = $_GET['postID'];
    // Query for Comments from Post
    $commentsQuery = "SELECT posts.postID, posts.title, posts.description, users.userName, users.profilePicture, attachments.attachmentName, comments.content AS comment, tags.tags AS tags
                            FROM posts
                            LEFT JOIN users ON posts.userID = users.userID
                            LEFT JOIN comments ON posts.postID = comments.postID
                            LEFT JOIN attachments ON posts.postID = attachments.postID
                            LEFT JOIN tags ON posts.tagID = tags.tagID
                            WHERE posts.postID = posts.userID";

    $commentsResults = executeQuery($commentsQuery);

    if (mysqli_num_rows($commentsResults) > 0) {
        while ($commentRows = mysqli_fetch_assoc($commentsResults)) {
            $postID = $commentRows['postID'];
            $title = $commentRows['title'];
            $description = $commentRows['description'];
            $userName = $commentRows['userName'];
            $profilePicture = $commentRows['profilePicture'];
            $attachmentName = $commentRows['attachmentName'];
            $comment = $commentRows['comment'];
            $tags = $commentRows['tags'];

        }
    } else {
        echo "<p>No comments yet.</p>";
    }
}




// Query for rating post(not finished)

$userID = isset($_POST['userID']) ? $_POST['userID'] : null;
$postID = isset($_POST['postID']) ? $_POST['postID'] : null;
$ratingValue = 0;


$queryCheckRating = "SELECT ratingValue FROM ratings WHERE postID = '$postID' AND userID = '$userID'";
$resultCheck = executeQuery($queryCheckRating);

if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
    while ($row = mysqli_fetch_assoc($resultCheck)) {
        $ratingValue = $row['ratingValue'];
    }
}
if (isset($_POST['btnRatePost'])) {
    $ratingValue = $_POST['btnRatePost'];

    if (mysqli_num_rows($resultCheck) > 0) {
        $queryRatePost = "UPDATE ratings SET ratingValue = '$ratingValue' WHERE postID = '$postID' AND userID = '$userID'";
        executeQuery($queryRatePost);
    } else {
        $queryRatePost = "INSERT INTO ratings (ratingValue, postID, userID) VALUES ('$ratingValue', '$postID', '$userID')";
        executeQuery($queryRatePost);
    }
}
$queryAvgRating = "SELECT AVG(ratingValue) AS avgRating FROM ratings WHERE postID = '$postID' AND userID = '$userID'";
$resultAvg = executeQuery($queryAvgRating);


$avgRating = 0;
if ($resultAvg && mysqli_num_rows($resultAvg) > 0) {
    while ($rowAvg = mysqli_fetch_assoc($resultAvg)) {
        $avgRating = round($rowAvg['avgRating'], 1);
    }
}

// Query for follow user(not finished)



$followerID = $_SESSION['userID'];
$followedID = isset($_GET['userID']) ? ($_GET['userID']) : null;

if ($followerID == $followedID) {
    echo "You cannot follow yourself!";
    exit();  // Exit the script
}

// Check if already following
$checkFollowQuery = "SELECT * FROM follows WHERE followerID = '$followerID' AND followedID = '$followedID'";
$followResult = executeQuery($checkFollowQuery);
$isFollowing = mysqli_num_rows($followResult) > 0;

// Handle follow/unfollow actions
if (isset($_POST['btnFollow']) && !$isFollowing) {
    $followQuery = "INSERT INTO follows (followerID, followedID) VALUES ('$followerID', '$followedID')";
    executeQuery($followQuery);
    header("Location: index.php?userID=" . $followedID);
    exit();
}

if (isset($_POST['btnUnFollow']) && $isFollowing) {
    $unfollowQuery = "DELETE FROM follows WHERE followerID = '$followerID' AND followedID = '$followedID'";
    executeQuery($unfollowQuery);
    header("Location: index.php?userID=" . $followedID);
    exit();
}

// Count followers
$followersQuery = "SELECT COUNT(*) AS totalFollowers FROM follows WHERE followedID = '$followedID'";
$followersResult = executeQuery($followersQuery);
$followersData = mysqli_fetch_assoc($followersResult);
$totalFollowers = $followersData['totalFollowers'] ?? 0;


?>