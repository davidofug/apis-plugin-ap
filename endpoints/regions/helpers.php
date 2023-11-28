<?php

    function get_region_by_id( $id ) {

        if(!$id || empty($id)) {
            return;
        }

        $region = get_post( (int) $id);

        if( !empty($region) ) {
            $the_region = (object) array(
                'id' => $region->ID,
                'name' => $region->post_title,
            );

            return new WP_REST_Response( [
                'result' => 'successful',
                'data' => $the_region,

            ], 200 );
        }

        return new WP_REST_Response( [
            'result' => 'failed',
            'data' => "Region id: {$id} not found",
            'error' => 'Region not found',
        ],404);
    }

    function get_all_regions($items = 10) {

        $args = array(
            'post_type' => 'region',
            'posts_per_page' => $items,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $regions = get_posts( $args );

        $the_regions = array();

        foreach( $regions as $region) {
            $the_regions[] = array(
                'id' => $region->ID,
                'name' => $region->post_title,
            );
        }

        if(count($regions) > 0) {
            return new WP_REST_Response( [
                'result' => 'successful',
                'regions' => $the_regions,
                'total' => count($regions),
            ], 200 );
        }

        return new WP_REST_Response( [
            'result' => 'failed',
            'data' => "No regions found",
            'error' => 'No regions found',
        ],404);

    }
