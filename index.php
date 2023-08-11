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
        $id = $_REQUEST['id'] ?? 'userHome';
    }
    else{
        $id = $_REQUEST['id'] ?? 'dashboard';
    }
    $action = $_REQUEST['action'] ?? '';
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
                    } elseif ( 'dashboard' == $id ) {
                        echo "Dashboard";
                    } elseif ( 'userHome' == $id ) {
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
                    } elseif ( 'feedback' == $id ) {
                      echo "Feedback";
                    } elseif ( 'queries' == $id ) {
                        echo "Queries";
                    } elseif ( 'donate' == $id ) {
                        echo "Donation";
                      } elseif ( 'adopt' == $action ) {
                        echo "Adopt";
                    } elseif ( 'editEvents' == $action ) {
                        echo "Edit News and Event";
                   } elseif ( 'adopterDetails' == $action ) {
                    echo "Adopter Details";
                }
                ?>

            </span>
        </div>

        <div class="topber__profile">
          <?php if ( 'updateOrphans' == $id && 'admin' == $sessionRole ){?>
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
            <?php if ( 'user' == $sessionRole ) {?>
            <li id="left" style="margin-top: 20px;" class="sideber__item<?php if ( 'userHome' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=userHome"><i id="left" class="bi bi-grid"></i>Dashboard</a>
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

    <!--------------------------------- adminHome -------------------------------->
    <?php if ( 'dashboard' == $id && 'admin' == $sessionRole  ) {?>
    <main id="main" class="main" style="align-items:center">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html"></a></li>
      <li class="breadcrumb-item active"></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <div class="col-lg-8">
      <div class="row">

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <?php $totalUsers="select * from users;"; 
               if ($result = mysqli_query($connection, $totalUsers )) {?>
              <h5 class="card-title">Total Users</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-user"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $rowcount = mysqli_num_rows( $result ); echo $rowcount ;?></h6>

                </div>
              </div>
              <?php } ?>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card ">

            <div class="card-body align-items-center">
            <?php $totalVolunteers="select * from volunteers where accepted='yes';"; 
               if ($volunteers = mysqli_query($connection, $totalVolunteers )) {?>
              <h5 class="card-title">Total Volunteers</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-users"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $vc = mysqli_num_rows( $volunteers ); echo $vc ;?></h6>
                </div>
              </div>
              <?php } ?>
            </div>

          </div>
        </div>


        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body align-items-center">
            <?php $totalOrphans="select * from orphans;"; 
               if ($orphans = mysqli_query($connection, $totalOrphans )) {?>
              <h5 class="card-title">Total Orphans</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-user"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $oc = mysqli_num_rows( $orphans ); echo $oc ;?></h6>

                </div>
              </div>
              <?php } ?>

            </div>
          </div>

        </div>

        

    <div class="col-12">
      <div class="row">

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <?php $totalOrphansA="select * from orphans where adopted='yes';"; 
               if ($resultA = mysqli_query($connection, $totalOrphansA )) {?>
              <h5 class="card-title">Orphans Adopted</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-ankh"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $rowcountA = mysqli_num_rows( $resultA ); echo $rowcountA ;?></h6>

                </div>
              </div>
              <?php } ?>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card ">

            <div class="card-body align-items-center">
            <?php $totalFeedbacks="select * from feedbacks;"; 
               if ($feedbacks = mysqli_query($connection, $totalFeedbacks )) {?>
              <h5 class="card-title">Feedbacks Received</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-pen"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $vc = mysqli_num_rows( $feedbacks ); echo $vc ;?></h6>
                </div>
              </div>
              <?php } ?>
            </div>

          </div>
        </div>


        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body align-items-center">
            <?php $totalOrphans="select * from donations;"; 
               if ($orphans = mysqli_query($connection, $totalOrphans )) {?>
              <h5 class="card-title">Donations Received</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fas fa-praying-hands"></i>
                </div>
                <div class="ps-3">
                  <h6><?php $oc = mysqli_num_rows( $orphans ); echo $oc ;?></h6>

                </div>
              </div>
              <?php } ?>

            </div>
          </div>
        </div>
    </div>
<div class="col-lg-6">
      <div class="card">

        <div class="card-body pb-0">
          <h5 class="card-title">Orphan Adoption Details </h5>

          <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              echarts.init(document.querySelector("#trafficChart")).setOption({
                tooltip: {
                  trigger: 'item'
                },
                legend: {
                  top: '5%',
                  left: 'center'
                },
                series: [{
                  name: 'Access From',
                  type: 'pie',
                  radius: ['40%', '70%'],
                  avoidLabelOverlap: false,
                  label: {
                    show: false,
                    position: 'center'
                  },
                  emphasis: {
                    label: {
                      show: true,
                      fontSize: '18',
                      fontWeight: 'bold'
                    }
                  },
                  labelLine: {
                    show: false
                  },
                  data: [
                    {
                      value: <?php $totalOrphans="select * from orphans where adopted='no';"; 
               if ($orphans = mysqli_query($connection, $totalOrphans )) {?>
  <?php $oc = mysqli_num_rows( $orphans ); echo $oc ;?>
              <?php } ?>,
                      name: 'Not Adopted'
                    },
                    {
                      value:     <?php $totalOrphans="select * from orphans where adopted='yes';"; 
               if ($orphans = mysqli_query($connection, $totalOrphans )) {?>
  <?php $oc = mysqli_num_rows( $orphans ); echo $oc ;?>
              <?php } ?>,
                      name: 'Adopted'
                    }
                  ]
                }]
              });
            });
          </script>

        </div>
      </div>
    </div><!-- End Right side columns -->

  </div>
</section>
    </main>
<?php }?>
    <!--------------------------------- adminHome -------------------------------->


    <!--------------------------------- Main section -------------------------------->
    <section class="main">
        <div class="container">

            <!-- ---------------------- DashBoard ------------------------ -->
            <?php if ( 'donations' == $id && 'admin' == $sessionRole  ) {?>
                    <div class="allEvents">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Occupation</th>
                                        <th scope="col">Income</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Mode</th>
                                        <?php if ( 'admin1' == $sessionRole ) {?>
                                            <!-- Only For Admin -->
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getDonations = "SELECT * FROM donations";
                                            $result = mysqli_query( $connection, $getDonations );

                                        while ( $donation = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td><?php printf( "%s", $donation['name']);?></td>
                                            <td><?php printf( "%s", $donation['email'] );?></td>
                                            <td><?php printf( "%s", $donation['contact'] );?></td>
                                            <td><?php printf( "%s", $donation['occupation'] );?></td>
                                            <td><?php printf( "%s", $donation['income'] );?></td>
                                            <td><?php printf( "%s", $donation['type'] );?></td>
                                            <td><?php printf( "%s", $donation['mode'] );?></td>
                                            <?php if ( 'admin1' == $sessionRole ) {?>
                                                <!-- Only For Admin -->
                                                <td><?php printf( "<a href='index.php?action=editEvents&id=%s'><i class='fas fa-edit'></i></a>", $donation['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteEvents&id=%s'><i class='fas fa-trash'></i></a>", $donation['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>
            <!-- ---------------------- DashBoard ------------------------ -->

            <!-- ---------------------- addOrphans ------------------------ -->
            <?php if ( 'addOrphans' == $id && 'admin' == $sessionRole  ) {?>
            <div class="main__form" style="padding:0%">                                   
            <div class="card">
            <div class="card-body">
              <h3 class="card-title">Enter Orphan Details</h3>

              <!-- Multi Columns Form -->
              <form class="row g-3" action="add.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-12">
                  <label for="number" class="form-label">Orphan Number</label>
                  <input type="text" class="form-control" name="number" required>
                </div>
                <div class="col-md-6">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6">
                  <label for="age" class="form-label">Age</label>
                  <input type="text" class="form-control" name="age" required>
                </div>
                <div class="col-12">
                    <label for="photo" class="form-label">Photo</label>
                    <input class="form-control" value="<?php echo $event['photo']; ?>" type="file" name="photo" required/>
                </div>

                <div class="col-md-4">
                  <label for="gender" class="form-label">Gender</label>
                  <select name="gender" class="form-select">
                    <option selected>Other</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="inputZip" class="form-label">Disability</label>
                  <input type="text" class="form-control" name="disability" required>
                </div>
                <div class="col-12">
                  <label for="gcontact" class="form-label">Guardian Name</label>
                  <input type="text" class="form-control" name="gname" placeholder="" required>
                </div>
                <div class="col-12">
                  <label for="gcontact" class="form-label">Phone</label>
                  <input type="text" class="form-control" name="gcontact" placeholder="" required>
                </div>
                <div class="col-12">
                  <label for="gcontact" class="form-label">Address</label>
                  <input type="text" class="form-control" name="gaddress" placeholder="" required>
                </div>
                <div class="col-12">
                  <label for="gcontact" class="form-label">Others</label>
                  <input type="text" class="form-control" name="others" placeholder="" required>
                </div>

                <input type="hidden" name="action" value="addOrphan">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
          </div>
          <?php }?>


            <!-- ---------------------- addOrphans ------------------------ -->

            <!-- ---------------------- userHome ------------------------ -->


                <?php if ( 'userHome' == $id && 'user' == $sessionRole ) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query( $connection, $query );
                    $data = mysqli_fetch_assoc( $result )
                ?>
                <div class="userProfiles">
                    <div class="main__forms myProfile" style="margin-top:270px;width:400px;margin-left:400px">
                            <div class="main__form--title myProfile__title text-center">
                            <section class="section contact" style="margin-top:0px;padding-top:0%">

                          <div class="row">

                              <div class="col-xl-12">
     
                            <div class="col-lg-12">
                            <div class="info-box card">
                                <h3><i class="fas fa-hand-paper">  Hey, <?php printf( "%s", $data['name']);?>!</h3></i>
                            </div>
                            </div>


                              </div>
                          </div>
                            </section>
                            </div>
                            
                    </div>
                    
                </div>
                
            <?php }?>
            <!-- ---------------------- userHome ------------------------ -->   

            <!-- ---------------------- queries ------------------------ -->     

            <?php if ( 'queries' == $id && 'admin' == $sessionRole  ) {?>
                    <div class="allEvents">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Query</th>

                                        <?php if ( 'admin1' == $sessionRole ) {?>
                                            <!-- Only For Admin -->
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getQuery = "SELECT * FROM queries";
                                            $result = mysqli_query( $connection, $getQuery );

                                        while ( $query = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td><?php printf( "%s", $query['name']);?></td>
                                            <td><?php printf( "%s", $query['email'] );?></td>
                                            <td><?php printf( "%s", $query['message'] );?></td>
                                            <?php if ( 'admin1' == $sessionRole ) {?>
                                                <!-- Only For Admin -->
                                                <td><?php printf( "<a href='index.php?action=editEvents&id=%s'><i class='fas fa-edit'></i></a>", $query['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteEvents&id=%s'><i class='fas fa-trash'></i></a>", $query['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <!-- ---------------------- queries ------------------------ -->     
            <!-- ---------------------- updateOrphans ------------------------ -->                                    
            <div class="manager" style="margin-top:50px">
           
            <section  class="section" style="display:flex; flex-direction:row; flex-wrap:wrap">
            
            <?php if (( 'updateOrphans' == $id && 'admin' == $sessionRole  ) ) {?>
                    <?php
                                        $getOrphan = "SELECT * FROM orphans";
                                            $result = mysqli_query( $connection, $getOrphan );

                                        while ( $orphan = mysqli_fetch_assoc( $result ) ) {?>

                    <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="col col-12 text-center pb-3" style="padding-top:5px;"><?php printf( "%s", $orphan['number']);?></div>
                        <div style="width:450px; margin-left:60px">
                            <img src="uploads/<?php echo $orphan['photo'];  ?>" class="d-block w-100" alt="..." style="width:min-content">
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
                            <h5  style="margin-left:450px;margin-bottom:10px"><?php printf( "<a href='index.php?action=adopterDetails&id=%s'><i class='fas fa-shekel-sign'></i> Adopted</a>", $orphan['number'] )?></h5>
                        <?php } ?>

                      </div>
                     </div>
                    </div>
                    <?php }?>
                <?php }?>
                </section>
            </div>
            <section  class="section" >
            <?php if (( 'adopterDetails' == $action && 'admin' == $sessionRole  ) ) {?>
                    <?php
                                         $orphanNumber = $_REQUEST['id'] ?? '';
                                         $getAdopter = "SELECT * FROM adopter where onumber='{$orphanNumber}'";
                                            $result = mysqli_query( $connection, $getAdopter );

                                        while ( $adopter = mysqli_fetch_assoc( $result ) ) {?>

                    <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title" style="padding-bottom:0%">Name: <?php printf( "%s", $adopter['name']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Contact: <?php printf( "%s", $adopter['contact']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Gender: <?php printf( "%s", $adopter['gender']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Age: <?php printf( "%s", $adopter['age']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Aadhar Number: <?php printf( "%s", $adopter['aadhar']);?></h5>
                        <?php if ( 'admin1' == $sessionRole ) {?>
                            <h5><?php printf( "<a href='index.php?action=editOrphan&id=%s'><i class='fas fa-edit'></i> Edit</a>", $orphan['id'] )?></h5>
                            <h5><?php printf( "<a class='delete' href='index.php?action=deleteOrphan&id=%s'><i class='fas fa-trash'></i> Delete</a>", $orphan['id'] )?></h5>
                       
                            <h5  style="margin-left:480px"><?php printf( "<a href='index.php?action=adopt&id=%s'><i class='fas fa-ankh'></i> Adopt</a>", $orphan['id'] )?></h5>
                            <?php }?>
                          </div>
                     </div>
                    </div>
                    <?php }?>
                <?php }?>
                </section>

                <?php if ( 'editOrphans' == $action && 'admin' == $sessionRole ) {
                        $orphanID = $_REQUEST['id'];
                        $selectOrphans = "SELECT * FROM orphans WHERE id='{$orphanID}'";
                        $result = mysqli_query( $connection, $selectOrphans );

                    $orphan = mysqli_fetch_assoc( $result );?>
                    <div class="main__form" style="padding:0%">                                   
                    <div class="card">
                    <div class="card-body">
                    <h3 class="card-title">Enter Orphan Details</h3>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="add.php" method="POST">
                        <div class="col-md-12">
                        <label for="number" class="form-label">Orphan Number</label>
                        <input type="text" class="form-control" name="number" value="<?php echo $orphan['number']; ?>" required>
                        </div>
                        <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $orphan['name']; ?>" required>
                        </div>
                        <div class="col-md-6">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" class="form-control" name="age" value="<?php echo $orphan['age']; ?>" required>
                        </div>
                        <div class="col-12">
                        <label for="photo" class="form-label">Image Name (optional)</label>
                        <input type="text" class="form-control" name="photo" value="<?php echo $orphan['photo']; ?>" placeholder="avatar.png">
                        </div>
                        <div class="col-12">
                        <label for="gcontact" class="form-label">Guardian Contact</label>
                        <input type="text" class="form-control" name="gcontact" value="<?php echo $orphan['gcontact']; ?>" placeholder="" required>
                        </div>
                        <div class="col-md-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option selected>Other</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        </div>
                        <div class="col-md-6">
                        <label for="inputZip" class="form-label">Disability</label>
                        <input type="text" class="form-control" name="disability" value="<?php echo $orphan['disability']; ?>" required>
                        </div>
                        <input type="hidden" name="action" value="addOrphan">
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                    </div>
                </div>
                </div>
                <?php }?>

            <?php if ( 'editOrphan' == $action && 'admin' == $sessionRole  ) {
                $orphanID = $_REQUEST['id'];
                        $selectOrphans = "SELECT * FROM orphans WHERE id='{$orphanID}'";
                        $result = mysqli_query( $connection, $selectOrphans );

                    $orphan = mysqli_fetch_assoc( $result );?>
                <div class="main__form" style="padding:0%">                                   
                <div class="card">
                <div class="card-body">
                <h3 class="card-title">Enter Orphan Details</h3>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="add.php" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                    <label for="number" class="form-label">Orphan Number</label>
                    <input type="text" class="form-control" name="number" value="<?php echo $orphan['number']; ?>" required>
                    </div>
                    <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $orphan['name']; ?>" required>
                    </div>
                    <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" name="age" value="<?php echo $orphan['age']; ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="photo" class="form-label">Photo</label>
                        <input class="form-control" value="<?php echo $event['photo']; ?>" type="file" name="photo" required/>
                    </div>

                    <div class="col-md-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-select" >
                        <option selected>Other</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                    </div>
                    <div class="col-md-6">
                    <label for="inputZip" class="form-label">Disability</label>
                    <input type="text" class="form-control" value="<?php echo $orphan['disability']; ?>" name="disability" required>
                    </div>
                    <div class="col-12">
                    <label for="gcontact" class="form-label">Guardian Name</label>
                    <input type="text" class="form-control" name="gname" value="<?php echo $orphan['gname']; ?>" placeholder="" required>
                    </div>
                    <div class="col-12">
                    <label for="gcontact" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="gcontact" value="<?php echo $orphan['gcontact']; ?>" placeholder="" required>
                    </div>
                    <div class="col-12">
                    <label for="gcontact" class="form-label">Address</label>
                    <input type="text" class="form-control" name="gaddress" value="<?php echo $orphan['gaddress']; ?>" placeholder="" required>
                    </div>
                    <div class="col-12">
                    <label for="gcontact" class="form-label">Others</label>
                    <input type="text" class="form-control" name="others" value="<?php echo $orphan['others']; ?>" placeholder="" required>
                    </div>

                    <input type="hidden" name="action" value="addOrphan">
                    <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Multi Columns Form -->

                </div>
            </div>
            </div>
            <?php }?>

            <?php if ( 'deleteOrphan' == $action ) {
                        $orphanID = $_REQUEST['id'];
                        $deleteorphans = "DELETE FROM orphans WHERE id ='{$orphanID}'";
                        $result = mysqli_query( $connection, $deleteorphans );
                        header( "location:index.php?id=updateOrphans" );
                }?>


        
            
            <!-- ---------------------- updateOrphans ------------------------ -->

            <!-- ---------------------- userAdopt ------------------------ -->

            <?php if ( 'adopt' == $action && 'admin' == $sessionRole  ) {?>
            <div class="main__form" style="padding:0%; margin-top:0px;" >                                   
            <div class="card">
            <div class="card-body">
              <h3 class="card-title">Enter Your Details</h3>
              <!-- Multi Columns Form -->
              <form class="row g-3" action="add.php"  enctype="multipart/form-data" method="POST">
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-12">
                  <label for="contact" class="form-label">Contact</label>
                  <input type="tel" id="psw" name="contact" class="form-control" pattern="\d{10}" title="Must contain 10 digits" required>
                </div>
                <div class="col-md-4">
                  <label for="gender" class="form-label">Gender</label>
                  <select name="gender" class="form-select">
                    <option selected>Other</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="age" class="form-label">Age</label>
                  <input type="text" class="form-control" name="age" id="psw" pattern="\d{1,3}" title="Enter valid Age" required>
                </div>
                <div class="col-md-12">
                  <label for="aadhar" class="form-label">Aadhar Number</label>
                  <input type="text" class="form-control" name="aadhar" id="psw" pattern="\d{12}" title="Enter valid Aadhar Number" required>
                </div>
                <div class="col-12">
                        <label for="photo" class="form-label">Aadhar Card</label>
                        <input class="form-control"  type="file" name="acard" required/>
                    </div>
                
                    <div class="col-12">
                        <label for="photo" class="form-label">Income Certificate</label>
                        <input class="form-control"  type="file" name="icard" required/>
                    </div>

                    <div class="col-12">
                        <label for="photo" class="form-label">PAN Card</label>
                        <input class="form-control"  type="file" name="pcard" required/>
                    </div>
                    <input type="hidden" name="orphanId" value="<?php echo $_REQUEST['id']; ?>">
                <input type="hidden" name="action" value="addAdopter">
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
          </div>
          <?php }?>
          <?php if ( 'adopted' == $action ) {
                        $orphanID = $_REQUEST['var'];
                        $updateQuery = "UPDATE orphans SET adopted='yes' WHERE id='{$orphanID}'";
                        $result = mysqli_query( $connection, $updateQuery );
                        header( "location:index.php?id=updateOrphans&action={$orphanID}" );
                }?>

          <!-- ---------------------- userAdopt ------------------------ -->

          <!-- ---------------------- Feedbacks ------------------------ -->    

          <?php if ( 'feedbacks' == $id && 'admin' == $sessionRole  ) {?>
                    <div class="allEvents">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">f1</th>
                                        <th scope="col">f2</th>
                                        <th scope="col">f3</th>
                                        <th scope="col">f4</th>
                                        <th scope="col">f5</th>
                                        <th scope="col">f6</th>
                                        <th scope="col">f7</th>
                                        <th scope="col">f8</th>
                                        <th scope="col">f9</th>
                                        <th scope="col">Other</th>
                                        <?php if ( 'admin1' == $sessionRole ) {?>
                                            <!-- Only For Admin -->
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getFeedbacks = "SELECT * FROM feedbacks";
                                            $result = mysqli_query( $connection, $getFeedbacks );

                                        while ( $feedback = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td><?php printf( "%s", $feedback['name']);?></td>
                                            <td><?php printf( "%s", $feedback['email'] );?></td>
                                            <td><?php printf( "%s", $feedback['f1'] );?></td>
                                            <td><?php printf( "%s", $feedback['f2'] );?></td>
                                            <td><?php printf( "%s", $feedback['f3'] );?></td>
                                            <td><?php printf( "%s", $feedback['f4'] );?></td>
                                            <td><?php printf( "%s", $feedback['f5'] );?></td>
                                            <td><?php printf( "%s", $feedback['f6'] );?></td>
                                            <td><?php printf( "%s", $feedback['f7'] );?></td>
                                            <td><?php printf( "%s", $feedback['f8'] );?></td>
                                            <td><?php printf( "%s", $feedback['f9'] );?></td>
                                            <td><?php printf( "%s", $feedback['other'] );?></td>
                                            <?php if ( 'admin1' == $sessionRole ) {?>
                                                <!-- Only For Admin -->
                                                <td><?php printf( "<a href='index.php?action=editEvents&id=%s'><i class='fas fa-edit'></i></a>", $feedback['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteEvents&id=%s'><i class='fas fa-trash'></i></a>", $feedback['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <!-- ---------------------- Feedbacks ------------------------ -->    

            <!-- ---------------------- viewVolunteer ------------------------ -->                                    

            <?php if ( 'viewVolunteers' == $id && 'admin' == $sessionRole  ) {?>
                    <div class="allVolunteers">
                        <div class="main__table">
                            <table class="table" style="width:max-content">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Occupation</th>
                                        <th scope="col">Working Hours</th>
                                        <th scope="col">Holidays</th>
                                        <th scope="col">Health Issues</th>
                                        <th scope="col">f1</th>
                                        <th scope="col">f2</th>
                                        <th scope="col">f3</th>
                                        <th scope="col">f4</th>
                                        <th scope="col">f5</th>
                                        <th scope="col">f6</th>
                                        <th scope="col">f7</th>
                                        <?php if ( 'admin1' == $sessionRole ) {?>
                                            <!-- Only For Admin -->
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getVolunteer = "SELECT * FROM volunteers where accepted='yes'";
                                        $result = mysqli_query( $connection, $getVolunteer );

                                        while ( $volunteer = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td><?php printf( "%s", $volunteer['name']);?></td>
                                            <td><?php printf( "%s", $volunteer['email'] );?></td>
                                            <td><?php printf( "%s", $volunteer['occupation'] );?></td>
                                            <td><?php printf( "%s", $volunteer['workingh'] );?></td>
                                            <td><?php printf( "%s", $volunteer['holidays'] );?></td>
                                            <td><?php printf( "%s", $volunteer['healthi'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f1'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f2'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f3'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f4'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f5'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f6'] );?></td>
                                            <td><?php printf( "%s", $volunteer['f7'] );?></td>
                                            <?php if ( 'admin1' == $sessionRole ) {?>
                                                <!-- Only For Admin -->
                                                <td><?php printf( "<a href='index.php?action=editEvents&id=%s'><i class='fas fa-edit'></i></a>", $volunteer['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteEvents&id=%s'><i class='fas fa-trash'></i></a>", $volunteer['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <div class="manager" style="margin-top:50px">
           
            <section  class="section" style="display:flex; flex-direction:row; flex-wrap:wrap">
            
            <?php if (( 'viewVolunteer' == $id && 'admin' == $sessionRole  ) ) {?>
                    <?php
                    $getVolunteer = "SELECT * FROM volunteers where accepted='yes'";
                    $result = mysqli_query( $connection, $getVolunteer );

                    while ( $volunteer = mysqli_fetch_assoc( $result ) ) {?>

                    <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="col col-12 text-center pb-3" style="padding-top:5px;"></div>
                        <div style="width:450px; margin-left:60px">
                            <img src="uploads/<?php echo $volunteer['photo'];  ?>" class="d-block w-100" alt="..." style="width:min-content">
                        </div>
                        <h5 class="card-title" style="padding-bottom:0%">Name: <?php printf( "%s", $volunteer['name']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Email: <?php printf( "%s", $volunteer['email']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Occupation: <?php printf( "%s", $volunteer['occupation']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Working Hours: <?php printf( "%s", $volunteer['workingh']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Holidays: <?php printf( "%s", $volunteer['holidays']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">Health Issues: <?php printf( "%s", $volunteer['healthi']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q1: <?php printf( "%s", $volunteer['f1']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q2: <?php printf( "%s", $volunteer['f2']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q3: <?php printf( "%s", $volunteer['f3']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q4: <?php printf( "%s", $volunteer['f4']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q5: <?php printf( "%s", $volunteer['f5']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q6: <?php printf( "%s", $volunteer['f6']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q7: <?php printf( "%s", $volunteer['f7']);?></h5>
                      </div>
                     </div>
                    </div>
                    <?php }?>
                <?php }?>
                </section>
            </div>
            
            <!-- ---------------------- viewVolunteer ------------------------ -->

            <!-- ---------------------- notification ------------------------ -->                                    
        <div class="manager" style="margin-top:50px">                                        
            <?php if ( 'notification' == $id && 'admin' == $sessionRole  ) {?>
                    <?php
                                        $getVolunteer = "SELECT * FROM volunteers where accepted='no' ";
                                            $result = mysqli_query( $connection, $getVolunteer );

                                        while ( $volunteer = mysqli_fetch_assoc( $result ) ) {?>
                    <section class="section">
                    <div class="row">
                    <div class="col-lg-6">


                    <div class="card">
                        <div class="card-body">
                        <div class="col col-12 text-center pb-3" style="padding-top:5px;"></div>
                        <div style="width:450px; margin-left:60px">
                            <img src="uploads/<?php echo $volunteer['photo'];  ?>" class="d-block w-100" alt="..." style="width:min-content">
                        </div>
                        <h5 class="card-title" style=";padding-bottom:0%">Name: <?php printf( "%s", $volunteer['name']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Email: <?php printf( "%s", $volunteer['email']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Occupation: <?php printf( "%s", $volunteer['occupation']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Working Hours: <?php printf( "%s", $volunteer['workingh']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Holidays: <?php printf( "%s", $volunteer['holidays']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">Health Issues: <?php printf( "%s", $volunteer['healthi']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q1: <?php printf( "%s", $volunteer['f1']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q2: <?php printf( "%s", $volunteer['f2']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q3: <?php printf( "%s", $volunteer['f3']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q4: <?php printf( "%s", $volunteer['f4']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q5: <?php printf( "%s", $volunteer['f5']);?></h5>
                        <h5 class="card-title" style="padding-top:0%;padding-bottom:0%">q6: <?php printf( "%s", $volunteer['f6']);?></h5>
                        <h5 class="card-title" style="padding-top:0%">q7: <?php printf( "%s", $volunteer['f7']);?></h5>
                        <?php if ( 'admin' == $sessionRole ) {?>
                        <h5><?php printf( "<a href='index.php?action=accept&id=%s'><i class='fas fa-check'></i> Accept</a>", $volunteer['id'] )?></h5>
                        <h5><?php printf( "<a class='delete' href='index.php?action=reject&id=%s'><i class='fas fa-times'></i> Reject</a>", $volunteer['id'] )?></h5>
                        <?php }?>
                    </div>
                     </div>
                    </div>
                    </div>
                    </section>
                    <?php }?>
                <?php }?>

                <?php if ( 'accept' == $action ) {
                        $volunteerID = $_REQUEST['id'];
                        $acceptVolunteer = "UPDATE volunteers SET accepted='yes' WHERE id='{$volunteerID}'";
                        $result = mysqli_query( $connection, $acceptVolunteer );
                        header( "location:index.php?id=notification" );
                }?>

                <?php if ( 'reject' == $action ) {
                        $volunteerID = $_REQUEST['id'];
                        $rejectVolunteer = "DELETE FROM volunteers WHERE id ='{$volunteerID}'";
                        $result = mysqli_query( $connection, $rejectVolunteer );
                        header( "location:index.php?id=notification" );
                }?>
        </div>
            
            <!-- ---------------------- notification ------------------------ -->

            <!-- ---------------------- Events ------------------------ -->
            <div class="manager" style="margin-top:50px">
            <section  class="section" style="display:flex; flex-direction:row; flex-wrap:wrap">
                <?php if ( 'allEvents' == $id ) {?>
                    <?php
                                        $getEvents = "SELECT * FROM events order by id desc";
                                            $result = mysqli_query( $connection, $getEvents );

                                        while ( $event = mysqli_fetch_assoc( $result ) ) {?>

                    <div class="col-lg-6">


                    <div class="card">
                        <div class="card-body">
                        <h3 class="card-title" style="padding-bottom:0%;font-size:x-large"><?php printf( "%s", $event['title']);?></h3>
                        <h5 class="card-title" style="padding-top:0px;color:black; padding-bottom:5px"><?php printf( "%s", $event['cdate']);?></h5>
                        <?php if ( 'nophoto' != $event['photo']){ ?>
                            <img src="uploads/<?php echo $event['photo']; ?>" class="d-block w-100" alt="..." style="margin-top:10px">
                        <?php } ?>
                        <p style="padding-top:10px;color:black;"><?php printf( "%s", $event['content']);?></p>
                        <?php if ( 'admin' == $sessionRole ) {?>
                            <!-- Only For Admin -->
                            <h5><?php printf( "<a href='index.php?action=editEvents&id=%s'><i class='fas fa-edit'></i> Edit</a>", $event['id'] )?></h5>
                            <h5><?php printf( "<a class='delete' href='index.php?action=deleteEvents&id=%s'><i class='fas fa-trash'></i> Delete</a>", $event['id'] )?></h5>
                        <?php }?>
                    </div>
                     </div>
                    </div>
                    <?php }?>
                <?php }?>
                </section>


                <?php if ( 'addEvents' == $id ) {?>
                <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container" >
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


                        <div class="card mb-3" style="width:500px">

                            <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Add News and Events</h5>
                            </div>

                            <form class="row g-3 needs-validation" action="add.php" method="POST" enctype="multipart/form-data">
                                <div class="col-12">
                                <label for="yourName" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="yourName" required>
                                <div class="invalid-feedback">Please, enter the title!</div>
                                </div>

                                <div class="col-12">
                                <label for="photo" class="form-label">Photo (optional)</label>
                                <input class="form-control" type="file" name="photo" value="" />
                                </div>

                                <div class="col-12">
                                <label for="phone" class="form-label">Content</label>
                                <textarea name="content" placeholder="Type here" class="form-control" style="height: 100px" required></textarea>
                                <div class="invalid-feedback">Please, enter the content</div>
                                </div>


                                <input type="hidden" name="action" value="addEvents">

                                <?php if ( isset( $_REQUEST['error'] ) ) {
                                        echo "<h5 class='text-center' style='color:red;'>Email already exists!</h5>";
                                }?>

                                <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Post</button>
                                </div>
                            </form>

                            </div>
                        </div>

                        </div>
                    </div>
                    </div>

                    </section>
                    <?php }?>

                

                <?php if ( 'editEvents' == $action ) {
                        $eventID = $_REQUEST['id'];
                        $selectManagers = "SELECT * FROM events WHERE id='{$eventID}'";
                        $result = mysqli_query( $connection, $selectManagers );

                    $event = mysqli_fetch_assoc( $result );?>
                    <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container" >
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


                        <div class="card mb-3" style="width:500px">

                            <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Add News and Events</h5>
                            </div>
                            <form class="row g-3 needs-validation" action="add.php" method="POST" enctype="multipart/form-data">
                                <div class="col-12">
                                <label for="yourName" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $event['title']; ?>" id="yourName" required>
                                <div class="invalid-feedback">Please, enter the title!</div>
                                </div>

                                <div class="col-12">
                                <label for="photo" class="form-label">Photo (optional)</label>
                                <input class="form-control" value="<?php echo $event['photo']; ?>" type="file" name="photo" />
                                </div>

                                <div class="col-12">
                                <label for="phone" class="form-label">Content</label>
                                <textarea name="content" placeholder="Type here" class="form-control" style="height: 100px" required><?php echo $event['content']; ?></textarea>
                                <div class="invalid-feedback">Please, enter the content</div>
                                </div>


                                <input type="hidden" name="action" value="updateEvents">
                                <input type="hidden" name="id" value="<?php echo $eventID; ?>">

                                <?php if ( isset( $_REQUEST['error'] ) ) {
                                        echo "<h5 class='text-center' style='color:red;'>Email already exists!</h5>";
                                }?>

                                <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Post</button>
                                </div>
                            </form>
                            </div>
                        </div>

                        </div>
                    </div>
                    </div>

                    </section>
                <?php }?>

            <?php if ( 'deleteEvents' == $action ) {
                        $eventID = $_REQUEST['id'];
                        $deleteEvents = "DELETE FROM events WHERE id ='{$eventID}'";
                        $result = mysqli_query( $connection, $deleteEvents );
                        header( "location:index.php?id=allEvents" );
                }?>
            </div>
            <!-- ---------------------- Events ------------------------ -->



            <!-- ---------------------- User contact ------------------------ -->
            <div class="salesman">
            <?php if ( 'contact' == $id ) {?>

            <section class="section contact" style="margin-top:0px;padding-top:0%">

            <div class="row gy-4">

                <div class="col-xl-6">

                <div class="row">
                    <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Address</h3>
                        <p>123 Random Street,<br>radnomdawodawo, 3232535022</p>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-telephone"></i>
                        <h3>Call Us</h3>
                        <p>+91 55895548855<br>+91 667825444541</p>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-envelope"></i>
                        <h3>Email Us</h3>
                        <p>info@example.com<br>contact@example.com</p>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-clock"></i>
                        <h3>Open Hours</h3>
                        <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                    </div>
                    </div>
                </div>
                
                </div>

               <div class="col-xl-6">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26836.49949204173!2d74.78158296468843!3d12.94653659549874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba351cb1e247f19%3A0x8cb26c939e3fe4ad!2sPanambur%20Beach!5e0!3m2!1sen!2sin!4v1686402587473!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-6" style="width:500px; margin-left:50px">
                <div class="card p-4" style="margin-top:0px">
                <h2 class="card-title text-center" style="font-size:x-large; padding-top:0px;">Need help?</h2>
                    <form action="add.php" method="post">
                    <div class="row gy-4">

                        <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="2" placeholder="Message" required></textarea>
                                       <input type="hidden" name="action" value="query">
                        </div>

                        <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="submit">Send Message</button>
                        </div>

                    </div>
                    </form>
                </div>  
        
            </div>

            </section>
            <?php }?>
            </div>
            <!-- ---------------------- User contact ------------------------ -->

            <!-- ---------------------- User Feedback ------------------------ -->
    
            <?php if ( 'feedback' == $id && 'user' == $sessionRole  ) {?>
            <div class="main__form" style="padding:0%;margin-top:0.2%">                                   
            <div class="card">
            <div class="card-body">
              <h2 class="card-title text-center" style="font-size:xx-large">Provide Feedback</h2>

              <!-- Multi Columns Form -->
              <form class="row g-3" action="add.php" method="POST">
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How would you rate the cleanliness and hygine of the orphanage?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f1" id="gridRadios1" value="Excellent" checked>
                      <label class="form-check-label" for="gridRadios1">
                        Excellent
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f1" id="gridRadios2" value="Good">
                      <label class="form-check-label" for="gridRadios2">
                        Good
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f1" id="gridRadios3" value="Average">
                      <label class="form-check-label" for="gridRadios3">
                        Average
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f1" id="gridRadios4" value="Poor">
                      <label class="form-check-label" for="gridRadios4">
                        Poor
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How would you rate the quality of education provided to the children?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f2" id="gridRadios5" value="Excellent" checked>
                      <label class="form-check-label" for="gridRadios5">
                        Excellent
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f2" id="gridRadios6" value="Good">
                      <label class="form-check-label" for="gridRadios6">
                        Good
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f2" id="gridRadios7" value="Average">
                      <label class="form-check-label" for="gridRadios7">
                        Average
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f2" id="gridRadios8" value="Poor">
                      <label class="form-check-label" for="gridRadios8">
                        Poor
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How well do you think the orphanage staff members take care of the children?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f3" id="gridRadios9" value="Very well" checked>
                      <label class="form-check-label" for="gridRadios9">
                        Very well
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f3" id="gridRadios10" value="Well">
                      <label class="form-check-label" for="gridRadios10">
                        Well
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f3" id="gridRadios11" value="Average">
                      <label class="form-check-label" for="gridRadios11">
                        Average
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f3" id="gridRadios12" value="Poorly">
                      <label class="form-check-label" for="gridRadios12">
                        Poorly
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How satisfied are you with the communication and involvement of the orhanage staff in keeping you updated about your sponsored child?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f4" id="gridRadios13" value="Very satisfied" checked>
                      <label class="form-check-label" for="gridRadios13">
                        Very satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f4" id="gridRadios14" value="Satisfied">
                      <label class="form-check-label" for="gridRadios14">
                        Satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f4" id="gridRadios15" value="Neutral">
                      <label class="form-check-label" for="gridRadios15">
                        Neutral
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f4" id="gridRadios16" value="Dissatisfied">
                      <label class="form-check-label" for="gridRadios16">
                        Dissatisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f4" id="gridRadios17" value="Very dissatisfied">
                      <label class="form-check-label" for="gridRadios17">
                        Very dissatisfied
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How would you rate the level of safety and security provided to the children in the orphanage?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f5" id="gridRadios18" value="Excellent" checked>
                      <label class="form-check-label" for="gridRadios18">
                        Excellent
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f5" id="gridRadios28" value="Good">
                      <label class="form-check-label" for="gridRadios28">
                        Good
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f5" id="gridRadios38" value="Average">
                      <label class="form-check-label" for="gridRadios38">
                        Average
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f5" id="gridRadios48" value="Poor">
                      <label class="form-check-label" for="gridRadios48">
                        Poor
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How satisfied are you with the medical facilities and healthcare provided to the children in the orphanage?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f6" id="gridRadios19" value="Very satisfied" checked>
                      <label class="form-check-label" for="gridRadios19">
                        Very satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f6" id="gridRadios29" value="Satisfied">
                      <label class="form-check-label" for="gridRadios29">
                        Satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f6" id="gridRadios39" value="Neutral">
                      <label class="form-check-label" for="gridRadios39">
                        Neutral
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f6" id="gridRadios49" value="Dissatisfied">
                      <label class="form-check-label" for="gridRadios49">
                        Dissatisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f6" id="gridRadios59" value="Very dissatisfied">
                      <label class="form-check-label" for="gridRadios59">
                        Very dissatisfied
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How satisfied are you with the food and nutrition provided to the children in the orphanage?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f7" id="gridRadios66" value="Very satisfied" checked>
                      <label class="form-check-label" for="gridRadios66">
                        Very satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f7" id="gridRadios26" value="Satisfied">
                      <label class="form-check-label" for="gridRadios26">
                        Satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f7" id="gridRadios36" value="Neutral">
                      <label class="form-check-label" for="gridRadios36">
                        Neutral
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f7" id="gridRadios46" value="Dissatisfied">
                      <label class="form-check-label" for="gridRadios46">
                        Dissatisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f7" id="gridRadios56" value="Very dissatisfied">
                      <label class="form-check-label" for="gridRadios56">
                        Very dissatisfied
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How likely are you to recommend the orphanage to others?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f8" id="gridRadios61" value="Very likely" checked>
                      <label class="form-check-label" for="gridRadios61">
                        Very likely
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f8" id="gridRadios21" value="Likely">
                      <label class="form-check-label" for="gridRadios21">
                        Likely
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f8" id="gridRadios31" value="Neutral">
                      <label class="form-check-label" for="gridRadios31">
                        Neutral
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f8" id="gridRadios41" value="Unlikely">
                      <label class="form-check-label" for="gridRadios41">
                        Unlikely
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f8" id="gridRadios51" value="Very unlikely">
                      <label class="form-check-label" for="gridRadios51">
                        Very unlikely
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset class="row mb-3">
                  <legend class="col-form-label pt-0">How satisfied are you with the overall facilities provided in the orphanage?</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f9" id="gridRadios72" value="Very satisfied" checked>
                      <label class="form-check-label" for="gridRadios72">
                        Very satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f9" id="gridRadios62" value="Satisfied">
                      <label class="form-check-label" for="gridRadios62">
                        Satisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f9" id="gridRadios32" value="Neutral">
                      <label class="form-check-label" for="gridRadios32">
                        Neutral
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f9" id="gridRadios42" value="Dissatisfied">
                      <label class="form-check-label" for="gridRadios42">
                        Dissatisfied
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="f9" id="gridRadios52" value="Very dissatisfied">
                      <label class="form-check-label" for="gridRadios52">
                        Very dissatisfied
                      </label>
                    </div>
                  </div>
                </fieldset>
                </div>
                <div class="col-md-12">
                  <label for="other" class="form-label">Other</label>
                  <input type="text" class="form-control" name="other" required>
                </div>
                
               
                <input type="hidden" name="action" value="feedback">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
          </div>
          <?php }?>

            <!-- ---------------------- User Feedback ------------------------ -->

            <!-- ---------------------- User Volunteer ------------------------ -->

            <?php if ( 'volunteer' == $id && 'user' == $sessionRole  ) {?>
            <div class="main__form" style="padding:0%;margin-top:0.2%">                                   
            <div class="card">
            <div class="card-body">
              <h2 class="card-title text-center" style="font-size:xx-large">Apply for Volunteer</h2>

              <!-- Multi Columns Form -->
              <form class="row g-3" action="add.php" method="POST" enctype="multipart/form-data">
              <div class="col-md-6">
                  <label for="name" class="form-label">Occupation</label>
                  <input type="text" class="form-control" name="occupation" required>
                </div>
                <div class="col-md-6">
                  <label for="age" class="form-label">Working hours</label>
                  <input type="text" class="form-control" name="workingh" required>
                </div>
                <div class="col-md-3">
                  <label for="name" class="form-label">Holidays</label>
                  <input type="text" class="form-control" name="holidays" required>
                </div>
                <div class="col-md-9">
                  <label for="age" class="form-label">Any health issues?</label>
                  <input type="text" class="form-control" name="healthi" required>
                </div>
                <div class="col-12">
                    <label for="photo" class="form-label">Photo</label>
                    <input class="form-control" type="file" name="photo" value="" required />
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">What do you know about our organization?</label>
                  <input type="text" class="form-control" name="f1" required>
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">When can you start your volunteer position?</label>
                  <input type="text" class="form-control" name="f2" required>
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">How much time do you plan to spend volunteering?</label>
                  <input type="text" class="form-control" name="f3" required>
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">Are you available everytime we upload an event?</label>
                  <select name="f4" class="form-select">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                  </select>
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">Do you prefer to work as a team or single?</label>
                  <select name="f5" class="form-select">
                    <option value="single" selected>Single</option>
                    <option value="team">Team</option>
                  </select>
                </div>
                <div class="col-md-12">
                  <label for="number" class="form-label">Do you suggest others to be a volunteer?</label>
                  <select name="f6" class="form-select">
                  <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                  </select>
                  </div>
                  <div class="col-md-12">
                  <label for="f7" class="form-label">Do you prefer donating to the organization? </label>
                  <select  name="f7" class="form-select ">
                  <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                  </select>
                  </div>
               
                  <input type="hidden" name="action" value="volunteer">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
          </div>
          <?php }?>

            <!-- ---------------------- User Volunteer ------------------------ -->

            <!-- ---------------------- User donate ------------------------ -->

            <?php if ( 'donate' == $id && 'user' == $sessionRole  ) {?>
            <div class="main__form" style="padding:0%;margin-top:0.2%">                                   
            <div class="card">
            <div class="card-body">
              <h2 class="card-title text-center" style="font-size:xx-large">Donate</h2>
                <form class="row g-3 needs-validation" action="add.php" method="POST" enctype="multipart/form-data">
                    <div class="col-12">
                      <label for="occupation" class="form-label">Occupation</label>
                      <input type="text" name="occupation" class="form-control" id="occupation" required>
                      <div class="invalid-feedback">Please, enter your occupation!</div>
                    </div>

                    <div class="col-12">
                      <label for="income" class="form-label">Income</label>
                      <input type="text" name="income" class="form-control" id="income" required>
                      <div class="invalid-feedback">Please, enter your income!</div>
                    </div>

                    <div class="col-12">
                    <label for="photo" class="form-label">Income Certificate</label>
                    <input class="form-control" id="photo" type="file" name="photo" value="" required />
                    </div>
                    <div class="col-12">
                      <label for="mySelect" class="form-label">Donation Type</label>
                      <select id="mySelect" name="type" onchange="handleSelectChange(this)" class="form-select">
                      <option value="food" selected>Food </option>
                        <option value="money" >Money </option>
                        <option value="cloth">Cloth </option>
                        <option value="health">Health  </option>
                        <option value="education">Education  </option>
                        <option value="other">Other</option>
                    </select>
                    <div id="scanner" style="display: none;">
                    <div class="col col-12 text-center pb-3">
                        <img src="uploads/scanner.jpeg" class="img-fluid" style="margin-top:20px " alt="">
                    </div>
                    </div>
                    <script>
                        function handleSelectChange(selectElement) {
                        var selectedOption = selectElement.value;
                        var scannerElement = document.getElementById("scanner");

                        if (selectedOption === "money") {
                            scannerElement.style.display = "block"; // Show the scanner element
                        } else {
                            scannerElement.style.display = "none"; // Hide the scanner element
                        }
                        }
                    </script>
                    </div>
                    <div class="col-12">
                      <label for="form-select" class="form-label">Donation Mode</label>
                      <select name="mode" class="form-select">
                        <option value="collect form my place" selected>Collect from my place</option>
                        <option value="wil visit the organization">Will visit the organization</option>
                        <option value="other">Other</option>
                    </select>
                    </div>
                    <input type="hidden" name="action" value="donate">
                    <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>

                  </form>
                  </div>
          </div>
          </div>
          <?php }?>

            <!-- ---------------------- User donate ------------------------ -->

            <!-- ---------------------- User Profile ------------------------ -->
            <?php if ( 'userProfile' == $id ) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query( $connection, $query );
                    $data = mysqli_fetch_assoc( $result )
                ?>
                <div class="userProfile">
                    <div class="main__form myProfile">
                        <form action="index.php">
                            <div class="main__form--title myProfile__title text-center">My Profile</div>
                            <div class="form-row text-center">
                                <div class="col col-12 text-center pb-3">
                                    <img src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="col col-12">
                                    <h4><b>Name : </b><?php printf( "%s", $data['name']);?></h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Email : </b><?php printf( "%s", $data['email'] );?></h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Phone : </b><?php printf( "%s", $data['phone'] );?></h4>
                                </div>
                                <input type="hidden" name="id" value="userProfileEdit">
                                <!--<div class="col col-12">
                                    <input class="updateMyProfile" type="submit" value="Update Profile">
                                </div>-->
                            </div>
                        </form>
                    </div>
                </div>
            <?php }?>

            <?php if ( 'userProfileEdit' == $id ) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query( $connection, $query );
                    $data = mysqli_fetch_assoc( $result )
                ?>


                <div class="userProfileEdit">
                    <div class="main__form">
                        <div class="main__form--title text-center">Update My Profile</div>
                        <form enctype="multipart/form-data" action="add.php" method="POST">
                            <div class="form-row">
                                <div class="col col-12 text-center pb-3">
                                    <img id="pimg" src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                                    <i class="fas fa-pen pimgedit"></i>
                                    <input onchange="document.getElementById('pimg').src = window.URL.createObjectURL(this.files[0])" id="pimgi" style="display: none;" type="file" name="avatar">
                                </div>
                                <div class="col col-12">
                                <?php if ( isset( $_REQUEST['avatarError'] ) ) {
                                            echo "<p style='color:red;' class='text-center'>Please make sure this file is jpg, png or jpeg</p>";
                                    }?>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name" value="<?php echo $data['fname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo $data['lname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email" value="<?php echo $data['email']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-phone-alt"></i>
                                        <input type="number" name="phone" placeholder="Phone" value="<?php echo $data['phone']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="oldPassword" placeholder="Old Password" required>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="newPassword" placeholder="New Password" required>
                                        <p>Type Old Password if you don't want to change</p>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="action" value="updateProfile">
                                <div class="col col-12">
                                    <input type="submit" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php }?>
            <!-- ---------------------- User Profile ------------------------ -->

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