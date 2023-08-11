<?php
    session_start();
    $sessionId = $_SESSION['id'] ?? '';
    $sessionRole = $_SESSION['role'] ?? '';
    /* echo "$sessionId $sessionRole"; */
    if ( !$sessionId && !$sessionRole ) {
        header( "location:login.php" );
        die();
    }

    ob_start();

    include_once "config.php";
    $connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    if ( !$connection ) {
        echo mysqli_error( $connection );
        throw new Exception( "Database cannot Connect" );
    }
    if ( $sessionRole == "user"){
        $id = $_REQUEST['id'] ?? 'contact';
    }
    else{
        $id = $_REQUEST['id'] ?? 'searchItem';
    }
    $action = $_REQUEST['action'] ?? 'searchItem';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

     <!-- Favicons -->
    <link href="assets2/img/favicon.png" rel="icon">
    <link href="assets2/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets2/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets2/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets2/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets2/css/style.css" rel="stylesheet">

    <title>NGO</title>
</head>

<body>
    <!--------------------------------- Secondary Navber -------------------------------->
    <section class="topber">
        <div class="topber__title">
            <span class="topber__title--text">
                <?php
                    if ( 'donations' == $id ) {
                        echo "Donations";
                    } elseif ( 'addEvents' == $id ) {
                        echo "Add News and Events";
                    } elseif ( 'searchItem' == $id ) {
                        echo "Results";
                    } elseif ( 'dashboard' == $id ) {
                        echo "Dashboard";
                    } elseif ( 'allEvents' == $id ) {
                        echo "News and Events";
                    } elseif ( 'notification' == $id ) {
                        echo "Notifications";
                    } elseif ( 'addOrphans' == $id ) {
                        echo "Add Orphan";
                    } elseif ( 'updateOrphans' == $id ) {
                        echo "Orphans";
                    } elseif ( 'userProfile' == $id ) {
                        echo "Your Profile";
                    } elseif ( 'contact' == $id ) {
                        echo "Contact";
                    } elseif ( 'volunteer' == $id ) {
                        echo "Volunteers";
                    } elseif ( 'viewVolunteer' == $id ) {
                        echo "Volunteers";
                    } elseif ( 'feedbacks' == $id ) {
                        echo "Feedbacks";
                    } elseif ( 'queries' == $id ) {
                        echo "Queries";
                    } elseif ( 'donate' == $id ) {
                        echo "";
                    } elseif ( 'editEvents' == $action ) {
                        echo "Edit News and Event";
                    } elseif ( 'editPharmacist' == $action ) {
                        echo "Edit Pharmacist";
                    } elseif ( 'editSalesman' == $action ) {
                        echo "Edit Salesman";
                    }
                ?>

            </span>
        </div>

        <div class="topber__profile">
        <?php if ( 'admin' == $sessionRole ){?>
            <div class="header d-flex align-items-center" style="height:auto; margin-right:100px;padding:0%;margin-top:5px">
            <div class="search-bar" style="padding:0%">
            <form class="search-form d-flex align-items-center" method="POST" action="search.php">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <input type="hidden" name="action" value="searchItem">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
              </form>
            </div>
        </div>
          <?php }?>
        <?php
                
                $query = "SELECT name,role,avatar FROM {$sessionRole}s WHERE id='$sessionId'";
                $result = mysqli_query( $connection, $query );

                if ( $data = mysqli_fetch_assoc( $result ) ) {
                    $name = $data['name'];
                    $role = $data['role'];
                    $avatar = $data['avatar'];
                ?>
                <img src="assets/img/<?php echo "$avatar"; ?>" height="25" width="25" class="rounded-circle" alt="profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        echo "$name (" . ucwords( $role ) . " )";
                        }
                    ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php?id=userProfile">Profile</a>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </div>
        </div>
    </section>
    <!--------------------------------- Secondary Navber -------------------------------->


    <!--------------------------------- Sideber -------------------------------->
    <section id="sideber" class="sideber">
        <ul class="sideber__ber" style="padding:0px">
            <h3 class="sideber__panel"><!--<i id="left" class="fas fa-laugh"></i>--> NGO Management System</h3>
            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" style="margin-top: 20px;" class="sideber__item<?php if ( 'dashboard' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=dashboard"><i id="left" class="bi bi-grid"></i>Dashboard</a>
            </li><?php }?>
            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'donations' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=donations"><i id="left" class="fas fa-praying-hands"></i>View Donations</a>
            </li><?php }?>
            <!-- For User-->
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'contact' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=contact"><i id="left" class="fas fa-address-book"></i>Contact</a>
            </li><?php }?>

            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'viewVolunteer' == $id ) {
                echo " active";
            }?>">
                <a href="index.php?id=<?php echo $id ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" class="nav-link collapsed"> 
                    <i id="left" class="fas fa-dice-d20"></i>News & events<i class="bi bi-chevron-down ms-auto"></i> </a>
                    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sideber__item" style="margin-top:10px;color:white">
                    <li>
                        <a href="index.php?id=addEvents">
                        <i ></i><span>Add</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?id=allEvents">
                        <i></i><span>View</span>
                        </a>
                    </li>
                    </ul>
                    </li>
            <?php }?>

         
            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'viewVolunteer' == $id ) {
                echo " active";
            }?>">
                <a href="index.php?id=<?php echo $id ?>" data-bs-target="#charts-nav" data-bs-toggle="collapse" class="nav-link collapsed"> 
                    <i id="left" class="fas fa-people-carry"></i>Volunteer<i class="bi bi-chevron-down ms-auto"></i> </a>
                    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sideber__item" style="margin-top:10px;color:white">
                    <li>
                        <a href="index.php?id=viewVolunteer">
                        <i ></i><span>View</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?id=notification">
                        <i></i><span>Notification</span>
                        </a>
                    </li>
                    </ul>
                    </li>
            <?php }?>

               
                    
            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'orphans' == $id ) {
                echo " active";
            }?>">
            <a href="index.php?id=<?php echo $id ?>" class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse"> 
                <i id="left" class="fas fa-user"></i>Orphans<i class="bi bi-chevron-down ms-auto"></i> </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sideber__item" style="margin-top:10px;color:white">
                <li>
                    <a href="index.php?id=addOrphans">
                    <i ></i><span>Add Orphans</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?id=updateOrphans">
                    <i></i><span>View Orphans</span>
                    </a>
                </li>
                </ul>
                </li>
            <?php }?>

            <?php if ( 'user' != $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'viewVolunteer' == $id ) {
                echo " active";
            }?>">
                <a href="index.php?id=<?php echo $id ?>" data-bs-target="#icons-nav" data-bs-toggle="collapse" class="nav-link collapsed"> 
                    <i id="left" class="fas fa-pen-fancy"></i>Feedback & Query<i class="bi bi-chevron-down ms-auto"></i> </a>
                    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sideber__item" style="margin-top:10px;color:white">
                    <li>
                        <a href="index.php?id=feedbacks">
                        <i ></i><span>Feedbacks</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?id=queries">
                        <i></i><span>Queries</span>
                        </a>
                    </li>
                    </ul>
                    </li>
            <?php }?>


            <!-- For User-->
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'allEvents' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=allEvents"><i id="left" class="fas fa-dice-d20"></i>View News & Events</a>
            </li><?php }?>

            <!-- For User-->
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'feedback' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=feedback"><i id="left" class="fas fa-pen-square"></i>Feedback</a>
            </li><?php }?>

            <!-- For User-->
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'volunteer' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=volunteer"><i id="left" class="fas fa-user-plus"></i>Apply for Volunteer</a>
            </li><?php }?>

            <!-- For User-->
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" class="sideber__item<?php if ( 'donate' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=donate"><i id="left" class="fas fa-praying-hands"></i>Donate</a>
            </li><?php }?>

        </ul>
        <footer class="text-center"><span></span><br></footer>
    </section>
    <!--------------------------------- #Sideber -------------------------------->

    <!--------------------------------- #Main section -------------------------------->
    <section class="main">
        <div class="container">
    <div class="manager" style="margin-top:50px">

    <section  class="section" >
            <?php if (( 'admin' == $sessionRole  ) ) {?>
                    <?php
                                         $orphanNumber = $_REQUEST['query'] ?? '';
                                         $getOrphan = "SELECT * FROM orphans where number='$orphanNumber'";
                                            $result = mysqli_query( $connection, $getOrphan );

                                        while ( $orphan = mysqli_fetch_assoc( $result ) ) {?>

                    <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="col col-12 text-center pb-3" style="padding-top:5px;"><?php printf( "%s", $orphan['number']);?></div>
                        <div style="width:450px; margin-left:60px">
                            <img src="uploads/<?php echo $orphan['photo']; ?>" class="d-block w-100" alt="..." style="width:min-content">
                        </div>
                        <h5 class="card-title" style="padding-bottom:0%">Name: <?php printf( "%s", $orphan['name']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Age: <?php printf( "%s", $orphan['age']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Gender: <?php printf( "%s", $orphan['gender']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Disability: <?php printf( "%s", $orphan['disability']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Guardian Name: <?php printf( "%s", $orphan['gname']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Contact: <?php printf( "%s", $orphan['gcontact']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Address: <?php printf( "%s", $orphan['gaddress']);?></h5>
                        <?php if ( 'admin' == $sessionRole ) {?>
                            <h5><?php printf( "<a href='index.php?action=editOrphan&id=%s'><i class='fas fa-edit'></i> Edit</a>", $orphan['id'] )?></h5>
                            <h5><?php printf( "<a class='delete' href='index.php?action=deleteOrphan&id=%s'><i class='fas fa-trash'></i> Delete</a>", $orphan['id'] )?></h5>
                        <?php }?>
                        <?php if ( 'no' == $orphan['adopted'] ) {?>
                            <h5  style="margin-left:470px;margin-bottom:10px"><?php printf( "<a href='index.php?action=adopt&id=%s'><i class='fas fa-ankh'></i> Adopt</a>", $orphan['id'] )?></h5>
                        <?php } ?>
                        <?php if ( 'yes' == $orphan['adopted'] ) {?>
                            <h5  style="margin-left:450px;margin-bottom:10px"><?php printf( "<a href='index.php?action=adopterDetails&id=%s'><i class='fas fa-shekel-sign'></i> Adopted</a>", $orphan['id'] )?></h5>
                        <?php } ?>
                     </div>
                     </div>
                    </div>
                    <?php }?>
                <?php }?>
                </section>
    </div>
        </div>
    </section>

    <!--------------------------------- #Main section -------------------------------->



    <!-- Optional JavaScript -->
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom Js -->
    <script src="./assets/js/app.js"></script>                                
    
    <!-- Vendor JS Files -->
    <script src="assets2/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets2/vendor/chart.js/chart.umd.js"></script>
    <script src="assets2/vendor/echarts/echarts.min.js"></script>
    <script src="assets2/vendor/quill/quill.min.js"></script>
    <script src="assets2/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets2/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets2/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets2/js/main.js"></script>

</body>

</html>