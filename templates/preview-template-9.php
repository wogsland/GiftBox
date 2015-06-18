<div class="template" id="preview">
	<div id="column-9-1" class="padded column height100 width50" <?php $this->columns['column-9-1']->width_percentage(); ?>>
		<div id="column-9-3" class="padded column height50 width100" <?php $this->columns['column-9-3']->height_percentage(); ?>>
			<?php $this->bentos["bento-9-1"]->render(); ?>
		</div>
		<div id="column-9-4" class="padded column height50 width100" <?php $this->columns['column-9-4']->height_percentage(); ?>>
			<?php $this->bentos["bento-9-2"]->render(); ?>
		</div>
	</div>
	<div id="column-9-2" class="padded column height100 width50" <?php $this->columns['column-9-2']->width_percentage(); ?>>
		<?php $this->bentos["bento-9-3"]->render(); ?>
	</div>
</div>