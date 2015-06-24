<div class="template" id="preview">
	<div id="column-11-1" class="padded column height50 width100" <?php $this->columns['column-11-1']->height_percentage(); ?>>
		<?php $this->bentos["bento-11-1"]->render(); ?>
	</div>
	<div id="column-11-2" class="column height50 width100" <?php $this->columns['column-11-2']->height_percentage(); ?>>
		<div id="column-11-3" class="padded column height100 width50" <?php $this->columns['column-11-3']->width_percentage(); ?>>
			<?php $this->bentos["bento-11-2"]->render(); ?>
		</div>
		<div id="column-11-4" class="padded column height100 width50" <?php $this->columns['column-11-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-11-3"]->render(); ?>
		</div>
	</div>
</div>