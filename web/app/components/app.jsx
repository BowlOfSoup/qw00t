import React from 'react';
import {Link} from 'react-router';
import { connect } from 'react-redux';

class App extends React.Component{
  render() {
    return(
      <div>
        <main className="main container">
          {this.props.children}
        </main>
      </div>
    )
  }
}

export default App;
