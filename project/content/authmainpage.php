<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login/login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Здарова</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../style.css" rel="stylesheet">
    <style>
    body {
        font: 14px sans-serif;
        text-align: center;
    }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container"><span class="navbar-brand text-uppercase font-weight-bold"> Личный кабинет</span>
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a href="#" class="nav-link text-uppercase font-weight-bold">Главная
                                <span class="sr-only">(current)</span></a></li>
                        <li class="nav-item"><a href="../about.php" class="nav-link text-uppercase font-weight-bold">О
                                нас </a></li>
                        <li class="nav-item"><a href="../login/logout.php"
                                class="nav-link text-uppercase font-weight-bold">Выйти</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <h1 class="my-5">Добро пожаловать, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.
        <div class="content-layout">
            <div class="main-content">
                <h1><span class="glow2">Начало работы</span> </h1>
                <hr>


                <h2>Что бы узнать даты пересдач, нажмите одну из кнопок ниже</h2>
                <div>
                    <form action="authmainpage.php" method="POST">
                        <input type="submit" name="tableB" value="Показать">
                    </form>
                            <?php if(isset($_POST['tableB'])){
                    include "../clockwork/tableOnGroup.php";
                    tableBuilder();} 
                    ?>
                </div>
                <!-- <hr><p>Что бы узнать все пересдачи преподавателя, введите ФИО преподавателя в поле ниже</p>
                <div class="form-group">
                        <label>ФИО Преподавателя</label>
                        <input type="fioprep" name="fioprep"
                            class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $lastname; ?>">
                        <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                            </div> -->
            </div>
        </div>
</body>

</html>