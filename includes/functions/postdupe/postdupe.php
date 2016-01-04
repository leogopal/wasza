<?php

function dupe_confirmation() {    
	echo "<div class='updated'><p>Post has been duplicated to Wallart UK.</p></div>";
}

if ($_GET['duped'] == 'yes') { 
	add_action('admin_notices', 'dupe_confirmation');
}

/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){
	global $wpdb;

    $newmydb = new wpdb('comwalla_uk','!T$kiTvS@~f#','comwalla_uk','localhost');



	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	/*
	 * get the original post id
	 */

	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
    $post = get_post( $post_id );

    $newe = new WC_Admin_Duplicate_Product();
    $newe->duplicate_product_action($post_id);
    wp_redirect( admin_url( 'edit.php?duped=yes&post_type='.$post->post_type ) );
    exit;


	/*
	 * and all the original post data then
	 */

 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */

        $args = array(
            'posts_per_page'   => 100,
            'offset'           => 0,
            'category'         => '',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'product_variation',
            'post_mime_type'   => '',
            'post_parent'      => $post->ID,
            'post_status'      => 'publish',
            'suppress_filters' => true );
        $myvariations = get_posts( $args );


		// create the actual post
        $sql = "INSERT INTO wa_posts VALUES ('','".$new_post_author."',"."'".$post->post_date."',"."'".$post->post_date_gmt."',"."'".addslashes($post->post_content)."',"."'".addslashes($post->post_title)."',"."'".$post->post_excerpt."',"."'draft',"."'".$post->comment_status."',"."'".$post->ping_status."',"."'".$post->post_password."',"."'".$post->post_name."',"."'".$post->to_ping."',"."'".$post->pinged."',"."'".$post->post_modified."',"."'".$post->post_modified_gmt."',"."'".$post->post_content_filtered."',"."'".$post->post_parent."',"."'".str_replace('.com', '.com/uk', $post->guid)."',"."'".$post->menu_order."',"."'".$post->post_type."',"."'".$post->post_mime_type."',"."'".$post->comment_count."')";
        $newmydb->query($sql);
		$result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
        $new_post_id = $result->ID;


		// create the blank jpg
        $sql = "INSERT INTO wa_posts VALUES ('','".$new_post_author."',"."'".$post->post_date."',"."'".$post->post_date_gmt."',"."'".addslashes($post->post_content)."',"."'".addslashes(get_post_meta($post->ID, 'blank_jpg', true))."',"."'".$post->post_excerpt."',"."'inherit',"."'".$post->comment_status."',"."'".$post->ping_status."',"."'".$post->post_password."',"."'".$post->post_name."',"."'".$post->to_ping."',"."'".$post->pinged."',"."'".$post->post_modified."',"."'".$post->post_modified_gmt."',"."'".$post->post_content_filtered."',"."'".$new_post_id."',"."'".get_field('blank_jpg', $post->ID)."',"."'".$post->menu_order."',"."'attachment',"."'image/jpeg',"."'".$post->comment_count."')";
        $newmydb->query($sql);
		$result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
        $blankjpgID = $result->ID;
        

		// create the svg file
        $sql = "INSERT INTO wa_posts VALUES ('','".$new_post_author."',"."'".$post->post_date."',"."'".$post->post_date_gmt."',"."'".addslashes($post->post_content)."',"."'".addslashes(get_post_meta($post->ID, 'svg_file', true))."',"."'".$post->post_excerpt."',"."'inherit',"."'".$post->comment_status."',"."'".$post->ping_status."',"."'".$post->post_password."',"."'".$post->post_name."',"."'".$post->to_ping."',"."'".$post->pinged."',"."'".$post->post_modified."',"."'".$post->post_modified_gmt."',"."'".$post->post_content_filtered."',"."'".$new_post_id."',"."'".wp_get_attachment_url(get_field('svg_file', $post->ID))."',"."'".$post->menu_order."',"."'attachment',"."'image/svg+xml',"."'".$post->comment_count."')";
        $newmydb->query($sql);
		$result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
        $svgfileID = $result->ID;
        


		/*
		 * get all current post terms ad set them to the new post draft
		 */

        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
        if (isset($thumbnail[0]))
            $img = $thumbnail[0];
        else
            $img = '';


		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'slugs'));
            //var_dump($taxonomy);
            //var_dump($post_terms);
            //echo "http://wallartstudios.com/uploadtouk.php?newid=".$new_post_id."&post_terms=".urlencode(json_encode($post_terms)). "&taxonomy=".$taxonomy;
            echo file_get_contents("http://wallartstudios.com/uploadtouk.php?newid=".$new_post_id."&post_terms=".urlencode(json_encode($post_terms)). "&taxonomy=".$taxonomy."&img=".$img);
            //echo '<br />';
			//wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
        //print_r($myvariations);


		/*
		 * duplicate all post meta
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if ($meta_key == "blank_jpg") {
					$meta_value = $blankjpgID;
				} elseif ($meta_key == "svg_file") {
					$meta_value = $svgfileID;
				} else {
					$meta_value = addslashes($meta_info->meta_value);
				}
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			/**
			 * MARK : This is where we create a new connection to the new DB and update the query on there. 
			 */

			$newmydb->query($sql_query);
		}

        foreach ($myvariations as $thepost)
        {
            $sql = "INSERT INTO wa_posts VALUES ('','".$new_post_author."',"."'".$thepost->post_date."',"."'".$thepost->post_date_gmt."',"."'".addslashes($thepost->post_content)."',"."'".addslashes($thepost->post_title)."',"."'".$thepost->post_excerpt."',"."'".$thepost->post_status."',"."'".$thepost->comment_status."',"."'".$thepost->ping_status."',"."'".$thepost->post_password."',"."'".$thepost->post_name."',"."'".$thepost->to_ping."',"."'".$thepost->pinged."',"."'".$thepost->post_modified."',"."'".$thepost->post_modified_gmt."',"."'".$thepost->post_content_filtered."',"."'".$new_post_id."',"."'".str_replace('.com', '.com/uk', $thepost->guid)."',"."'".$thepost->menu_order."',"."'".$thepost->post_type."',"."'".$thepost->post_mime_type."',"."'".$thepost->comment_count."')";
            //echo $sql;
            $newmydb->query($sql);
            $result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
            $the_id_now = $result->ID;

            $thepost_ofmeta = $thepost->ID;
            $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$thepost_ofmeta");
            print_r($post_meta_infos);
            if (count($post_meta_infos)!=0)
            {
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ($post_meta_infos as $meta_info) {
                    $meta_key = $meta_info->meta_key;
                    if ($meta_key == "blank_jpg") {
                        $meta_value = $blankjpgID;
                    } elseif ($meta_key == "svg_file") {
                        $meta_value = $svgfileID;
                    } else {
                        $meta_value = addslashes($meta_info->meta_value);
                    }
                    $sql_query_sel[]= "SELECT $the_id_now, '$meta_key', '$meta_value'";
                }
                $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                print_r($sql_query_sel);
                $newmydb->query($sql_query);
            }
            echo '<br />';
        }

		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		//wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		wp_redirect( admin_url( 'edit.php?duped=yes&post_type='.$post->post_type ) );
		
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicated'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Copy to Wallart UK</a>';
	}
	return $actions;
}


