/**
 * Internal dependencies
 */
import './blocks';
import './filters';
import './plugins';

// svg code
import gatherPressIcon from './../images/gatherpress-icon';

// alter the icon slot
wp.blocks.updateCategory( 'gatherpress', {
    icon: gatherPressIcon
} );
