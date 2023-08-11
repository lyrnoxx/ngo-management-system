<?php

session_start();
include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
if ( !$connection ) {
    echo mysqli_error( $connection );
    throw new Exception( "Database cannot Connect" );
} else {
    $action = $_REQUEST['action'] ?? '';

    if ( 'addEvents' == $action ) {
        error_reporting(0);
        $msg = "";
        $filename = $_FILES["photo"]["name"];
        $tempname = $_FILES["photo"]["tmp_name"];
        $folder = "./uploads/" . $filename;
        $title = $_REQUEST['title'] ?? '';
        $content = $_REQUEST['content'] ?? '';
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }
        if ( '' == $filename ){
            $filename='nophoto';
        }

        if ( $title && $content ) {
            $query = "INSERT INTO events(photo,title, content) VALUES ('$filename','$title', '$content')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allEvents" );
        }

    } elseif ( 'updateEvents' == $action ) {
        $id = $_REQUEST['id'] ?? '';
        $title = $_REQUEST['title'] ?? '';
        $content = $_REQUEST['content'] ?? '';

        if ( $id && $title && $content ) {
            $query = "UPDATE events SET title='$title', content='$content' WHERE id='{$id}'";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allEvents" );
        }
    } elseif ( 'addOrphan' == $action ) {
        error_reporting(0);
        $msg = "";
        $filename = $_FILES["photo"]["name"];
        $tempname = $_FILES["photo"]["tmp_name"];
        $folder = "./uploads/" . $filename;

        $number = $_REQUEST['number'] ?? '';
        $name= $_REQUEST['name'] ?? '';
        $age = $_REQUEST['age'] ?? '';
        $gender = $_REQUEST['gender'] ?? '';
        $gname = $_REQUEST['gname'] ?? '';
        $disability = $_REQUEST['disability'] ?? '';
        $gcontact= $_REQUEST['gcontact'] ?? '';
        $gaddress = $_REQUEST['gaddress'] ?? '';
        $others= $_REQUEST['others'] ?? '';

     (move_uploaded_file($tempname, $folder)) ;
        if ( '' == $filename ){
            $filename='nophoto';
        }

        if ( $name && $number && $age && $gender && $gcontact ) {
            $query = "INSERT INTO orphans(number,photo, name,age,gender,gname,gcontact,disability,gaddress,others) VALUES ('{$number}','$filename','$name','$age','$gender','$gname','$gcontact','$disability','$gaddress','$others')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=addOrphans" );
        }
    } elseif ( 'addUser' == $action ) {
        $name = $_REQUEST['name'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $address = $_REQUEST['address'] ?? '';
        $gender = $_REQUEST['gender'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $check="select email from users where email='$email'";
        mysqli_query( $connection, $check );

        if ( $email == $check || 'admin@admin.com' == $email) {
            header( "location:login.php?error&id=register" );
        }
        elseif ( $name && $email && $phone && $address && $gender && $password ) {
            $hashPassword = password_hash( $password, PASSWORD_BCRYPT );
            $query = "INSERT INTO users(name,email,phone,address,gender,password) VALUES ('{$name}','$email','$phone','$address','$gender','$hashPassword')";
            mysqli_query( $connection, $query );
            header( "location:index.php" );
        }
    } elseif ( 'addAdopter' == $action ) {

        error_reporting(0);
        $msg = "";
        $acard = $_FILES["acard"]["name"];
        $icard = $_FILES["icard"]["name"];
        $pcard = $_FILES["pcard"]["name"];
        $temp1name = $_FILES["acard"]["tmp_name"];
        $temp2name = $_FILES["icard"]["tmp_name"];
        $temp3name = $_FILES["pcard"]["tmp_name"];
        $folder = "./uploads/" . $filename;

        $OrphanId = $_REQUEST['orphanId'] ?? '';
        $name = $_REQUEST['name'] ?? '';
        $contact = $_REQUEST['contact'] ?? '';
        $gender = $_REQUEST['gender'] ?? '';
        $age = $_REQUEST['age'] ?? '';
        $aadhar = $_REQUEST['aadhar'] ?? '';

        $query = "SELECT * FROM orphans WHERE id='{$OrphanId}'";
        $result = mysqli_query( $connection, $query );
        $data = mysqli_fetch_assoc( $result );
        $onumber = $data['number'] ?? '';

        (move_uploaded_file($temp1name, $folder)) ;
        (move_uploaded_file($temp2name, $folder)) ;
        (move_uploaded_file($temp3name, $folder)) ;

        if ( '' == $acard ){
            $acard ='nophoto';
        }
        if ( '' == $icard ){
            $icard ='nophoto';
        }
        if ( '' == $pcard ){
            $pcard ='nophoto';
        }

        if ( $name && $contact && $gender && $age ) {
            $query = "INSERT INTO adopter(name,contact,gender,age,aadhar,acard,icard,pcard,onumber) VALUES ('{$name}','$contact','$gender','$age','$aadhar','$acard','$icard','$pcard','$onumber')";
            mysqli_query( $connection, $query );
            header( "location:index.php?action=adopted&var={$OrphanId}" );
        }
    } elseif ( 'query' == $action ) {
        $sessionId = $_SESSION['id'] ?? '';
        $query = "SELECT * FROM users WHERE id='$sessionId'";
        $result = mysqli_query( $connection, $query );
        $data = mysqli_fetch_assoc( $result );

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $message = $_REQUEST['message'] ?? '';

        if ( $message) {
            $query = "INSERT INTO queries(name,email,message) VALUES ('{$name}','$email','{$message}')";
            mysqli_query( $connection, $query );
            header( "location:index.php" );
        }

    } elseif ( 'feedback' == $action ) {
        $sessionId = $_SESSION['id'] ?? '';
        $query = "SELECT * FROM users WHERE id='$sessionId'";
        $result = mysqli_query( $connection, $query );
        $data = mysqli_fetch_assoc( $result );

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $f1 = $_REQUEST['f1'] ?? '';
        $f2 = $_REQUEST['f2'] ?? '';
        $f3 = $_REQUEST['f3'] ?? '';
        $f4 = $_REQUEST['f4'] ?? '';
        $f5 = $_REQUEST['f5'] ?? '';
        $f6 = $_REQUEST['f6'] ?? '';
        $f7 = $_REQUEST['f7'] ?? '';
        $f8 = $_REQUEST['f8'] ?? '';
        $f9 = $_REQUEST['f9'] ?? '';
        $other = $_REQUEST['other'] ?? '';

        if ( $name && $email ) {
            $query = "INSERT INTO feedbacks(name,email,f1,f2,f3,f4,f5,f6,f7,f8,f9,other) VALUES ('{$name}','$email','$f1','$f2','$f3','$f4','$f5','$f6','$f7','$f8','$f9','$other')";
            mysqli_query( $connection, $query );
            header( "location:index.php?dashboard" );
        }
        header( "location:index.php" );
    } elseif ( 'volunteer' == $action ) {
        error_reporting(0);
 
        $msg = "";
        $filename = $_FILES["photo"]["name"];
        $tempname = $_FILES["photo"]["tmp_name"];
        $folder = "./uploads/" . $filename;

        $sessionId = $_SESSION['id'] ?? '';
        $query = "SELECT * FROM users WHERE id='$sessionId'";
        $result = mysqli_query( $connection, $query );
        $data = mysqli_fetch_assoc( $result );

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $occupation = $_REQUEST['occupation'] ?? '';
        $workingh = $_REQUEST['workingh'] ?? '';
        $holidays = $_REQUEST['holidays'] ?? '';
        $healthi = $_REQUEST['healthi'] ?? '';
        $f1 = $_REQUEST['f1'] ?? '';
        $f2 = $_REQUEST['f2'] ?? '';
        $f3 = $_REQUEST['f3'] ?? '';
        $f4 = $_REQUEST['f4'] ?? '';
        $f5 = $_REQUEST['f5'] ?? '';
        $f6 = $_REQUEST['f6'] ?? '';
        $f7 = $_REQUEST['f7'] ?? '';

        move_uploaded_file($tempname, $folder);
       
        if ( '' == $filename ){
            $filename='nophoto';
        }


        if ( '' == $filename ){
            $filename='nophoto';
        }


        if ( $name && $email && $occupation && $workingh ) {
            $query = "INSERT INTO volunteers(name,email,occupation,workingh,holidays,healthi,photo,f1,f2,f3,f4,f5,f6,f7) VALUES ('{$name}','$email','$occupation','$workingh','$holidays','$healthi','$filename','$f1','$f2','$f3','$f4','$f5','$f6','$f7')";
            mysqli_query( $connection, $query );
            header( "location:index.php?dashboard" );
        }

    } elseif ( 'donate' == $action ) {
        error_reporting(0);
        $msg = "";
        $filename = $_FILES["photo"]["name"];
        $tempname = $_FILES["photo"]["tmp_name"];
        $folder = "./uploads/" . $filename;

        $sessionId = $_SESSION['id'] ?? '';
        $query = "SELECT * FROM users WHERE id='$sessionId'";
        $result = mysqli_query( $connection, $query );
        $data = mysqli_fetch_assoc( $result );

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $contact = $data['phone'] ?? '';
        $occupation = $_REQUEST['occupation'] ?? '';
        $income = $_REQUEST['income'] ?? '';
        $type = $_REQUEST['type'] ?? '';
        $mode = $_REQUEST['mode'] ?? '';

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }

        if ( '' == $filename ){
            $filename='nophoto';
        }

        if ( $name && $email && $mode ) {
            $query = "INSERT INTO donations(name,email,contact,occupation,income,incomep,type,mode) VALUES ('{$name}','$email','$contact','$occupation','$income','$filename','$type','$mode')";
            mysqli_query( $connection, $query );
            header( "location:index.php?dashboard" );
        }

    } elseif ( 'updateProfile' == $action ) {

        $name = $_REQUEST['name'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $oldPassword = $_REQUEST['oldPassword'] ?? '';
        $newPassword = $_REQUEST['newPassword'] ?? '';
        $sessionId = $_SESSION['id'] ?? '';
        $sessionRole = $_SESSION['role'] ?? '';
        $avatar = $_FILES['avatar']['name'] ?? "";

        if (  $email && $phone && $oldPassword && $newPassword ) {
            $query = "SELECT password,avatar FROM {$sessionRole}s WHERE id='$sessionId'";
            $result = mysqli_query( $connection, $query );

            if ( $data = mysqli_fetch_assoc( $result ) ) {
                $_password = $data['password'];
                $_avatar = $data['avatar'];
                $avatarName = '';
                if ( $_FILES['avatar']['name'] !== "" ) {
                    $allowType = array(
                        'image/png',
                        'image/jpg',
                        'image/jpeg'
                    );
                    if ( in_array( $_FILES['avatar']['type'], $allowType ) !== false ) {
                        $avatarName = $_FILES['avatar']['name'];
                        $avatarTmpName = $_FILES['avatar']['tmp_name'];
                        move_uploaded_file( $avatarTmpName, "assets/img/$avatar" );
                    } else {
                        header( "location:index.php?id=userProfileEdit&avatarError" );
                        return;
                    }
                } else {
                    $avatarName = $_avatar;
                }
                if ( password_verify( $oldPassword, $_password ) ) {
                    $hashPassword = password_hash( $newPassword, PASSWORD_BCRYPT );
                    $updateQuery = "UPDATE {$sessionRole}s SET fname='{$name}', email='{$email}', phone='{$phone}', password='{$hashPassword}', avatar='{$avatarName}' WHERE id='{$sessionId}'";
                    mysqli_query( $connection, $updateQuery );

                    header( "location:index.php?id=userProfile" );
                }

            }

        } else {
            echo mysqli_error( $connection );
        }

    }

}
