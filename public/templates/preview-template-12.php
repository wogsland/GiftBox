<div class="template" id="preview">
	<div id="column-12-1" class="column height100 width33" <?php $this->columns['column-12-1']->width_percentage(); ?>>
		<div id="column-12-4" class="padded column height50 width100" <?php $this->columns['column-12-4']->height_percentage(); ?>>
			<?php $this->bentos["bento-12-1"]->render(); ?>
		</div>
		<div id="column-12-5" class="padded column height50 width100" <?php $this->columns['column-12-5']->height_percentage(); ?>>
			<?php $this->bentos["bento-12-2"]->render(); ?>
		</div>
	</div>
	<div id="column-12-2" class="padded column height100 width33" <?php $this->columns['column-12-2']->width_percentage(); ?>>
		<?php $this->bentos["bento-12-3"]->render(); ?>
	</div>
	<div id="column-12-3" class="padded column height100 width33" <?php $this->columns['column-12-3']->width_percentage(); ?>>
		<?php $this->bentos["bento-12-4"]->render(); ?>
	</div>
</div>