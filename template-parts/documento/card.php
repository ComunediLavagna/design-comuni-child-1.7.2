<?php
global $documento;
?>
<div class="card card-teaser shadow-sm p-4s rounded border border-light flex-nowrap">
	<svg class="icon" aria-hidden="true">
		<use xlink:href="#it-clip"></use>
	</svg>
	<div class="card-body">
		<p class="h5 card-title">
			<a href="<?php echo get_permalink($documento->ID); ?>">
				<?php echo $documento->post_title; ?>
			</a>
		</p>
		<div class="card-text">
			<p>
				<?php echo dci_get_meta('descrizione_breve','_dci_documento_pubblico_',$documento->ID); ?>
			</p>
		</div>
	</div>
</div>