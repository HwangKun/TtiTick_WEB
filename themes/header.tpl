<!DOCTYPE html>
<html lang="ko">
<head>
    <title>Ttitick - 아이디어 공유플랫폼</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="description" content="아이디어 공유 플랫폼 Ttitick">

    <meta name="keywords" content="{if $pagetitle ne NULL}{$pagetitle},{/if}{if $metakeywords ne NULL}{$metakeywords},{/if}{$site_name}">
    <meta name="author" content="">

    <link rel="shortcut icon" href="">

    <link href="/frontool/css/jquery-ui.css" rel="stylesheet">
    <link href="/frontool/css/bootstrap.min.css" rel="stylesheet">
    <link href="/frontool/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/frontool/css/ttitick.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/frontool/js/html5shiv.js"></script>
    <script src="/frontool/js/respond.js"></script>
    <![endif]-->
    <script src="/frontool/js/bootstrap.min.js"></script>
</head>

<body>
<nav class="navbar">
    <div class="navbar-ttitick container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">TtiTick</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <!--<form class="navbar-form navbar-left" role="search">-->
                <!--<div class="form-group">-->
                    <!--<input type="text" class="form-control" placeholder="Search">-->
                <!--</div>-->
                <!--<button type="submit" class="btn btn-default">Submit</button>-->
            <!--</form>-->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">로그인</a></li>
                <li style="border-right: 1px #ffffff solid; height: 20px;"></li>
                <li><a href="#">회원가입</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$name}님 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
