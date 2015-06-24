<div class="template" id="preview">
	<div id="column-10-1" class="column height50 width100" <?php $this->columns['column-10-1']->height_percentage(); ?>>
		<div id="column-10-3" class="padded column height100 width50" <?php $this->columns['column-10-3']->width_percentage(); ?>>
			<?php $this->bentos["bento-10-1"]->render(); ?>
		</div>
		<div id="column-10-4" class="padded column height100 width50" <?php $this->columns['column-10-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-10-2"]->render(); ?>
		</div>
	</div>
	<div id="column-10-2" class="padded column height50 width100" <?php $this->columns['column-10-2']->height_percentage(); ?>>
		<?php $this->bentos["bento-10-3"]->render(); ?>
	</div>
</div>