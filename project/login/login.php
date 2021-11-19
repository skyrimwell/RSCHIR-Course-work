<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../content/authmainpage.php");
    exit;
}

require_once "config.php";
 
$username = $password = $course_group = "";
$username_err = $password_err = $login_err = $course_group_err =  "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Введите имя";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Введите пароль";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["course_group"]))){
        $course_group_err = "Введите группу";
    } else{
        $course_group = trim($_POST["course_group"]);
    }
    
    if(empty($username_err) && empty($password_err) && empty($course_group_err)){
        $sql = "SELECT id, username, password, course_group FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            

            $param_username = $username;
            $param_course_group = $course_group;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $course_group);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["course_group"] = $course_group;
                            
                            header("location: ../content/authmainpage.php");
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
                        Списочек</span> </a>
            </div>
        </nav>
    </header>
    <div class="content-layout">
        <div class="main-content">
            <div class="wrapper">
                <h2>Вход</h2>

                <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" name="username"
                            class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password"
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Группа</label>
                        <input type="course_group" name="course_group"
                            class="form-control <?php echo (!empty($course_group_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $course_group_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Вход">
                    </div>
                    <p>Еще не в системе? <a href="register.php">Зарегистрируйтесь</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>