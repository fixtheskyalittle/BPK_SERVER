<!DOCTYPE html>
<html style="min-height: 100%;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom CSS -->
    <title><?= $title ?></title>
    <!-- Custom CSS -->
    <?= bootstrap(); ?>
    <!-- Custom CSS -->
    <link href="<?= $first_level.$_SERVER['SERVER_NAME']?>/public/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
        body {
            font-family: "Segoe UI", "Arial", sans-serif;
        }
        .score {
            font-size: 25px;
        }
        .live {
            position: absolute;
            font-family: sans-serif;
            color: #fff;
            text-align: left;
            margin-left: 10px;
        }
        .bottom_lv {
            position: absolute;
            font-family: sans-serif;
            color: #fff;
            text-align: right;
            margin-left: 80%;
        }
    </style>
</head>
  <body class="d-flex h-500 text-center text-white" style="background-color: #212529; height: 150%;">
    
<div class="cover-container d-flex w-100 p-1 mx-auto flex-column">
  <header class="mb-100">
    <div>
      <h3 class="float-md-start mb-0">Scoreboard</h3>
      <nav class="nav nav-masthead justify-content-center float-md-end">
        <a class="nav-link" id="home" aria-current="page" href="/">Home</a>
        <a class="nav-link" id="csgo" href="/csgo/">CSGO</a>
        <a class="nav-link" id="valorant" href="/valorant/">Valorant</a>
      </nav>
    </div>
  </header>
