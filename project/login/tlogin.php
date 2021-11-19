<?php
session_start();
 
if(isset($_SESSION["admloggedin"]) && $_SESSION["admloggedin"] === true){
    header("location: ../admin/teacherpage.php");
    exit;
}

require_once "config.php";
 
$teachername = $password = "";
$teachername_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["teachername"]))){
        $teacherame_err = "Введите логин";
    } else{
        $teachername = trim($_POST["teachername"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Введите пароль";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($teachername_err) && empty($password_err) ){
        $sql = "SELECT id, teachername, password FROM teachers WHERE teachername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_teachername);
            

            $param_teachername = $teachername;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $teachername, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["admloggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["teachername"] = $teachername;
                            
                            header("location: ../admin/teacherpage.php");
                        } else{
                            $login_err = "Некорректное имя или пароль.";
                        }
                    }
                } else{
                    $login_err = "Некорректное имя или пароль";
                }
            } else{
                echo "Произошла ошибка, повторите позже";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../style.css" rel="stylesheet">
    <style>
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 360px;
        padding: 20px;
    }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container"><a href="../index.php"><span class="navbar-brand text-uppercase font-weight-bold">
                        Списочек</span></a>
            </div>
        </nav>
    </header>
    <div class="content-layout">
        <div class="main-content">
            <div class="wrapper">
                <h2>Вход для преподавателей</h2>

                <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" name="teachername"
                            class="form-control <?php echo (!empty($teachername_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $teachername; ?>">
                        <span class="invalid-feedback"><?php echo $teachername_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password"
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Вход">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>