<div class="template" id="preview">
	<div id="column-18-1" class="padded column height33 width100" <?php $this->columns['column-18-1']->height_percentage(); ?>>
		<?php $this->bentos["bento-18-1"]->render(); ?>
	</div>
	<div id="column-18-2" class="padded column height33 width100" <?php $this->columns['column-18-2']->height_percentage(); ?>>
		<?php $this->bentos["bento-18-2"]->render(); ?>
	</div>
	<div id="column-18-3" class="column height33 width100" <?php $this->columns['column-18-3']->height_percentage(); ?>>
		<div id="column-18-4" class="padded column height100 width50" <?php $this->columns['column-18-4']->width_percentage(); ?>>
			<?php $this->bentos["bento-18-3"]->render(); ?>
		</div>
		<div id="column-18-5" class="padded column height100 width50" <?php $this->columns['column-18-5']->width_percentage(); ?>>
			<?php $this->bentos["bento-18-4"]->render(); ?>
		</div>
	</div>
</div>