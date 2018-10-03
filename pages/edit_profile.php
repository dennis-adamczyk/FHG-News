<?php get_header(); ?>
  <div class="wrapper">

    <form id="edit_profile" action="<?php self_link(); ?>" method="post" novalidate>
		<?php wp_nonce_field( 'update-user_' . get_current_user_id() ); ?>
      <section class="general section">
        <h2 class="section__title">Allgemein</h2>
        <div class="input">
          <input type="text" placeholder="Max Mustermann" required>
          <i class="material-icons">cancel</i>
          <label for="" class="label">Angezeigter Name</label>
          <label for="" class="error"></label>
        </div>
        <div class="input">
          <input type="email" placeholder="max.mustermann@franz-haniel-gymnasium.eu" required>
          <i class="material-icons">cancel</i>
          <label for="" class="label">E-Mail</label>
          <label for="" class="error"></label>
        </div>
        <div class="input">
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Vorname</label>
          <label for="" class="error"></label>
        </div>
        <div class="input">
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Nachname</label>
          <label for="" class="error"></label>
        </div>
      </section>
      <section class="personal section">
        <h2 class="section__title">Persönlich</h2>
      </section>
      <section class="socialMedia section">
        <h2 class="section__title">Social Media</h2>
      </section>
    </form>

  </div>

<?php get_footer(); ?>