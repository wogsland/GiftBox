<div class="template" id="preview">
	<div id="column-20-1" class="padded column height100 width50" <?php $this->columns['column-20-1']->width_percentage(); ?>>
		<?php $this->bentos["bento-20-1"]->render(); ?>
	</div>
	<div id="column-20-2" class="column height100 width50" <?php $this->columns['column-20-2']->width_percentage(); ?>>
		<div id="column-20-3" class="padded column height33 width100" <?php $this->columns['column-20-3']->height_percentage(); ?>>
			<?php $this->bentos["bento-20-2"]->render(); ?>
		</div>
		<div id="column-20-4" class="padded column height33 width100" <?php $this->columns['column-20-4']->height_percentage(); ?>>
			<?php $this->bentos["bento-20-3"]->render(); ?>
		</div>
		<div id="column-20-5" class="padded column height33 width100" <?php $this->columns['column-20-5']->height_percentage(); ?>>
			<?php $this->bentos["bento-20-4"]->render(); ?>
		</div>
	</div>
</div>