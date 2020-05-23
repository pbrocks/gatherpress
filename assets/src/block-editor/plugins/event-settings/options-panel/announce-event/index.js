import React, { Component } from 'react';
import { Button, PanelRow } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';

const { __ } = wp.i18n;

export class AnnounceEvent extends Component {

	constructor( props ) {
		super( props );

	}

	announce() {
		apiFetch({
				path: '/gatherpress/v1/event/announce/',
				method: 'POST',
				data: {
					post_id: GatherPress.post_id,
					_wpnonce: GatherPress.nonce,
				},
		}).then( ( res) => {
			console.log(res);
			// Saved.
		});
	}

	render() {
		return(
			<section>
				<h3>{ __( 'Options', 'gatherpress' ) }</h3>
				<PanelRow>
					<span>
						{ __( 'Announce event', 'gatherpress' ) }
					</span>
					<Button
						className = 'components-button is-primary'
						onClick   = { () => this.announce() }
					>
						{ __( 'Send', 'gatherpress' ) }
					</Button>
				</PanelRow>
			</section>
		);
	}

}
