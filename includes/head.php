<meta charset="utf-8" />
<meta name="content-language" content="de"/>
<meta name="author" content="Dennis Adamczyk" />
<meta name="copyright" content="© DuisPaper 2017" />
<meta name="language" content="Deutsch" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="shortcut icon" type="image/png" href="/img/Logo168.png"/>
<meta name="theme-color" content="#ecf0f1">

<!--<title>DuisPaper</title>-->


<link rel="manifest" href="/manifest/manifest.json">
<link type="text/css" rel="stylesheet" href="/css/layout.css" />
<link type="text/css" rel="stylesheet" href="/css/popup.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
<link href="/css/animate.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="/js/menu.js"></script>
<script src="/js/nav.js"></script>
<script>
var USER_PROFILE_NAME = "<? echo(str_replace(' ', '_', $user_data['first_name']) . '-' . str_replace(' ', '_', $user_data['last_name'])); ?>";
</script>
<script src="/js/login.js"></script>
<script src="/js/footer.js"></script>
<script src="/js/popup.js"></script>
<?
if(is_logged_in() === true) {
  ?>
<script>var USER_ID = <? echo $session_user_id; ?>;</script>
<script src="/js/online.js"></script>
  <?
}
?>
