<div class="w-search submit_inside">
	<div class="w-search-h">
		<form class="w-search-form" action="<?php echo home_url( '/' ); ?>">
			<?php if (@ICL_LANGUAGE_CODE != '' AND @ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"><?php } ?>
			<div class="w-search-input">
				<div class="w-search-input-h">
					<input type="text" value="" name="s" placeholder="<?php pll_e("Sök"); ?>..."/>
				</div>
			</div>
			<div class="w-search-submit">
				<input type="submit" value="<?php echo __( 'Search', 'us' ); ?>" />
			</div>
		</form>
	</div>
</div>