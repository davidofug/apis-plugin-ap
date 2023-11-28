<?php
    require_once UG_API_PLUGIN_DIR . "endpoints/regions/helpers.php";

    function regions_endpoint( $request ) {

        $params = $request->get_params();

        if( !empty( $params['id'] ) ) {
            return get_region_by_id( $params['id'] );
        }
        else {
            return get_all_regions();
        }

    }

    function attach_regions_endpoint() {
        register_rest_route( 'v1', '/regions/', array(
            'methods'  => 'GET',
            'callback' => 'regions_endpoint',
            'args' => array(
                'id' => array(
                    'required' => false,
                    'type' => 'int',
                    'description' => 'Data to be returned',
                    'default' => 0,
                ))
        ) );
    }

    add_action( 'rest_api_init',  'attach_regions_endpoint');
