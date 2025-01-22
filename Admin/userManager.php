<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
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

        .logo {
            margin-left: 30px;
        }

        .nav-title {
            margin-left: 35px;
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
            <div class="hamburger-btn" onclick="document.querySelector('.left-column').classList.toggle('show')">&#9776;
            </div>

            <!-- Left Column (Sidebar) -->
            <div class="col-md-3 left-column">
                <div class="logo">
                    <img src="../assets/icons/wordMark big.svg" alt="NowUKnow Logo" width="100" height="100" />
                </div>
                <div class="sidebar">
                    <ul>
                        <li><a href="index.php"><span class="nav-title">Dashboard</span></a></li>
                        <li><a href="userManager.php"><span class="nav-title">User Manager</span></a></li>
                        <li><a href="userList.php"><span class="nav-title">User List</span></a></li>
                    </ul>
                </div>
                <div class="logout-container">
                    <form action="../login.php" method="POST">
                        <button type="submit" class="btn-logout">Log Out</button>
                    </form>
                </div>
            </div>

            <!-- Right -->
            <div class="col-md-9 right-column">
                <nav class="custom-navbar">
                    <div class="container-fluid d-flex align-items-center justify-content-between">
                        <span class="nav-title">User Manager</span>
                        <form class="search-form" role="search">
                            <div class="input-group rounded-search">
                                <span class="input-group-text search-icon">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control search-input" placeholder="Search"
                                    aria-label="Search" />
                            </div>
                        </form>
                    </div>
                </nav>

                <div class="container">
                    <div class="header-title mt-3">@jdoe</div>
                    <div class="users-section">
                        <h2>Users</h2>
                        <div class="user-card">
                            <img src="../assets/imgs/pfp.jpg" alt="Profile Picture">
                            <div class="user-info">
                                <h6>John Doe</h6>
                                <p>@jdoe</p>
                            </div>
                            <button class="btn btn-danger follow-btn">Delete</button>
                        </div>
                        <div class="user-card">
                            <img src="../assets/imgs/pfp.jpg" alt="Profile Picture">
                            <div class="user-info">
                                <h6>John Doe</h6>
                                <p>@jdoe</p>
                            </div>
                            <button class="btn btn-danger follow-btn">Delete</button>
                        </div>
                       
                        <div class="users-section">
                            <h2>Posts</h2>
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
                                    <div class="card-body p-5">
                                        <h2 class="card-text title-text p-1">Title</h2>
                                        <p class="card-text body-text px-2">Lorem ipsum dolor, sit amet consectetur adipisicing
                                            elit.
                                            Blanditiis veniam
                                            at ipsum, voluptatem dignissimos laboriosam accusantium, deserunt expedita
                                            voluptatum
                                            voluptate architecto magni, rem quas quia. Temporibus sint suscipit ut aliquid!</p>
        
                                        <button class="btn btn-primary follow-btn ms-1 mt-0 mb-2"
                                            style="background-color: #808080; margin-right: auto;">#quote</button>
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
                                                            style="background-color: #808080; margin-right: auto;">#quote</button>
                                                        <!-- bottom buttons -->
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex">
                                                                <span class="bottom-buttons icon-button"
                                                                    onclick="toggleCommentInput(this)">
                                                                    <img src="../assets/icons/comment.svg" class="me-1">Comment
                                                                </span>
                                                                <span class="bottom-buttons icon-button"
                                                                    onclick="toggleActive(this)">
                                                                    <img src="../assets/icons/bookmark2.svg" class="me-1">Bookmark
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- JS Post -->
     <script src="../assets/js/post.js"></script>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>