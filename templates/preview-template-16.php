<div class="template" id="preview">
	<div id="column-16-1" class="column height33 width100" <?php $this->columns['column-16-1']->height_percentage(); ?>>
		<div id="column-16-4" class="padded column height100 width50" <?php $this->columns['column-16-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-16-1"]->render(); ?>
		</div>
		<div id="column-16-5" class="padded column height100 width50" <?php $this->columns['column-16-5']->width_percentage(); ?>>
			<?php $this->bentos["bento-16-2"]->render(); ?>
		</div>
	</div>
	<div id="column-16-2" class="padded column height33 width100" <?php $this->columns['column-16-2']->height_percentage(); ?>>
		<?php $this->bentos["bento-16-3"]->render(); ?>
	</div>
	<div id="column-16-3" class="padded column height33 width100" <?php $this->columns['column-16-3']->height_percentage(); ?>>
		<?php $this->bentos["bento-16-4"]->render(); ?>
	</div>
</div>