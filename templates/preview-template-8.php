<div class="template" id="preview">
	<div id="column-8-1" class="padded column height100 width50" <?php $this->columns['column-8-1']->width_percentage(); ?>>
		<?php $this->bentos["bento-8-1"]->render(); ?>
	</div>
	<div id="column-8-2" class="column height100 width50" <?php $this->columns['column-8-2']->width_percentage(); ?>>
		<div id="column-8-3" class="padded column height50 width100" <?php $this->columns['column-8-3']->height_percentage(); ?>>
			<?php $this->bentos["bento-8-2"]->render(); ?>
		</div>
		<div id="column-8-4" class="padded column height50 width100" <?php $this->columns['column-8-4']->height_percentage(); ?>>
			<?php $this->bentos["bento-8-3"]->render(); ?>
		</div>
	</div>
</div>