if (ukorza() == 'za') { 
	add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
	add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );
	add_filter( 'product_row_actions', 'rd_duplicate_post_link', 1000, 2 );
}


    /**
     * WC_Admin_Duplicate_Product Class
     */
    class WC_Admin_Duplicate_Product {

        /**
         * Constructor
         */
        public function __construct() {
            //add_action( 'admin_action_duplicate_product', array( $this, 'duplicate_product_action' ) );
            //add_filter( 'post_row_actions', array( $this, 'dupe_link' ), 10, 2 );
            //add_filter( 'page_row_actions', array( $this, 'dupe_link' ), 10, 2 );
            //add_action( 'post_submitbox_start', array( $this, 'dupe_button' ) );
        }

        /**
         * Show the "Duplicate" link in admin products list
         * @param  array   $actions
         * @param  WP_Post $post Post object
         * @return array
         */
        public function dupe_link( $actions, $post ) {
            if ( ! current_user_can( apply_filters( 'woocommerce_duplicate_product_capability', 'manage_woocommerce' ) ) )
                return $actions;

            if ( $post->post_type != 'product' )
                return $actions;

            $actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'edit.php?post_type=product&action=duplicate_product&amp;post=' . $post->ID ), 'woocommerce-duplicate-product_' . $post->ID ) . '" title="' . __( 'Make a duplicate from this product', 'woocommerce' )
                . '" rel="permalink">' .  __( 'Duplicate', 'woocommerce' ) . '</a>';

            return $actions;
        }

        /**
         * Show the dupe product link in admin
         */
        public function dupe_button() {
            global $post;

            if ( ! current_user_can( apply_filters( 'woocommerce_duplicate_product_capability', 'manage_woocommerce' ) ) )
                return;

            if ( ! is_object( $post ) )
                return;

            if ( $post->post_type != 'product' )
                return;

            if ( isset( $_GET['post'] ) ) {
                $notifyUrl = wp_nonce_url( admin_url( "edit.php?post_type=product&action=duplicate_product&post=" . absint( $_GET['post'] ) ), 'woocommerce-duplicate-product_' . $_GET['post'] );
                ?>
                <div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Copy to a new draft', 'woocommerce' ); ?></a></div>
            <?php
            }
        }

        /**
         * Duplicate a product action.
         */
        public function duplicate_product_action($id = null) {

            $post = $this->get_product_to_duplicate( $id );

            // Copy the page and insert it
            if ( ! empty( $post ) ) {
                $new_id = $this->duplicate_product( $post );
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($id), full );
                if (isset($thumbnail[0]))
                    $img = $thumbnail[0];
                else
                    $img = '';

                $url = "http://wallartstudios.com/uploadtouk.php?type=img&newid=".$new_id."&img=".$img;

                echo file_get_contents($url);

                $url = "http://wallartstudios.com/uploadtouk.php?type=update&newid=".$new_id;

                echo file_get_contents($url);

                //wp_redirect( admin_url( 'edit.php?duped=yes&post_type='.$post->post_type ) );


                // If you have written a plugin which uses non-WP database tables to save
                // information about a page you can hook this action to dupe that data.
                //do_action( 'woocommerce_duplicate_product', $new_id, $post );

                // Redirect to the edit screen for the new draft page
                //wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
                //exit;
            } else {
                wp_die(__( 'Product creation failed, could not find original product:', 'woocommerce' ) . ' ' . $id );
            }
        }

        /**
         * Function to create the duplicate of the product.
         *
         * @access public
         * @param mixed $post
         * @param int $parent (default: 0)
         * @param string $post_status (default: '')
         * @return int
         */
        public function duplicate_product( $post, $parent = 0, $post_status = '' ) {
            global $wpdb;
            $newmydb = new wpdb('comwalla_uk','!T$kiTvS@~f#','comwalla_uk','localhost');

            $new_post_author 	= wp_get_current_user();
            $new_post_date 		= current_time('mysql');
            $new_post_date_gmt 	= get_gmt_from_date($new_post_date);

            if ( $parent > 0 ) {
                $post_parent		= $parent;
                $post_status 		= $post_status ? $post_status : 'publish';
                $suffix 			= '';
            } else {
                $post_parent		= $post->post_parent;
                $post_status 		= $post_status ? $post_status : 'publish';
                $suffix 			= ' ' . __( '', 'woocommerce' );
            }

            $new_post_type 			= $post->post_type;
            $post_content    		= str_replace("'", "''", $post->post_content);
            $post_content_filtered 	= str_replace("'", "''", $post->post_content_filtered);
            $post_excerpt    		= str_replace("'", "''", $post->post_excerpt);
            $post_title      		= str_replace("'", "''", $post->post_title).$suffix;
            $comment_status  		= str_replace("'", "''", $post->comment_status);
            $ping_status     		= str_replace("'", "''", $post->ping_status);

            $ar = array(
                'post_author'				=> $new_post_author->ID,
                'post_date'					=> $new_post_date,
                'post_date_gmt'				=> $new_post_date_gmt,
                'post_content'				=> $post_content,
                'post_content_filtered'		=> $post_content_filtered,
                'post_title'				=> $post_title,
                'post_excerpt'				=> $post_excerpt,
                'post_status'				=> $post_status,
                'post_type'					=> $new_post_type,
                'comment_status'			=> $comment_status,
                'ping_status'				=> $ping_status,
                'post_password'				=> $post->post_password,
                'to_ping'					=> $post->to_ping,
                'pinged'					=> $post->pinged,
                'post_modified'				=> $new_post_date,
                'post_modified_gmt'			=> $new_post_date_gmt,
                'post_parent'				=> $post_parent,
                'menu_order'				=> $post->menu_order,
                'post_mime_type'			=> $post->post_mime_type
            );
            //print_r($ar);

            // Insert the new template in the post table
            $newmydb->insert(
                $wpdb->posts,
                array(
                    'post_author'				=> $new_post_author->ID,
                    'post_date'					=> $new_post_date,
                    'post_date_gmt'				=> $new_post_date_gmt,
                    'post_content'				=> $post_content,
                    'post_content_filtered'		=> $post_content_filtered,
                    'post_title'				=> $post_title,
                    'post_excerpt'				=> $post_excerpt,
                    'post_status'				=> 'publish',
                    'post_type'					=> $new_post_type,
                    'comment_status'			=> $comment_status,
                    'ping_status'				=> $ping_status,
                    'post_password'				=> $post->post_password,
                    'to_ping'					=> $post->to_ping,
                    'pinged'					=> $post->pinged,
                    'post_modified'				=> $new_post_date,
                    'post_modified_gmt'			=> $new_post_date_gmt,
                    'post_parent'				=> $post_parent,
                    'menu_order'				=> $post->menu_order,
                    'post_mime_type'			=> $post->post_mime_type
                )
            );

            $new_post_id = $newmydb->insert_id;



            // create the blank jpg
            $sql = "INSERT INTO $wpdb->posts VALUES ('','".$new_post_author->ID."',"."'".$post->post_date."',"."'".$post->post_date_gmt."',"."'".addslashes($post->post_content)."',"."'".addslashes(get_post_meta($post->ID, 'blank_jpg', true))."',"."'".$post->post_excerpt."',"."'inherit',"."'".$post->comment_status."',"."'".$post->ping_status."',"."'".$post->post_password."',"."'".$post->post_name."',"."'".$post->to_ping."',"."'".$post->pinged."',"."'".$post->post_modified."',"."'".$post->post_modified_gmt."',"."'".$post->post_content_filtered."',"."'".$new_post_id."',"."'".get_field('blank_jpg', $post->ID)."',"."'".$post->menu_order."',"."'attachment',"."'image/jpeg',"."'".$post->comment_count."')";
            $newmydb->query($sql);

            $result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
            $blankjpgID = $result->ID;


            // create the svg file
            $sql = "INSERT INTO wa_posts VALUES ('','".$new_post_author->ID."',"."'".$post->post_date."',"."'".$post->post_date_gmt."',"."'".addslashes($post->post_content)."',"."'".addslashes(get_post_meta($post->ID, 'svg_file', true))."',"."'".$post->post_excerpt."',"."'inherit',"."'".$post->comment_status."',"."'".$post->ping_status."',"."'".$post->post_password."',"."'".$post->post_name."',"."'".$post->to_ping."',"."'".$post->pinged."',"."'".$post->post_modified."',"."'".$post->post_modified_gmt."',"."'".$post->post_content_filtered."',"."'".$new_post_id."',"."'".wp_get_attachment_url(get_field('svg_file', $post->ID))."',"."'".$post->menu_order."',"."'attachment',"."'image/svg+xml',"."'".$post->comment_count."')";
            $newmydb->query($sql);
            $result = $newmydb->get_row('SELECT ID FROM wa_posts ORDER BY ID DESC LIMIT 1');
            $svgfileID = $result->ID;


            // Copy the taxonomies
            $this->duplicate_post_taxonomies( $post->ID, $new_post_id, $post->post_type );

            // Copy the meta information
            $this->duplicate_post_meta( $post->ID, $new_post_id , $blankjpgID , $svgfileID );

            // Copy the children (variations)
            if ( $children_products = get_children( 'post_parent='.$post->ID.'&post_type=product_variation' ) ) {

                if ( $children_products )
                    foreach ( $children_products as $child )
                        $this->duplicate_product( $this->get_product_to_duplicate( $child->ID ), $new_post_id, $child->post_status );
            }

            return $new_post_id;
        }

        /**
         * Get a product from the database to duplicate

         * @access public
         * @param mixed $id
         * @return WP_Post|bool
         * @todo Returning false? Need to check for it in...
         * @see duplicate_product
         */
        private function get_product_to_duplicate( $id ) {
            global $wpdb;

            $id = absint( $id );

            if ( ! $id )
                return false;

            $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );

            if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
                $id   = $post->post_parent;
                $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
            }
            return $post[0];
        }

        /**
         * Copy the taxonomies of a post to another post
         *
         * @access public
         * @param mixed $id
         * @param mixed $new_id
         * @param mixed $post_type
         * @return void
         */
        private function duplicate_post_taxonomies( $id, $new_id, $post_type ) {
            global $wpdb;

            $newmydb = new wpdb('comwalla_uk','!T$kiTvS@~f#','comwalla_uk','localhost');

            $taxonomies = get_object_taxonomies($post_type); //array("category", "post_tag");
            foreach ($taxonomies as $taxonomy) {
                $post_terms = wp_get_object_terms($id, $taxonomy);
                $post_terms_count = sizeof( $post_terms );
                for ($i=0; $i<$post_terms_count; $i++) {
                    wp_set_object_terms($new_id, $post_terms[$i]->slug, $taxonomy, true);
                    $url = "http://wallartstudios.com/uploadtouk.php?type=term&newid=".$new_id."&post_terms=".$post_terms[$i]->slug. "&taxonomy=".$taxonomy;
                    echo file_get_contents($url);
                }
            }
        }


        /**
         * Copy the meta information of a post to another post
         *
         * @access public
         * @param mixed $id
         * @param mixed $new_id
         * @return void
         */
        private function duplicate_post_meta( $id, $new_id , $blankjpgID = null ,$svgfileID = null  ) {
            global $wpdb;
            $newmydb = new wpdb('comwalla_uk','!T$kiTvS@~f#','comwalla_uk','localhost');

            $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$id");

            if (count($post_meta_infos)!=0) {
                $sql_query_sel = array();
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ($post_meta_infos as $meta_info) {
                    $meta_key = $meta_info->meta_key;
                    if ($meta_key == "blank_jpg") {
                        $meta_value = $blankjpgID;
                    } elseif ($meta_key == "svg_file") {
                        $meta_value = $svgfileID;
                    } else {
                        $meta_value = addslashes($meta_info->meta_value);
                    }
                    $sql_query_sel[]= "SELECT $new_id, '$meta_key', '$meta_value'";
                }
                $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                $newmydb->query($sql_query);
            }
        }

    }