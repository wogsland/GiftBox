<div class="template" id="preview">
	<div id="column-21-1" class="column height100 width50" <?php $this->columns['column-21-1']->width_percentage(); ?>>
		<div id="column-21-3" class="padded column height33 width100" <?php $this->columns['column-21-3']->height_percentage(); ?>>
			<?php $this->bentos["bento-21-1"]->render(); ?>
		</div>
		<div id="column-21-4" class="padded column height33 width100" <?php $this->columns['column-21-4']->height_percentage(); ?>>
			<?php $this->bentos["bento-21-2"]->render(); ?>
		</div>
		<div id="column-21-5" class="padded column height33 width100" <?php $this->columns['column-21-5']->height_percentage(); ?>>
			<?php $this->bentos["bento-21-3"]->render(); ?>
		</div>
	</div>
	<div id="column-21-2" class="padded column height100 width50" <?php $this->columns['column-21-2']->width_percentage(); ?>>
		<?php $this->bentos["bento-21-4"]->render(); ?>
	</div>
</div>