import React from 'react';
import PropTypes from 'prop-types';

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      txt: 'this is the state txt',
      cat: 0
    }
  }

  update( e ) {
    this.setState({txt: e.target.value})
  }

  render() {
    let txt = this.props.txt
    return (
      <div>
        <h1>Hello World</h1>
        <b>Bold, or not?</b><br />
        <span>{txt}</span><br />
        <span>{this.state.txt}</span><br />
        <div>
          <Widget update={this.update.bind(this)} />
        </div>
      </div>
    )
  }
}

App.defaultProps = {
  txt: "Default txt property content."
}

App.propTypes = {
  txt: PropTypes.string,
  cat: PropTypes.number.isRequired
}

const Widget = (props) =>
  <input type="text" onChange={props.update} />

export default App
