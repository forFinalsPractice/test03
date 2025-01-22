<?php 

$userID = $_GET['userID'];

if (isset($_POST['postID'])) {
    $postID = $_POST['postID'];

    $checkBookmark = "SELECT * FROM `savedbookmarks` WHERE `postID` = '$postID' AND `userID` = '$userID'";
    $result = executeQuery($checkBookmark);

    if (mysqli_num_rows($result) > 0) {
        
        $removeBookmark = "DELETE FROM `savedbookmarks` WHERE `postID` = '$postID' AND `userID` = '$userID'";
        executeQuery($removeBookmark);
    } else {
      
        $addBookmark = "INSERT INTO `savedbookmarks`(`postID`, `userID`) VALUES ('$postID','$userID')";
        executeQuery($addBookmark);
    }
    

    $lastInsertedId = mysqli_insert_id($conn);

}
?>