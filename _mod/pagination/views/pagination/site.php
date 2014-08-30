
	<?php if ($first_page !== FALSE): ?>
		<span><a class="prev" href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><?php echo __('first') ?></a></span>
	<?php else: ?>
		<span><?php echo __('first') ?></span>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<span><a class="prev" href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><?php echo __('previous') ?></a></span>
	<?php else: ?>
		<span><?php echo __('previous') ?></span>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<span class="active"><?php echo $i ?></span>
		<?php else: ?>
			<span><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></span>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<span><a class="next" href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><?php echo __('next') ?></a></span>
	<?php else: ?>
		<span><?php echo __('next') ?></span>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<span><a class="next" href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last"><?php echo __('last') ?></a></span>
	<?php else: ?>
		<span><?php echo __('last') ?></span>
	<?php endif ?>
