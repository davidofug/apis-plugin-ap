<?php

    function tourist_attractions_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'tourist-attraction',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $tourist_attractions = get_posts( $args );

        $the_tourist_attractions = array();

        foreach( $tourist_attractions as $tourist_attraction) {
            $region_ids_arr = get_post_meta( $tourist_attraction->ID, 'regions', true);

            foreach($region_ids_arr as $region_id) {
                $regions[] = (object) array(
                    'id' => (int)$region_id,
                    'name'=> get_the_title($region_id)
                );
            }

            $district_ids_arr = get_post_meta( $tourist_attraction->ID, 'districts', true);

            foreach($district_ids_arr as $district_id) {
                $districts[] = (object) array(
                    'id' => (int) $district_id,
                    'name' => get_the_title($district_id)
                );
            }

            $county_ids_arr = get_post_meta( $tourist_attraction->ID, 'counties', true);

            foreach($county_ids_arr as $county_id) {
                $counties[] = (object) array(
                    'id' => (int) $county_id,
                    'name' => get_the_title($county_id)
                );
            }

            $sub_county_ids_arr = get_post_meta( $tourist_attraction->ID, 'sub-counties', true);

            foreach($sub_county_ids_arr as $sub_county_id) {
                $sub_counties[] = (object) array(
                    'id' => (int) $sub_county_id,
                    'name' => get_the_title($sub_county_id)
                );
            }

            $parish_ids_arr = get_post_meta( $parish->ID, 'parishes', true);

            $sub_parish_ids_arr = get_post_meta( $parish->ID, 'sub-parishes', true);

            $village_ids_arr = get_post_meta( $parish->ID, 'villages', true);

            $native_name = get_post_meta( $tourist_attraction->ID, 'native-name', true);

            $adapted_name = get_post_meta( $tourist_attraction->ID, 'adapted-name', true);

            $photo = get_post_meta( $tourist_attraction->ID, 'photo', true);

            $video = get_post_meta( $tourist_attraction->ID, 'video', true);

            $the_tourist_attractions[] = array(
                'id' => $tourist_attraction->ID,
                'name' => $tourist_attraction->post_title,
                'regions' => $regions,
                'districts' => $districts,
                'counties' => $counties,
                'subcounties' => $sub_counties,
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'tourist_attractions' => $the_tourist_attractions,
            'total' => count($the_tourist_attractions),
        ], 200 );
    }

    function add_tourist_attractions_endpoint() {
        register_rest_route( 'v1', '/tourist-attractions/', array(
            'methods'  => 'GET',
            'callback' => 'tourist_attractions_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_tourist_attractions_endpoint');
