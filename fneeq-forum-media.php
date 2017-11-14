<?php
/**
 * Plugin Name:     FNEEQ forum médias
 * Plugin URI:      https://github.com/mykedean/fneeq-forum-media
 * Description:     Comportement personnalisé pour les médias ajoutés sur les forums bbpress de FNEEQ.
 * Author:          Michael Dean
 * Author URI:      https://github.com/mykedean
 * Text Domain:     fneeq-forum-media
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Fneeq_Forum_Media
 */

/**
 * This plugin depends on the installation of gd-bbpress-attachments.
 * https://wordpress.org/plugins/gd-bbpress-attachments/
 *
 * @TODO Add verification that GD bbPress Attachments is installed or provide a message to the user if not.
 * @TODO Error handling if the GD bbPress Attachments plugin is not available.
 */


/**
 * Assigns a term from the secteur taxonomy to media uploaded from the forums.
 *
 * @TODO get the attachment ID
 * @TODO Test hooks.
 * @TODO Add error handling in case no term is found for the forum, or create a term for the forum.
 */

add_action( 'add_attachment', 'fneeq_assign_secteur_to_media' );

function fneeq_assign_secteur_to_media( $attachment_id) {
        $taxonomy_name = 'category';

	//Get the WP_Post object for the current attachment that has been uploaded.
	$attachment = get_post( $attachment_id );
	
	//Get the WP_Post object of the attachment's parent post
	$post_parent_id = $attachment->post_parent;
	$post_parent = get_post( $post_parent_id );

	//If the parent post is a topic, tag the attachment with the name of the topic's forum.
	if( 'topic' === $post_parent->post_type ) {	

		//For readability. The parent post is a topic.
		$topic_post = $post_parent;	
		
		//Get the forum name of the topic
		$forum_name = bbp_get_forum( $topic_post->post_parent )->post_name;
	
		//Tag the attachment with the name of the forum as a category	
		var_dump(wp_set_object_terms( $attachment_id, $forum_name, $taxonomy_name, true ));
		die;
	}
}
