<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">

		<?php if ( have_posts() ) : while ( have_posts() ):
			the_post(); ?>

          <div <?php post_class( 'page' ); ?>>
            <div class="page__content">
              <div class="story">
                <h2>Unsere Geschichte</h2>
                <p>
					<?php if ( empty( get_the_content() ) ): ?>
                      Schon vor mehr als einem Jahr (Frühling 2017) haben die heutigen Zeitungsgründer Melanie (hat die Redaktion verlassen), Paul,
                      Vanessa und Dennis in ihrem Wirtschaftskurs eine Aufgabe bekommen, die letztendlich die Idee zur Zeitung hervorbrachte. Herr Junkers,
                      der damalige Kurs-Lehrer, gab den Schülern nämlich die Aufgabe über ein Firmenkonzept nachzudenken, welches man auch wirklich
                      realisieren könnte und das wollte er auch mit einer Idee machen, hat er den Schülern versprochen. Die SchülerInnen haben viele Ideen
                      gesammelt und als Ergebnis kamen selbstgestaltbare Sportbeutel, selbstgemachte Schlüsselhakenleisten und unter anderem auch eine
                      Schülerzeitungsfirma namens DuisPaper heraus. Einige Ideen waren wegen des enormen Aufwandes, wie z. B. bei den Schlüsselhackenleisten,
                      nicht realisierbar, aber unsere Schülerzeitungsidee hat Herrn Junkers überzeugt. Noch im Sommer letzten Jahres hat die Produktion der
                      ersten Ausgabe stattgefunden und wurde dann am 19. Juni 2017 veröffentlicht.<br>
                      Mittlerweile wurde das Schülerzeitungsprojekt, welches vier Printausgaben zur Folge hatte, zum Zwecke der Digitalisierung am FHG zu einer
                      Online-Zeitung namens FHG News online umgewandelt.<br>
                      Die Redaktion hat nun ein neunköpfiges Team und wir suchen natürlich stetig weitere Redakteure und Autoren, die durch unsere neue
                      Onlinepräsens nun noch mehr Möglichkeiten zum Verfassen, Bearbeiten und Kreieren von Beiträgen (z. B. Texte, Videos, Bildergalerien,
                      Livestreams, Umfragen, und vielem mehr) haben. Bei Interesse würden wir uns freuen, wenn du uns mithilfe des
                      <a href="<?php echo get_home_url(); ?>/contact">Kontaktformulars</a>,
                      <a href="mailto:redaktion@duispaper.de" target="_blank">per
                        E-Mail</a> oder persönlich (bei einem unserer Redakteure) kontaktierst. Bei Vorschlägen
                                   für neue Beitragsarten, anonyme Beiträge oder ähnlichem kannst du das Formular unter
                      <a href="<?php echo get_home_url(); ?>/your-contribution">Dein Beitrag</a> benutzen.
					<?php else:
						echo strip_tags( get_the_content(), '<a><span><br>' );
					endif; ?>
                </p>
              </div>
              <div class="team">
                <h2>Unser Team</h2>
                <div class="team__wrapper">
					<?php
					$redakteure = [
						'Fritz Junkers'      => 'Betreuender Lehrer',
						'Dennis Adamczyk'    => 'Chefredakteur',
						'Vanessa Adamczyk'   => 'Mitgründerin',
						'Paul Paschmann'     => 'Mitgründer',
						'Josef Ali'          => 'Senior-Redakteur',
						'Malina Straßburger' => 'Redakteurin',
						'Ebrar Özedemir'     => 'Redakteurin',
						'Irem Karatas'       => 'Redakteurin',
						'Niko Vossmeyer'     => 'Redakteur',
						'Lucy Pischke'       => 'Redakteurin',
						'Carl Dressler'      => 'Redakteur'
					];

					foreach ( $redakteure as $name => $role ) {
						$user = get_user_by( 'login', $name );
						echo '
						<div class="team__wrapper__member" onclick="window.location = \'' . get_author_posts_url( $user->ID ) . '\'">
						  <div class="team__wrapper__member__picture">
						    ' . get_avatar( $user ) . '
              </div>
              <p class="team__wrapper__member__name">' . $name . '</p>
              <p class="team__wrapper__member__role">' . $role . '</p>
						</div>
						';
					}
					?>
                </div>
              </div>
            </div>
          </div>

		<?php endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>