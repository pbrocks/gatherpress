import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

export function updateAttendanceList( attendanceList ) {

	this.setState( { attendanceList } );

}

export function updateActiveNavigation( activeNavigation ) {

	this.setState( { activeNavigation } );

}

export class Attendance extends Component {

	constructor( props ) {
		super( props );

		updateAttendanceList   = updateAttendanceList.bind( this );
		updateActiveNavigation = updateActiveNavigation.bind( this );

		this.state = {
			attendanceList: GatherPress.attendees,
			activeNavigation: GatherPress.current_user_status
		};

		this.pages = [
			{
				name: __( 'Attending', 'gatherpress' ),
				slug: 'attending',
			},
			{
				name: __( 'Waitlist', 'gatherpress' ),
				slug: 'waitlist',
			},
			{
				name: __( 'Not Attending', 'gatherpress' ),
				slug: 'not_attending',
			},
		];

	}

	displayNavigation() {
		let nav = [],
			status  = this.state.activeNavigation;

		status = ( '' !== status ) ? status : 'attending';

		for ( let i = 0; i < this.pages.length; i++ ) {
			let item = this.pages[ i ];

			item.active = ( status === item.slug ) ? 'active' : '';

			nav.push(
				<a
					className     = { 'nav-item nav-link ' + item.active }
					id            = 'nav-attending-tab'
					data-toggle   = 'tab'
					href          = { '#nav-' + item.slug }
					role          = 'tab'
					aria-controls = 'nav-attending'
					aria-selected = 'true'
				>
					{ item.name }
				</a>
			);
		}

		return nav;

	}

	displayContent() {

		let content = [],
			status  = this.state.activeNavigation;

		status = ( '' !== status ) ? status : 'attending';

		for ( let i = 0; i < this.pages.length; i++ ) {
			this.pages[i].active
			let item = this.pages[i];

			item.active = ( status === item.slug ) ? 'active' : '';

			content.push(
				<div
					className       = { 'tab-pane fade show ' + item.active }
					id              = { 'nav-' + item.slug }
					role            = 'tabpanel'
					aria-labelledby = { 'nav-' + item.slug + '-tab' }
				>
					<div
						className = 'd-flex flex-row flex-wrap'
					>
						{ this.getAttendees( item.slug ) }
					</div>
				</div>
			)
		}

		return content;

	}

	getAttendees( slug ) {

		const attendeeData = this.state.attendanceList[ slug ].attendees;

		let attendees = [];

		for ( let i = 0; i < attendeeData.length; i++ ) {
			let attendee = attendeeData[ i ];

			attendees.push(
				<div
					className = 'p-2'
				>
					<a
						href = { attendee.profile }
					>
						<img
							className = 'img-thumbnail'
							alt       = { attendee.name }
							title     = { attendee.name }
							src       = { attendee.photo }
						/>
					</a>
					<h5
						className = 'mt-2 mb-0'
					>
						<a
							href = { attendee.profile }
						>
							{ attendee.name }
						</a>
					</h5>
					<h6
						className = 'text-muted'
					>
						{ attendee.role }
					</h6>
				</div>
			);
		}

		return attendees;

	}

	render() {
		return(
			<div
				className = 'mt-4'
			>
				<nav>
					<div
					className = 'nav nav-tabs mb-4'
					id        = 'attendance-nav'
					role      = 'tablist'
					>
						{ this.displayNavigation() }
					</div>
				</nav>
				<div
					className = 'tab-content p-3'
					id        = 'attendance-content'
				>
					{ this.displayContent() }
				</div>
			</div>
		);
	}
}
