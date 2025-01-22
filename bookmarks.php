<?php
include("assets/shared/connect.php");
include("assets/shared/classes.php");

$userID = $_GET['userID'];

include("assets/shared/process.php");

$bookmarkList = array();

$bookmarkQuery = "SELECT * FROM `savedbookmarks` 
JOIN posts ON savedbookmarks.postID = posts.postID 
JOIN users ON savedbookmarks.userID = users.userID 
WHERE savedbookmarks.userID = $userID";

$bookmarkQueryResult = executeQuery($bookmarkQuery);

while ($bookmark = mysqli_fetch_assoc($bookmarkQueryResult)) {
    // created class object to fetch data from the database and pass it to the object attributes
    $bm = new Post(
        $bookmark['postID'],
        $bookmark['title'],
        $bookmark['description'],
        null,
        null,
        null,
        $bookmark['userName'],
        $bookmark['ratingID'],
        null,
        $bookmark['profilePicture'],
        null
    );

    array_push($bookmarkList, $bm);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>NowUKnow</title>
</head>

<style>
    .create-post-button {
        position: absolute;
        bottom: 50px;
        right: 50px;
    }

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
        border-color: transparent;
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
                <div class="logo m-0">
                    <img src="assets/icons/wordMark big.svg" alt="NowUKnow Logo" width="100" height="100">
                </div>
                <div class="sidebar">
                    <ul>
                        <li>
                            <a href="users/index.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-house nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="users/profile.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-user nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="tags/explore.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-hashtag nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Tags</span>
                            </a>
                        </li>
                        <li>
                            <a href="notif.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-bell nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Notification</span>
                            </a>
                        </li>
                        <li>
                            <a href="bookmarks.php"
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
            <div class="col-12 col-md-6 middle-column p-0">
                <div class="middle-search-bar">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <div class="content p-0">
                    <!-- notification title -->
                    <div class="container-fluid p-0">
                        <div class="container-fluid notif-card d-flex justify-content-center align-items-center"
                            style="height: 65px;">
                            <h5 class="m-0 title-text" style="font-family:Helvetica-Rounded; letter-spacing:normal">
                                Bookmarks</h5>
                        </div>

                        <div class="container">
                            <?php
                            foreach ($bookmarkList as $bookmarkItem) {
                                // function to display dynamic posts of users from the database
                                echo $bookmarkItem->createPost();
                                // function to display dynamic modal of each post of users from the database; can add or view of comments
                                echo $bookmarkItem->showModal();
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <!-- Create button for responsiveness -->
                <div class="me-3">
                    <div class="create-post-button">
                        <button class="btn-create-post" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img src="assets/icons/edit.svg" alt="Icon" class="button-icon"> Create Post
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-3 right-column d-none d-md-block">
                <div class="right-search-bar" style="margin-bottom: 15px;">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <div class="announcement-tab">
                    <h5 style="margin-bottom: 15px;">Announcements</h5>
                    <div class="announcement-box">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">System Update</h6>
                                <p class="card-text">This is the first announcement.</p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">System Update</h6>
                                <p class="card-text">This is the first announcement.</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">System Update</h6>
                                <p class="card-text">This is the first announcement.</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">System Update</h6>
                                <p class="card-text">This is the first announcement.</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">System Update</h6>
                                <p class="card-text">This is the first announcement.</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Footer Section -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="text-center"><img src="assets/icons/Copyright.svg" class="footer-icon" alt="icon"
                                width="20" height="20">2025 NowUKnow Corp. All Rights Reserved</p>
                        <p class="text-center">
                            <a href="terms.php" class="footer-link">Terms of Services</a> |
                            <a href="privacy.php" class="footer-link">Privacy Policy</a> |
                            <a href="about.php" class="footer-link">About</a>
                        </p>
                    </div>
                </footer>
            </div>
        </div>

        <!-- modal create post -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #C9F6FF;">
                    <div class="modal-header">
                        <div class="card-header d-flex align-items-center p-1" style="border-color:white">
                            <img src="assets/imgs/pfp.jpg" class="profile-pic me-1">
                            <div>
                                <h6 class="mb-0 profile-text">jdoe</h6>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="title-text form-floating mb-5 p-0">
                            <input type="text" class="form-control text-wrap"
                                style="background-color: #C9F6FF; border-color: #C9F6FF;" id="floatingInput"
                                placeholder="Title">
                            <label for="floatingInput">Title</label>
                        </div>
                        <div class="body-text form-floating mb-4 p-0" style="height: auto; max-height: 500px;">
                            <input type="text" class="form-control"
                                style="height: 100px; text-align: start; background-color: #67D2E8;" id="floatingInput"
                                placeholder="Title">
                            <label for="floatingInput">Write Something...</label>
                        </div>
                        <div class="card d-flex flex-row justify-content-center align-items-center mx-auto p-3"
                            style="background-color: #C9F6FF; font-family: 'Helvetica Rounded';">
                            <div class="col-5 text-start ps-3">
                                <h6>Add Attachment(s)</h6>
                            </div>
                            <div class="col-7 ps-4 d-flex flex-row justify-content-center align-items-center">
                                <div class="pictureUpload mx-3">
                                    <img src="assets/icons/photo icon.svg">
                                </div>
                                <div class="videoUpload mx-3">
                                    <img src="assets/icons/video.svg">
                                </div>
                                <div class="fileUpload mx-3">
                                    <img src="assets/icons/file.svg">
                                </div>
                            </div>
                        </div>
                        <div class="addTags pt-3">
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="border-radius: 20px; font-family: 'Helvetica Rounded';">
                                    add tags
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="background-color: #67D2E8;"
                            onclick="window.location.href='index.php'">Post</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- JS Left column -->
    <script src="assets/js/leftcolumn.js"></script>
    <script src="assets/js/post.js"></script>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>