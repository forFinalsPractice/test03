<?php
include("../assets/shared/connect.php");
include("../assets/shared/classes.php");

$tagID = $_GET['tagID'];

$tagsList = array();

$tagSelectQuery = "SELECT * FROM users LEFT JOIN posts ON users.userID = posts.userID 
                    LEFT JOIN attachments ON posts.postID = attachments.postID 
                    LEFT JOIN tags ON posts.tagID = tags.tagID 
                    LEFT JOIN ratings ON posts.postID = ratings.postID 
                    LEFT JOIN comments ON posts.postID = comments.postID 
                    WHERE tags.tagID = $tagID 
                    ORDER BY posts.postID DESC";

$tagSelectQueryResult = executeQuery($tagSelectQuery);


while ($tagRow = mysqli_fetch_assoc($tagSelectQueryResult)) {
    // created class object to fetch data from the database and pass it to the object attributes
    $tag = new Post(
        $tagRow['postID'],
        $tagRow['title'],
        $tagRow['description'],
        $tagRow['tags'],
        $tagRow['attachmentName'],
        $tagRow['attachmentPath'],
        $tagRow['userName'],
        $tagRow['ratingID'],
        $tagRow['commentID'],
        $tagRow['profilePicture'],
        $tagRow['tagImg']
    );

    array_push($tagsList, $tag);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>NowUKnow</title>
</head>

<style>
    .custom-card {
        width: 100%;
        max-width: auto;
        margin: auto;
        background-color: #C9F6FF;
        border-color: white;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        border-radius: 50px;
        border-color: transparent;
        height: 30px;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: "Helvetica Rounded";
        background-color: #7091E6;
    }

    .middle-column {
        height: 100vh;
        flex: 2;
        background-color: #ffffff;
        overflow-y: auto;
        overflow-x: hidden;
        padding-top: 0;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }

    .middle-column .nav-link {
        font-family: 'Helvetica Rounded', sans-serif;
        font-size: 1.5rem;
        color: #333;
    }

    .navbar {
        border-bottom: 1px solid #35D6ED;
    }

    @media (max-width: 768px) {
        .card-text {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 1000px) {
        .left-column {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: left 0.3s ease;
            z-index: 1;
        }

        .middle-column {
            width: 100%;
        }

        .left-column.show {
            left: 0;
        }
    }

    .hamburger-btn {
        display: block;
        font-size: 25px;
        width: 25px;
        cursor: pointer;
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 999;
    }

    @media (min-width: 1000px) {
        .hamburger-btn {
            display: none;
        }
    }
</style>

<body>
    <div class="container">
        <div class="row">

            <!-- Hamburger Button -->
            <div class="hamburger-btn" onclick="toggleLeftColumn()">&#9776;</div>

            <!-- Left Column -->
            <div class="col-md-3 left-column">
                <div class="logo">
                    <img src="../assets/icons/wordMark big.svg" alt="NowUKnow Logo" width="100" height="100">
                </div>
                <div class="sidebar">
                    <ul>
                        <li>
                            <a href="../index.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-house nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="../users/profile.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-user nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="../tags/explore.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-hashtag nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Tags</span>
                            </a>
                        </li>
                        <li>
                            <a href="../notif.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-bell nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Notification</span>
                            </a>
                        </li>
                        <li>
                            <a href="../bookmarks.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F">
                                <i class="fa-solid fa-bookmark nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Bookmarks</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="logout-container">
                    <button class="btn-logout">Log Out</button>
                </div>
            </div>

            <!-- Middle Column -->
            <div class="col-md-6 middle-column px-0">

                <nav class="navbar navbar-expand-md navbar-light bg-light">
                    <div class="container" style="height:65px">
                        <h5 class="m-0 title-text ms-3" style="font-family:Helvetica-Rounded; letter-spacing:normal">
                            Explore Tags</h5>
                    </div>
                </nav>

                <div class="content">
                    <div class="container">
                        <?php
                        foreach ($tagsList as $tagItem) {
                            // function to display dynamic posts of users from the database
                            echo $tagItem->createPost();
                            // function to display dynamic modal of each post of users from the database; can add or view of comments
                            echo $tagItem->showModal();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- JS Post -->
    <script src="../assets/js/post.js"></script>
    <!-- JS Left column -->
    <script src="../assets/js/leftcolumn.js"></script>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>