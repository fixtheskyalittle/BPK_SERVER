<?php
$title = "vBote - Login";
$data = $_POST;
if ( isset($data['do_login']) )
{
    $user = R::findOne('csgo_user', 'login = ?', array($data['login']));
    if ( $user )
    {
        //логин существует
        if ( password_verify($data['password'], $user->password) )
        {
            //если пароль совпадает, то нужно авторизовать пользователя
            $_SESSION['auth_perx'] = $user;
            echo '<div style="color:dreen;">You are logged in!<br> 
            You can go to the <a href="/">main</a> page.</div><hr>';
            header('Location: /');
        }else{
            $errors[] = '<div class="alert alert-danger" role="alert">Wrong password entered!</div>';
        }
 
    }elseif ($usere = R::findOne('csgo_user', 'email = ?', array($data['login']))) {
                //логин существует
        if ( password_verify($data['password'], $usere->password) )
        {
          //$emailcheck = R::findOne('confirmemail', 'email = ?', array($data['login']));
          //if ($emailcheck['status'] == '0') {

           // $errors[] = '<div class="alert alert-danger" role="alert">Подтвердите свой E-Mail! Мы вас выслали ссылку с подтверждением!</div>';
          //}else{
            //если пароль совпадает, то нужно авторизовать пользователя
            $_SESSION['auth_perx'] = $usere;
            header('Location: /');
          //}
        }else{
            $errors[] = '<div class="alert alert-danger" role="alert">Wrong password entered!</div>';
        }
 
    }else{
        $errors[] = '<div class="alert alert-danger" role="alert">User with this login or E-Mail was not found!</div>';
    }
     if ( ! empty($errors) )
    {
        //выводим ошибки авторизации
        //echo array_shift($errors);
    }
}
controller::init_view($route, "signin", false, null);
?>