import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

export class AttendanceButton extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			inputValue: __( 'Attend', 'gatherpress' )
		};
	}

	changeSelection( evt ) {
	console.log(this.props);
		evt.preventDefault();
		this.setState({
			inputValue: evt.target.textContent
		});
	}

	updateStatus( evt ) {
		const requestOptions = {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': GatherPress.nonce,
			},
			body: JSON.stringify({
				status: 1,
				post_id: GatherPress.post_id,
				_wpnonce: GatherPress.nonce
			})
		};
		fetch(
			GatherPress.event_rest_api + 'attendance', requestOptions
		).then( results => {
			return results.json();
		}).then( data => {
			console.log(data);
		});
	}

	render() {
		return(
			<div
				className  = 'btn-group'
			>
				<div
					className  = 'btn-group'
					role       = 'group'
				>
					<div
						className = 'btn-group'
						role      = 'group'
					>
						<button
							type          = 'button'
							className     = 'btn btn-primary dropdown-toggle'
							data-toggle   = 'dropdown'
							aria-haspopup = 'true'
							aria-expanded = 'false'
						>
						</button>
						<div
							className       = 'dropdown-menu'
						>
							<a
								className  = 'dropdown-item'
								href       = 'https://google.com/'
								data-value = '1'
								onClick    = { ( evt ) => this.changeSelection( evt ) }
							>
								{ __( 'Attending', 'gatherpress' ) }
							</a>
							<a
								className  = 'dropdown-item'
								href       = '#'
								data-value = '0'
								onClick    = { ( evt ) => this.changeSelection( evt ) }
							>
								{ __( 'Not Attending', 'gatherpress' ) }
							</a>
						</div>
					</div>
					<button
						type      = 'button'
						className = 'btn btn-primary btn-lg'
						onClick   = { ( evt ) => this.updateStatus( evt ) }
					>
						{ this.state.inputValue }
					</button>
				</div>
			</div>
		);
	}
}
