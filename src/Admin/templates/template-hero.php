<div class="wrap us-dynamic-ctas-wrapper">
    <div class="jumbotron">
      <?php if ( !is_plugin_active( 'bc-geolocation/bc-geolocation.php' ) ) { ?>
          <h3 class="bc-geolocation-warning">Please, install BC Geolocation plugin first if you want US Dynamic CTAs to work properly!</h3>
      <?php die(); } ?>
      <h1>US Dynamic CTAs</h1>
        <h4><strong>You need ACF Pro and BC Geolocation plugins installed first!</strong></h4>
      <p>This plugin is used to generate shortcodes that display dynamic CTAs.</p>
      <p>The shortcode structure is [cta_shortcode bookmaker="<i>bookmaker_name</i>"]</p>
      <p>Don't forget to select default bonus info by checking "Make it default checkbox"</p>
      <?php echo '<img src="' . plugins_url( '../assets/images/make_it_default.png', __FILE__ ) . '" > '; ?>
      <a class="btn btn-primary btn-lg" href="/wp-admin/admin.php?page=shortcodes-settings" role="button">Create Shortcodes</a>
    </div>
</div>
