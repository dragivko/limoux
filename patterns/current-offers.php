<?php
/**
 * Title: Current Offers
 * Slug: limoux/current-offers
 * Categories: limoux
 */
?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} --><h3>Current Offers</h3><!-- /wp:heading --><!-- wp:query {"query":{"postType":"promotion","perPage":3}} -->
<div class="wp-block-query"><!-- wp:post-template --><!-- wp:group {"className":"limoux-card"} -->
<div class="wp-block-group limoux-card"><!-- wp:post-title {"isLink":true} /--><!-- wp:post-excerpt /--></div>
<!-- /wp:group --><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
