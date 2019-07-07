
class ImageUpload {
	public static function SetImageUpload($header_featured, $postId, $featuredsetImage = true, $metaKey = null){
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
		$featured_img = wp_handle_upload( $header_featured, array('test_form' => false ) );
        $filename = $featured_img['file'];

        $attachment = array(
            'post_mime_type' => $featured_img['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $featured_img['url']
        );

        $attachment_id = wp_insert_attachment( $attachment, $featured_img['url'] );
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
		wp_update_attachment_metadata( $attachment_id, $attachment_data );
		
		if($featuredsetImage == true){
			if( 0 < intval( $attachment_id ) ) {
				echo "Set Image Upload";
			return set_post_thumbnail( $postId, $attachment_id );
			}
		}else{
			add_post_meta($postId, $metaKey, $attachment_id);
			echo "Upload Meta Image";
		}

	}
}
