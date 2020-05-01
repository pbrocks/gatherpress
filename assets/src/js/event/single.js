import React from 'react';
import ReactDOM from 'react-dom';

const e = React.createElement;

class AttendanceButton extends React.Component {

	constructor( props ){
		super( props );

		this.state = {
			inputValue: 'Attend'
		};
	}

	update( evt ) {
		const requestOptions = {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': GatherPress.nonce,
			},
			body: JSON.stringify({
				status: 1,
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

		this.setState({
			inputValue: 'Not Attending'
		});
	}

	render() {
		return(
			<button
				type      = 'button'
				className = 'btn btn-primary btn-lg'
				onClick   ={ ( evt ) => this.update( evt ) }
			>
				{ this.state.inputValue }
			</button>
		);
	}
}

const domContainer = document.querySelector( '#attendance_button_container' );
ReactDOM.render( e( AttendanceButton ), domContainer );
