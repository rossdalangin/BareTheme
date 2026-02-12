<?php
return array(
    'title'      => __( 'Practice Areas Grid', 'closeclient-agency-theme' ),
    'categories' => array( 'columns', 'text' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Our Practice Areas</h2>
    <!-- /wp:heading -->

    <!-- wp:spacer {"height":"2rem"} -->
    <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:columns -->
    <div class="wp-block-columns">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":4} -->
            <h4>Corporate Law</h4>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>We provide comprehensive legal services for businesses of all sizes, from startups to established corporations.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":4} -->
            <h4>Intellectual Property</h4>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Protecting your ideas and innovations is our priority. We handle patents, trademarks, copyrights, and trade secrets.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":4} -->
            <h4>Litigation</h4>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Our experienced litigators represent clients in a wide range of disputes, from simple to complex.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->',
);
