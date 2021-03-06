<?php
/**
 * Created by IntelliJ IDEA.
 * User: Steve
 * Date: 08/08/2016
 * Time: 21:48
 */
include_once 'handlers/dbconfig.php';

if($user->is_loggedin()=="")
{
    $user->redirect('login.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Summer Quotes - Control Panel</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link href="assets/css/styles.css" rel="stylesheet" media="screen">
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> <a class="navbar-brand" href="#">Brand</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav">

                        <!--           Navigation Bar             -->
                        <li>
                            <a href="Home.php">Home</a>
                        </li>

                        <li class="active">
                            <a href="controlPanel.php">Control Panel</a>
                        </li>

                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="#">Link</a>
                        </li>

                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>

                            <ul class="dropdown-menu">

                                <li>
                                    <a href="#">Option 1</a>
                                </li>

                                <li>
                                    <a href="#">Option 2</a>
                                </li>

                                <li>
                                    <a href="#">Option 3</a>
                                </li>

                                <li class="divider">

                                </li>

                                <li>
                                    <a href="handlers/logout.php">logout</a>
                                </li>

                            </ul>

                        </li>

                    </ul>

                </div>

            </nav>

            <div class="jumbotron">
                <script type="text/javascript">
                    var obj = <?php echo json_encode($php_variable); ?>;
                </script>

                <h2>
                    Hello, world!
                </h2>

                <p>
                    This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
                </p>

                <p>
                    <a class="btn btn-primary btn-large" href="#">Learn more</a>
                </p>

            </div>

        </div>

    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>