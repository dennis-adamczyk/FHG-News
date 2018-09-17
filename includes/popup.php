<?
  if(isset($_GET['popup'])) {
    $popup = $_GET['popup'];
    if($popup === 'register') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        $mail = $_GET['mail'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Wir haben dir eine Verifikations-E-Mail geschickt.<br />
                  Check <a href="http://<? echo $mail; ?>">deine E-Mails</a> und bis gleich!
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'email-recover') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        $email = $_GET['email'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Die E-Mail-Adresse, mit der du dich registriert hast, lautet:<br />
                  <b><? echo $email; ?></b>
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'settings') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Die Einstellungen wurden erfolgreich aktualisiert!
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'changepassword') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Dein Passwort wurde erfolgreich geändert!
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'password-recover') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        if($success === 'true') {
          $mail = $_GET['mail'];
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Du hast dein Passwort erfolgreich zurückgesetzt.<br />
                  Wir haben dir eine E-Mail mit deinem vorübergehenden Passwort geschickt.<br />
                  Check <a href="http://<? echo $mail ?>">deine E-Mails</a> und bis gleich!
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'protected_page') {
      ?>
        <div class="popup-overlay">
        </div>
        <div class="popup">
          <div class="cross-circle">
            <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
              <g>
                <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
              </g>
            </svg>
          </div>
          <div class="white-space">
            <div class="text">
              <h3>Oops!</h3>
              <p>
                Bitte melde dich zuerst an, bevor du auf diese Seite gehst.
                Benutze dazu das Symbol oben rechts!
              </p>
              <buttton id="f-okay" class="button">OK</buttton>
            </div>
          </div>
        </div>
      <?
    } else if($popup === 'loggedin_redirect') {
      ?>
        <div class="popup-overlay">
        </div>
        <div class="popup">
          <div class="cross-circle">
            <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
              <g>
                <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
              </g>
            </svg>
          </div>
          <div class="white-space">
            <div class="text">
              <h3>Oops!</h3>
              <p>
                Bitte melde dich zuerst ab, bevor du auf diese Seite gehst.
                Benutze dazu das Symbol oben rechts und klicke auf "Abmelden"!
              </p>
              <buttton id="f-okay" class="button">OK</buttton>
            </div>
          </div>
        </div>
      <?
    } else if($popup === 'please-activate') {
      $mail = $_GET['mail'];
      ?>
        <div class="popup-overlay">
        </div>
        <div class="popup">
          <div class="cross-circle">
            <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
              <g>
                <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
              </g>
            </svg>
          </div>
          <div class="white-space">
            <div class="text">
              <h3>Oops!</h3>
              <p>
                Du bist noch nicht verifiziert!<br />
                Verifiziere dich, bevor du dich anmeldest.<br />
                Check dazu <a href="http://<? echo $mail; ?>">deine E-Mails</a> und befolge die Anweisungen, der E-Mail!
              </p>
              <buttton id="f-okay" class="button">OK</buttton>
            </div>
          </div>
        </div>
      <?
    } else if($popup === 'login' && $_GET['success'] == 'false') {
      ?>
        <div class="popup-overlay">
        </div>
        <div class="popup">
          <div class="cross-circle">
            <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
              <g>
                <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
              </g>
            </svg>
          </div>
          <div class="white-space">
            <div class="text">
              <h3>Oops!</h3>
              <p>
                Ein unbekannter Fehler ist aufgetreten.<br />
                Bitte versuche es später erneut!
              </p>
              <buttton id="f-okay" class="button">OK</buttton>
            </div>
          </div>
        </div>
      <?
    } else if($popup === 'contact') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Das Kontaktformular wurde erfolgreich versendet.<br />
                  Behalte in den nächsten Tagen dein E-Mail-Postfach im Auge. Möglicherweise senden wir dir eine Antwort.
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    } else if($popup === 'activated') {
      if(isset($_GET['success'])) {
        $success = $_GET['success'];
        if($success === 'true') {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="success-circle">
              <svg width="100" height="100" id="tick" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" id="tick_path" d="m25.283462,50.928944l15.858394,15.924747l33.574676,-33.707382" stroke-width="10" fill="rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Erfolg</h3>
                <p>
                  Du hast deine E-Mail-Adresse bestätigt und kannst dich nun mit dem Symbol oben rechts anmelden.
                </p>
                <buttton id="s-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        } else {
          ?>

          <div class="popup-overlay">
          </div>
          <div class="popup">
            <div class="cross-circle">
              <svg width="100" height="100" id="cross" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path stroke="#fff" stroke-linecap="round" class="cross_path" id="cross_path1" d="m21.64384,78.48351l56.71233,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="rgba(0,0,0,0)"/>
                  <path transform="rotate(90 50,49.99999618530274)" stroke-linecap="round" stroke="#fff" class="cross_path" id="cross_path2" d="m21.64384,78.48351l56.71232,-56.96702" fill-opacity="null" stroke-opacity="null" stroke-width="10" fill="#rgba(0,0,0,0)"/>
                </g>
              </svg>
            </div>
            <div class="white-space">
              <div class="text">
                <h3>Fehlschlag</h3>
                <p>
                  Ein unbekannter Fehler ist aufgetreten.<br />
                  Bitte versuche es später erneut!
                </p>
                <buttton id="f-okay" class="button">OK</buttton>
              </div>
            </div>
          </div>

          <?
        }
      }
    }
  }
?>
