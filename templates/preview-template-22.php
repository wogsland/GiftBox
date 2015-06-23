<div class="template" id="preview">
	<div id="column-22-1" class="column height50 width100" <?php $this->columns['column-22-1']->height_percentage(); ?>>
		<div id="column-22-3" class="padded column height100 width33" <?php $this->columns['column-22-3']->width_percentage(); ?>>
			<?php $this->bentos["bento-22-1"]->render(); ?>
		</div>
		<div id="column-22-4" class="padded column height100 width33" <?php $this->columns['column-22-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-22-2"]->render(); ?>
		</div>
		<div id="column-22-5" class="padded column height100 width33" <?php $this->columns['column-22-5']->width_percentage(); ?>>
			<?php $this->bentos["bento-22-3"]->render(); ?>
		</div>
	</div>
	<div id="column-22-2" class="padded column height50 width100" <?php $this->columns['column-22-2']->height_percentage(); ?>>
		<?php $this->bentos["bento-22-4"]->render(); ?>
	</div>
</div>