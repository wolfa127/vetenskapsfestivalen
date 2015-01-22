<?php
global $smof_data;
if ($smof_data['header_language_type'] == 'WPML language switcher' AND function_exists('icl_get_languages'))
{
	$languages = icl_get_languages('skip_missing=0');
	if(1 < count($languages)){
?>
	<div class="w-lang layout_dropdown">
		<div class="w-lang-h">
			<div class="w-lang-list">
				<?php foreach ($languages as $language) {
					if ($language['active'])
					{
						$current_language = $language;
						continue;
					}
				?>
				<a class="w-lang-item lang_<?php echo $language['language_code'] ?>" href="<?php echo $language['url'] ?>">
					<span class="w-lang-item-icon"></span>
					<span class="w-lang-item-title"><?php echo ($language['native_name']) ?></span>
				</a>
				<?php } ?>
			</div>
			<div class="w-lang-current">
				<span class="w-lang-item">
					<span class="w-lang-item-icon"></span>
					<span class="w-lang-item-title"><?php echo ($current_language['native_name']) ?></span>
				</span>
			</div>
		</div>
	</div>
<?php //print_r($current_language);
	}
}
elseif ($smof_data['header_language_type'] == 'Your own links')
{
?>
	<div class="w-lang layout_dropdown has_title">
		<div class="w-lang-h">
			<div class="w-lang-list">
				<?php for ($i = 2; $i <= $smof_data['header_language_amount']; $i++) {
					?>
					<a class="w-lang-item" href="<?php echo (substr($smof_data['header_language_'.$i.'_url'], 0, 4) == 'http')?$smof_data['header_language_'.$i.'_url']:'//'.$smof_data['header_language_'.$i.'_url']; ?>">
						<span class="w-lang-item-icon"></span>
						<span class="w-lang-item-title"><?php echo $smof_data['header_language_'.$i.'_name'] ?></span>
					</a>
				<?php } ?>
			</div>
			<div class="w-lang-current">
				<span class="w-lang-item">
					<span class="w-lang-item-icon"></span>
					<span class="w-lang-item-title"><?php echo $smof_data['header_language_1_name'] ?></span>
				</span>
			</div>
		</div>
	</div>
<?php
}
