import React from 'react';
import ReactDOM from 'react-dom';

const e = React.createElement;

class AttendanceButton extends React.Component {
	render() {
		return(
			<button type="button" className="btn btn-primary btn-lg">
				Attend
			</button>
		);
	}
}

const domContainer = document.querySelector( '#attendance_button_container' );
ReactDOM.render( e( AttendanceButton ), domContainer );

