// Checks if the post type is for events.
export function isEventPostType() {
	const getPostType = wp.data.select( 'core/editor' ).getCurrentPostType(); // Gets the current post type.

	return ( getPostType === 'gp_event' );
}
