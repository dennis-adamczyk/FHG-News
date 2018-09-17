<?
header('Content-Type: text/html; charset=utf-8');

$root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";
editorial_page('/editorial/OrgaPlan');

$query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `orgaplan`");

while($fetch = mysqli_fetch_assoc($query)) {
  echo '<tr>';
    echo '<td>' . $fetch['titel'] . '</td>';
    echo '<td>' . $fetch['länge'] . '</td>';
    echo '<td>' . $fetch['autor'] . '</td>';
    echo '<td>' . $fetch['bearbeitungsvermerk'] . '</td>';
  echo '</tr>';
}


$query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `orgaplan_werbung`");

echo '<tr class="seperator"><td><b>Werbung:</b></td><td></td><td></td><td></td></tr>';

while($fetch = mysqli_fetch_assoc($query)) {
  echo '<tr>';
    echo '<td>' . $fetch['titel'] . '</td>';
    echo '<td>' . $fetch['länge'] . '</td>';
    echo '<td></td>';
    echo '<td><p class="vermerk">' . $fetch['bearbeitungsvermerk'] . '</p><p class="geld">' . $fetch['geld'] . (strlen((string) $fetch['geld']) > 0 ? '.-€' : '') . '</p></td>';
  echo '</tr>';
}
