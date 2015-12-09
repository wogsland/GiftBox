<div class="template" id="preview">
	<div id="column-23-1" class="padded column height50 width100" <?php $this->columns['column-23-1']->height_percentage(); ?>>
		<?php $this->bentos["bento-23-1"]->render(); ?>
	</div>
	<div id="column-23-2" class="column height50 width100" <?php $this->columns['column-23-2']->height_percentage(); ?>>
		<div id="column-23-3" class="padded column height100 width33" <?php $this->columns['column-23-3']->width_percentage(); ?>>
			<?php $this->bentos["bento-23-2"]->render(); ?>
		</div>
		<div id="column-23-4" class="padded column height100 width33" <?php $this->columns['column-23-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-23-3"]->render(); ?>
		</div>
		<div id="column-23-5" class="padded column height100 width33" <?php $this->columns['column-23-5']->width_percentage(); ?>>
			<?php $this->bentos["bento-23-4"]->render(); ?>
		</div>
	</div>
</div>