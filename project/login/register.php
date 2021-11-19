<?php

require_once "config.php";
 
$username = $password = $confirm_password = $firstname = $lastname = $course_group = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = $course_group_err = "";

 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Введите имя";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Только буквы, цифры, подчеркивания";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Это имя уже занято";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Что-то пошло не так";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Введите пароль";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Не меньше 6 символов";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Подтвердите пароль";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Пароли не совпадают";
        }
    }
    

    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Введите ваше имя";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
    }

    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Введите ваше имя";     
    }
    else{
        $lastname = trim($_POST["lastname"]);
    }

    if(empty(trim($_POST["course_group"]))){
        $course_group_err = "Введите вашу группу";     
    }
    else{
        $course_group = trim($_POST["course_group"]);
    }


    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($course_group_err)){
        
        $sql = "INSERT INTO users (username, password, course_group) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_course_group);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_course_group = $course_group;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $sql = "INSERT INTO exams (first_name, last_name, course_group) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_firstname, $param_lastname, $param_course_group);
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_course_group = $course_group;
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Что-то пошло не так";
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
    <title>Sign Up</title>
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
                <h1 class="whitetxt">Регистрация</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" name="username"
                            class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password"
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Повторите пароль</label>
                        <input type="password" name="confirm_password"
                            class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Ваше имя</label>
                        <input type="firstname" name="firstname"
                            class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $firstname; ?>">
                        <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Ваша фамилия</label>
                        <input type="lastname" name="lastname"
                            class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $lastname; ?>">
                        <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Ваша группа</label>
                        <input type="course_group" name="course_group"
                            class="form-control <?php echo (!empty($course_group_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $course_group; ?>">
                        <span class="invalid-feedback"><?php echo $course_group_err; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Подтвердить">
                        <input type="reset" class="btn btn-secondary ml-2" value="Сброс">
                    </div>

                    <p>Уже зарегистрированы? <a href="login.php" class = "whitetxt">Тыкайте сюда</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>