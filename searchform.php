<form id="searchform" name="searchform" action="<?php echo esc_url( home_url( '/' ) ) ; ?>" method="get">
	<input type="text" class="field" name="s" id="s" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( __( 'Search', 'hinagata' ) ); ?>" />
</form>
