<?php
include_once '../srms.php';
//$_SESSION['username'] = 'testing';

if (!isset($_SESSION['username'])) {
    //echo "LOGIN TO ADMIN PORTAL";
    // login form
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <style>
            body {
                text-align: center;
            }

            input[type="text"]::placeholder,
            input[type="password"]::placeholder {
                text-align: center;
            }
        </style>
        <title> ADMIN PORTAL LOGIN </title>
    </head>

    <body>
        <!-- Navigation bar -->
        <nav class="navbar">
            <!-- LOGO -->
            <div class="logo"> LOGO </div>
            <!-- NAVIGATION MENU -->
            <div class="nav-links">
                <!-- USING CHECKBOX HACK -->
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger">&#9776;</label>
                <!-- NAVIGATION MENUS -->
                <div class="menu">
                    <a href="../index.php">Home</a>
                    <a href="../vision.php">Vision</a>
                    <a href="../faculty.php">Faculty</a>
                    <a href="../contact.php">Contact</a>
                    <a href="../result/index.php">SRMS</a>
                    <a class="active" href="index.php">Admin</a>
                </div>
            </div>
        </nav>

        <!-- Page Titile -->
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Admin Portal Login </h2>
        </div>
        <div>
            <form action="admin_login.php" method="post">
                <input type="text" name="username" required placeholder="USERNAME"><br>
                <input type="password" name="pwd" required placeholder="PASSWORD"><br>
                <input type="submit" name="login" value="LOGIN">
            </form>
        </div>
        <?php
        if (isset($_POST['login'])) {
            //echo "clicked login";
            $UserName = $_POST['username'];
            $PWD = $_POST['pwd'];
            //echo $UserName;

            $admin_query = "SELECT * FROM tbladmin WHERE userName ='" . $UserName . "'" . "AND password ='" . md5($PWD) . "'";
            $result = mysqli_query($connection, $admin_query);

            if (mysqli_num_rows($result) > 0) {
                //echo "Successful Login";
                session_start();
                $_SESSION['username'] = $UserName;
                $_SESSION['pwd'] = $PWD;
                header('Location:index.php');
            } else {
        ?>
                <script>
                    alert("Invalid Credentials, Please try again!");
                    window.location.href('admin_login.php');
                </script>
        <?php
            }
        }
        ?>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
<?php
}
?>