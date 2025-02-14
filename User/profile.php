<?php
session_start();
include("../assets/shared/connect.php");

$error = "";

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['userID'];

$selectQuery = "SELECT * FROM users WHERE userID = '$user_id'";
$userResult = mysqli_query($conn, $selectQuery);
$user = mysqli_fetch_assoc($userResult);

if (isset($_POST['btnUpdateProfile'])) {
    $username = $_POST['username']; 
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password'];
    $userID = (int)$_SESSION['userID']; 

    if ($password !== $confirm_password) {
        die("Passwords do not match. Please try again.");
    }

    $profilePicture = $_FILES['profilePicture']['name'];
    $profilePictureTmp = $_FILES['profilePicture']['tmp_name'];
    $coverPhoto = $_FILES['coverPhoto']['name'];
    $coverPhotoTmp = $_FILES['coverPhoto']['tmp_name'];

    $uploadDir = "uploads/";
    if (!empty($profilePicture)) {
        move_uploaded_file($profilePictureTmp, $uploadDir . $profilePicture);
    }
    if (!empty($coverPhoto)) {
        move_uploaded_file($coverPhotoTmp, $uploadDir . $coverPhoto);
    }

    $updateQuery = "UPDATE users SET 
                    userName = '$username', 
                    firstName = '$firstname', 
                    lastName = '$lastname', 
                    email = '$email', 
                    password = '$password', 
                    birthday = '$birthday', 
                    phoneNumber = '$phone', 
                    profilePicture = IF('$profilePicture' != '', '$profilePicture', profilePicture), 
                    coverPhoto = IF('$coverPhoto' != '', '$coverPhoto', coverPhoto) 
                    WHERE userID = $userID";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

if (isset($_GET['followedID'])) {
    $followedID = mysqli_real_escape_string($conn, $_GET['followedID']);
} elseif (isset($_SESSION['userID'])) {
    $followedID = $_SESSION['userID'];
} else {
    die("Error: User ID not provided.");
}

$followersQuery = "SELECT COUNT(*) as totalFollowers FROM follows WHERE followedID = '$followedID'";
$followersResult = mysqli_query($conn, $followersQuery);

if ($followersResult) {
    $followersData = mysqli_fetch_assoc($followersResult);
    $totalFollowers = $followersData['totalFollowers'];
} else {
    $totalFollowers = 0; 
    echo "Error fetching followers: " . mysqli_error($conn) . "<br>";
}

$followerText = ($totalFollowers === 1) ? "follower" : "followers";

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

    .create-post-button {
        position: absolute;
        bottom: 50px;
        right: 50px;
    }

    @media (max-width: 768px) {
        .profile-dropdown {
            top: 10px;
            right: 20px;
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
                            <a href="index.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-house nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="User/profile.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-user nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="explore.php"
                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #06080F;">
                                <i class="fa-solid fa-hashtag nav-icon" style="font-size: 24px; color: #06080F;"></i>
                                <span class="nav-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px;">Tags</span>
                            </a>
                        </li>
                        <li>
                            <a href="notif.html"
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
            <!-- User Profile -->
            <div class="col-md-6 middle-column">
                <div class="middle-search-bar">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <div class="profile-container col-md-12">
                    <div class="profile-section position-relative">
                    <div class="background">
                        <?php
                        $coverPhotoPath = "uploads/" . $user['coverPhoto'];
                        if (file_exists($coverPhotoPath) && !empty($user['coverPhoto'])) {
                            echo '<img src="' . $coverPhotoPath . '" alt="Cover Photo">';
                        } else {
                            echo "<!-- Cover photo not found or missing in database -->";
                            echo "CoverPhoto not found!";
                        }
                        ?>
                    </div>
                    <div class="profile-pic1" style="margin-top: -85px;">
                        <?php
                        $profilePicturePath = "uploads/" . $user['profilePicture'];
                        if (file_exists($profilePicturePath) && !empty($user['profilePicture'])) {
                            echo '<img src="' . $profilePicturePath . '" alt="Profile Picture" style="width: 150px; border-radius: 50%;">';
                        } else {
                            echo "<!-- Profile picture not found or missing in database -->";
                            echo "ProfilePicture not found!";
                        }
                        ?>
                    </div>


                        <div class="prof-edit-delete pt-8 text-end">
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="border-radius: 20px; font-family: 'Helvetica Rounded'; border-color: #FFFF; background-color: #FFFF; color: #808080;">
                                    <span class="ellipsis">...</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">Delete Account</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="profile-info">
                            <div class="profile-data">
                                <!-- Dynamically display user information -->
                                <h1 class="fullname mt-3"><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></h1>
                                <h2 class="username">@<?php echo $user['userName']; ?></h2>
                                <p><?php echo $totalFollowers; ?> followers</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!--Posts-->
                <div class="posts-section">
                    <h3>User Posts</h3>
                </div>

                    <div class="container">
                        <div class="card custom-card">
                            <!-- user -->
                            <div class="card-header d-flex align-items-center p-3" style="border-color:white">
                                <img src="../assets/imgs/pfp.jpg" class="profile-pic me-1">
                                <div>
                                    <h6 class="mb-0 profile-text">jdoe</h6>
                                </div>
                                <div>
                                    <button class="btn btn-primary ms-1 follow-btn">Follow</button>
                                </div>
                                <div class="ms-auto d-flex align-items-center">
                                    <button class="btn maximize-btn" data-bs-toggle="modal"
                                        data-bs-target="#cardModal"><img src="../assets/icons/maximize.svg"></button>
                                </div>
                            </div>
                            <!-- uploaded media -->
                            <img src="../assets/imgs/test.jpg" class="card-img-top">
                            <!-- body -->
                            <div class="card-body">
                                <h2 class="card-text title-text p-1">Title</h2>
                                <p class="card-text body-text px-2">Lorem ipsum dolor, sit amet consectetur adipisicing
                                    elit.
                                    Blanditiis veniam
                                    at ipsum, voluptatem dignissimos laboriosam accusantium, deserunt expedita
                                    voluptatum
                                    voluptate architecto magni, rem quas quia. Temporibus sint suscipit ut aliquid!</p>

                                <button class="btn btn-primary follow-btn ms-1 mt-0 mb-2"
                                    style="background-color: #808080;">#quote</button>
                                <!-- bottom buttons -->
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <span class="bottom-buttons icon-button" data-bs-toggle="modal"
                                            data-bs-target="#cardModal">
                                            <img src="../assets/icons/comment.svg" class="me-1">Comments
                                        </span>
                                        <span class="bottom-buttons icon-button" onclick="toggleActive(this)">
                                            <img src="../assets/icons/bookmark2.svg" class="me-1">Bookmark
                                        </span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="star" onclick="setRating(1)">
                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                        </div>
                                        <div class="star" onclick="setRating(2)">
                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                        </div>
                                        <div class="star" onclick="setRating(3)">
                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                        </div>
                                        <div class="star" onclick="setRating(4)">
                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                        </div>
                                        <div class="star" onclick="setRating(5)">
                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal large view with edit/delete button -->
                        <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="background-color: transparent; border: none;">
                                    <div class="modal-body">
                                        <div class="card custom-card">
                                            <!-- user -->
                                            <div class="card-header d-flex align-items-center p-3"
                                                style="border-color:white">
                                                <img src="../assets/imgs/pfp.jpg" class="profile-pic me-1">
                                                <div>
                                                    <h6 class="mb-0 profile-text">jdoe</h6>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary ms-1 follow-btn">Follow</button>
                                                </div>

                                                <div class="ms-auto d-flex align-items-center" data-bs-dismiss="modal">
                                                    <button class="btn maximize-btn"><img
                                                            src="../assets/icons/minimize.svg"></button>
                                                </div>
                                            </div>
                                            <!-- uploaded media -->
                                            <img src="../assets/imgs/test.jpg" class="card-img-top">
                                            <!-- body -->
                                            <div class="card-body">
                                                <h2 class="card-text title-text p-1">Title</h2>
                                                <div class="modal-body">
                                                    <p class="card-text body-text px-2">Lorem ipsum dolor sit amet
                                                        consectetur adipisicing elit. Commodi laboriosam eveniet at
                                                        omnis in
                                                        harum sit nesciunt quod eos molestiae dolores provident hic
                                                        eaque,
                                                        magni architecto dolorem tempore consectetur vitae.</p>
                                                </div>


                                                <button class="btn btn-primary follow-btn ms-1 mt-0 mb-2"
                                                    style="background-color: #808080;">#quote</button>
                                                <!-- bottom buttons -->
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <span class="bottom-buttons icon-button"
                                                            onclick="toggleCommentInput(this)">
                                                            <img src="../assets/icons/comment.svg" class="me-1">Comment
                                                        </span>
                                                        <span class="bottom-buttons icon-button"
                                                            onclick="toggleActive(this)">
                                                            <img src="../assets/icons/bookmark2.svg"
                                                                class="me-1">Bookmark
                                                        </span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <button class="btn btn-primary follow-btn me-2 button-text"
                                                            style="background-color: #B23B3B;"><img
                                                                src="../assets/icons/delete2.svg">Delete</button>
                                                        <button class="btn btn-primary follow-btn me-2 button-text"
                                                            style="background-color: #7091E6;"><img
                                                                src="../assets/icons/edit2.svg">Edit</button>

                                                        <div class="star" onclick="setRating(1)">
                                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                                        </div>
                                                        <div class="star" onclick="setRating(2)">
                                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                                        </div>
                                                        <div class="star" onclick="setRating(3)">
                                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                                        </div>
                                                        <div class="star" onclick="setRating(4)">
                                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                                        </div>
                                                        <div class="star" onclick="setRating(5)">
                                                            <img src="../assets/icons/star.svg" class="me-1 star-icon">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- collapsible comment -->
                                            <div class="comment-input-container" style="background-color:#C9F6FF">
                                                <form method="POST">
                                                    <div class="mb-3">
                                                        <textarea class="form-control body-text" name="comment" rows="5"
                                                            placeholder="Write a comment..."></textarea>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary my-1 ms-1">Comment</button>
                                                </form>
                                                <div>
                                                    <h5 class="body-text mt-5 ms-2" style="color: #808080;">Comments
                                                    </h5>
                                                </div>

                                                <!-- Comments Section -->
                                                <div class="comment-list text-break">
                                                    <div class="card comment-card mb-2 body-text">
                                                        <div class="comment-card-header d-flex align-items-center ms-3 mt-3"
                                                            style="border-color:white">
                                                            <img src="../assets/imgs/pfp.jpg" class="profile-pic me-1">
                                                            <div>
                                                                <h6 class="mb-0 profile-text">jdoe</h6>
                                                            </div>
                                                        </div>
                                                        <p class="ms-5 me-3 p-2">Lorem ipsum dolor sit amet consectetur
                                                            adipisicing elit.
                                                            Laboriosam atque voluptates odit asperiores delectus. Nisi
                                                            fugit, quam pariatur magni quod nostrum, minus eaque,
                                                            reiciendis magnam quo aut ipsum tempora architecto?</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                
                <!-- Create Post Button -->
                <div class="me-3">
                    <div class="create-post-button">
                        <button class="btn-create-post" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img src="../assets/icons/edit.svg" alt="Icon" class="button-icon"> Create Post
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
                        <p class="text-center"><img src="../assets/icons/Copyright.svg" class="footer-icon" alt="icon"
                                width="20" height="20">2025 NowUKnow Corp. All Rights Reserved</p>
                        <p class="text-center">
                            <a href="terms.php" class="footer-link">Terms of Services</a> |
                            <a href="privacy.php" class="footer-link">Privacy Policy</a> |
                            <a href="about.php" class="footer-link">About</a>
                        </p>
                    </div>
                </footer>
            </div>
            <!-- Create post modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #C9F6FF;">
                        <div class="modal-header">
                            <div class="card-header d-flex align-items-center p-1" style="border-color:white">
                                <img src="../assets/imgs/pfp.jpg" class="profile-pic me-1">
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
                                <textarea class="form-control"
                                    style="height: 150px; text-align: start; background-color: #67D2E8;"
                                    id="floatingInput" placeholder="Title"></textarea>
                                <label for="floatingInput">Write Something...</label>
                            </div>
                            <div class="card d-flex flex-row justify-content-center align-items-center mx-auto p-3"
                                style="background-color: #C9F6FF; font-family: 'Helvetica Rounded';">
                                <div class="col-5 text-start ps-3">
                                    <h6>Add Attachment(s)</h6>
                                </div>
                                <div class="col-7 ps-4 d-flex flex-row justify-content-center align-items-center">
                                    <div class="pictureUpload mx-3">
                                        <label for="pictureInput">
                                            <img src="../assets/icons/photo icon.svg" style="cursor: pointer">
                                        </label>
                                        <input type="file" id="pictureInput" name="pictureFile"
                                            class="form-control d-none" accept=".png, .jpg">
                                    </div>
                                    <div class="videoUpload mx-3">
                                        <label for="videoInput">
                                            <img src="../assets/icons/video.svg" style="cursor: pointer">
                                        </label>
                                        <input type="file" id="videoInput" name="videoFile" class="form-control d-none"
                                            accept=".mp4, .mov">
                                    </div>
                                    <div class="fileUpload mx-3">
                                        <label for="fileInput">
                                            <img src="../assets/icons/file.svg" style="cursor: pointer">
                                        </label>
                                        <input type="file" id="fileInput" name="fileUpload" class="form-control d-none"
                                            accept=".pdf, .doc, .docx">
                                    </div>
                                </div>
                            </div>
                            <!-- dropdown tags -->
                            <div class="addTags pt-3">
                                <div class="dropdown" style="width: 30%; margin-bottom: 20px;">
                                    <select class="form-select" id="tagsType"
                                        style="border-radius: 20px; font-family: 'Helvetica Rounded'; background-color: #81c9ed;; color: rgb(64, 59, 59);">
                                        <option selected>add tags</option>
                                        <option value="1">#Action</option>
                                        <option value="2">#Action1</option>
                                        <option value="3">#Action3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="background-color: #67D2E8;"
                                    onclick="window.location.href='index.html'">Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header" style= "background-color: #D5E8F9;">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style= "background-color: #E7F0F9;">
                                <form id="editProfileForm" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="username2">Username</label>
                                        <input type="text" class="form-control" id="username2" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname2">First Name</label>
                                        <input type="text" class="form-control" id="firstname2" name="firstname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname2">Last Name</label>
                                        <input type="text" class="form-control" id="lastname2" name="lastname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email2">Email</label>
                                        <input type="email" class="form-control" id="email2" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone2">Phone Number</label>
                                        <input type="text" class="form-control" id="phone2" name="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday2">Birthday</label>
                                        <input type="date" class="form-control" id="birthday2" name="birthday" required
                                        placeholder="DD/MM/YYYY"
                                        required pattern="\d{2}/\d{2}/\d{4}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password2">New Password</label>
                                        <input type="password" class="form-control" id="password2" name="password" required
                                        pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$"
                                        title="Password must be at least 8 characters long, contain at least one letter, one number, and one special character (!@#$%^&*).">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password2">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password2" name="confirm_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="profilePicture2">Profile Picture</label>
                                        <input type="file" class="form-control" id="profilePicture2" name="profilePicture">
                                    </div>
                                    <div class="form-group">
                                        <label for="coverPhoto2">Cover Photo</label>
                                        <input type="file" class="form-control" id="coverPhoto2" name="coverPhoto">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer" style= "background-color: #D5E8F9;">
                                <button type="submit" name="btnUpdateProfile" class="btn btn-primary" form="editProfileForm">Save Changes</button>
                                <button type="button" class="btn btn-primary btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Delete Account Modal -->
<div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #f8f9fa;">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfileModalLabel">Delete Account</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-secondary" data-bs-dismiss="modal">No</button>
                <!-- Form to handle deletion -->
                <form action="deleteProfile.php" method="GET">
                    <!-- Pass userID dynamically from session -->
                    <input type="hidden" name="delete_user" value="<?php echo $_SESSION['userID']; ?>">
                    <input type="hidden" name="confirm_delete" value="yes">
                    <button type="submit" class="btn btn-primary btn-danger">Yes, Delete Permanently</button>
                </form>
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