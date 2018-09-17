<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
$this_page = "";
loggedin_redirect();

if(isset($_GET['success']) && empty($_GET['success'])) {
  header('Location: /index.php?popup=activated&success=true');
} else {

  if(isset($_GET['email'], $_GET['email_code']) === true) {
    $email = trim($_GET['email']);
    $email_code = trim($_GET['email_code']);

    $errors = array();

    if(user_exists($email) === false) {
      $errors[] = 'Wir konntenten die angegebene E-Mail-Adresse nicht finden';
    } else if(activate($email, $email_code) === false) {
      $errors[] = 'Es sind Fehler beim Aktivieren deines Accounts aufgetreten (Folgende Gründe könnten zutreffen:
      <br />1 Du bist bereits registriert
      <br />2 Du hast den Link falsch kopiert
      <br />3 Wir haben Server-Probleme und du musst es später versuchen
      <br />4 Es ist ein unerwarteter Error aufgetreten [Bitte informiere in deiesem Fall einen Administrator])';
    }

    if(empty($errors)) {
      header('Location: activate.php?success');
    }

    echo(output_errors($errors));

  } else {
    header('Location: /index.php');
    exit();
  }

}
?>