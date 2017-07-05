<?php if ($this->Session->read('Message')) : ?>
		<?php echo $this->Session->flash(); ?>
<?php endif; ?>
