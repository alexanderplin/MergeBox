<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                    </div>
                    <div class="logo-element">
                        MB
                    </div>
                </li>
                <li>
                    <a href="index.php"><i class="fa fa-folder-o"></i> <span class="nav-label">Files</span></a>
                </li>
                <li id="Accounts">
                        <a href="transfer.php"><i class="fa fa-sitemap"></i> <span class="nav-label">Accounts </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a>Dropbox <span class="fa arrow"></span></a>
                                <ul id="Dropbox" data-service = "1" class="nav nav-third-level">
                                    <?php
                                        $id = $_SESSION['id'];
                                        $row = query("SELECT * FROM service_accounts WHERE (user_id = $id AND service_name = 1)"); 
                                        foreach ($row as $rows) 
                                        {
                                            $email = $rows['service_email'];
                                            $serviceid = $rows['id'];
                                            echo "<li class=\"toggle\">
                                                    <a data-account = \"$serviceid\">$email</a>
                                                    </li>";
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li>
                                <a>Google Drive <span class="fa arrow"></span></a>
                                <ul id="GoogleDrive" data-service = "3" class="nav nav-third-level">
                                    <?php
                                        $id = $_SESSION['id'];
                                        $row = query("SELECT * FROM service_accounts WHERE (user_id = $id AND service_name = 3)"); 
                                        foreach ($row as $rows) 
                                        {
                                            $email = $rows['service_email'];
                                            $serviceid = $rows['id'];
                                            echo "<li class=\"toggle\">
                                                    <a data-account = \"$serviceid\">$email</a>
                                                    </li>";
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Box <span class="fa arrow"></span></a>
                                <ul id="Box" class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <li>
                        <a href="link.php"><i class="fa fa-link"></i> <span class="nav-label">Link Accounts</span></a>
                    </li>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <script>
            $('#Accounts').click(
                function(){
                    if(!(window.location.pathname == "/transfer.php"))
                    {
                        window.location = "transfer.php";
                    }
                }
            );

            $('.navbar-minimalize').click(function () {
                $("body").toggleClass("mini-navbar");
                SmoothlyMenu();
                $.post("ajax_handler.php", {
                        action: "collapse_sidebar"
                    });
            });
        </script>