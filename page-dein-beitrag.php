<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">

		<?php if ( have_posts() ) : while ( have_posts() ):
			the_post(); ?>

          <div <?php post_class( 'page' ); ?>>
            <div class="page__content">
              <div class="description">
                <p>
					<?php if ( empty( get_the_content() ) ): ?>
                      Mithilfe dieses Formulars kannst du dein Konto zum Beiträge Verfassen freischalten.
					<?php else:
						echo strip_tags( get_the_content(), '<a><span><br>' );
					endif; ?>
                </p>
              </div>
              <form method="POST">
                <div class="type select">
                  <label for="type" class="label">Ich bin</label>
                  <label class="styledSelect">
                    <select id="type">
                      <option value="student">Schüler</option>
                      <option value="teacher">Lehrer</option>
                      <option value="parent">Elternteil</option>
                      <option value="principal">Teil der Schulleitung</option>
                    </select>
                  </label>
                  <label for="type" class="error"></label>
                </div>
                <div class="changeable">
                  <div class="student">
                    <div class="name input">
                      <input type="text" name="student-name" id="student-name" placeholder="Maximilian Mustermann" required
                             value="<?php echo wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name; ?>">
                      <i class="material-icons">cancel</i>
                      <label for="student-name" class="label">Vor- und Nachname</label>
                      <label for="student-name" class="error"></label>
                    </div>
                    <div class="email input">
                      <input type="email" name="student-email" id="student-email" placeholder="max.muster@franz-haniel-gymnasium.eu" required>
                      <i class="material-icons">cancel</i>
                      <label for="student-email" class="label">iServ-E-Mail</label>
                      <label for="student-email" class="error"></label>
                    </div>
                    <div class="class input">
                      <input type="text" name="student-class" id="student-class" placeholder="7d / Q1" required>
                      <i class="material-icons">cancel</i>
                      <label for="student-email" class="label">Klasse/Stufe</label>
                      <label for="student-email" class="error"></label>
                    </div>
                    <div class="age input">
                      <input type="number" name="student-age" id="student-age" required>
                      <i class="material-icons">cancel</i>
                      <label for="student-age" class="label">Alter</label>
                      <label for="student-age" class="error"></label>
                    </div>
                    <div class="message input input--textarea">
                      <textarea name="student-message" id="student-message" placeholder="Wer bist du? Worüber möchtest du Beiträge veröffentlichen?" required></textarea>
                      <label for="student-message" class="label">Nachricht</label>
                      <label for="student-message" class="error"></label>
                    </div>
                  </div>
                  <div class="teacher">
                    <div class="name input">
                      <input type="text" name="teacher-name" id="teacher-name" placeholder="Maximilian Mustermann" required
                             value="<?php echo wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name; ?>">
                      <i class="material-icons">cancel</i>
                      <label for="teacher-name" class="label">Vor- und Nachname</label>
                      <label for="teacher-name" class="error"></label>
                    </div>
                    <div class="email input">
                      <input type="email" name="teacher-email" id="teacher-email" placeholder="max.muster@franz-haniel-gymnasium.eu" required>
                      <i class="material-icons">cancel</i>
                      <label for="teacher-email" class="label">iServ-E-Mail</label>
                      <label for="teacher-email" class="error"></label>
                    </div>
                    <div class="subjects input">
                      <input type="text" name="teacher-subjects" id="teacher-subjects" placeholder="Deutsch, Mathematik" required>
                      <i class="material-icons">cancel</i>
                      <label for="teacher-subjects" class="label">Unterrichtende Fächer</label>
                      <label for="teacher-subjects" class="error"></label>
                    </div>
                    <div class="message input input--textarea">
                      <textarea name="teacher-message" id="teacher-message" placeholder="Worüber möchten Sie Beiträge veröffentlichen?" required></textarea>
                      <label for="teacher-message" class="label">Nachricht</label>
                      <label for="teacher-message" class="error"></label>
                    </div>
                  </div>
                  <div class="parent">
                    <div class="name input">
                      <input type="text" name="parent-name" id="parent-name" placeholder="Maximilian Mustermann" required
                             value="<?php echo wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name; ?>">
                      <i class="material-icons">cancel</i>
                      <label for="parent-name" class="label">Vor- und Nachname</label>
                      <label for="parent-name" class="error"></label>
                    </div>
                    <div class="name_child input">
                      <input type="text" name="parent-name_child" id="parent-name_child" placeholder="Maximilian Mustermann" required">
                      <i class="material-icons">cancel</i>
                      <label for="parent-name_child" class="label">Vor- und Nachname des Kindes auf dem FHG</label>
                      <label for="parent-name_child" class="error"></label>
                    </div>
                    <div class="email input">
                      <input type="email" name="parent-email" id="parent-email" placeholder="max.muster@franz-haniel-gymnasium.eu" required>
                      <i class="material-icons">cancel</i>
                      <label for="parent-email" class="label">iServ-E-Mail des Kindes</label>
                      <label for="parent-email" class="error"></label>
                    </div>
                    <div class="class input">
                      <input type="text" name="parent-class" id="parent-class" placeholder="7d / Q1" required>
                      <i class="material-icons">cancel</i>
                      <label for="parent-email" class="label">Klasse/Stufe des Kindes</label>
                      <label for="parent-email" class="error"></label>
                    </div>
                    <div class="message input input--textarea">
                      <textarea name="parent-message" id="parent-message" placeholder="Wer bist du? Worüber möchtest du Beiträge veröffentlichen?" required></textarea>
                      <label for="parent-message" class="label">Nachricht</label>
                      <label for="parent-message" class="error"></label>
                    </div>
                  </div>
                  <div class="principal">
                    <div class="name input">
                      <input type="text" name="principal-name" id="principal-name" placeholder="Maximilian Mustermann" required
                             value="<?php echo wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name; ?>">
                      <i class="material-icons">cancel</i>
                      <label for="principal-name" class="label">Vor- und Nachname</label>
                      <label for="principal-name" class="error"></label>
                    </div>
                    <div class="email input">
                      <input type="email" name="principal-email" id="principal-email" placeholder="max.muster@franz-haniel-gymnasium.eu" required>
                      <i class="material-icons">cancel</i>
                      <label for="principal-email" class="label">iServ-E-Mail</label>
                      <label for="principal-email" class="error"></label>
                    </div>
                    <div class="role input">
                      <input type="text" name="principal-role" id="principal-role" placeholder="Sekretariat" required>
                      <i class="material-icons">cancel</i>
                      <label for="principal-role" class="label">Bereich</label>
                      <label for="principal-role" class="error"></label>
                    </div>
                    <div class="message input input--textarea">
                      <textarea name="principal-message" id="principal-message" placeholder="Wer bist du? Worüber möchtest du Beiträge veröffentlichen?" required></textarea>
                      <label for="principal-message" class="label">Nachricht</label>
                      <label for="principal-message" class="error"></label>
                    </div>
                  </div>
                  <input type="submit" class="submit" value="submit">
                </div>
              </form>
            </div>
          </div>

		<?php endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>