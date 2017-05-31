import React from 'react'
import logo from './LogoQw00tTransparent.png';
import { Button } from 'reactstrap';

export default class Header extends React.Component {
  reload() {
    location.reload();
  }

  render() {
    return (
      <div id="header">
        <div className="row">
          <div className="col content-align-right"><img id="app-logo" src={logo} alt="Logo" /></div>
          <div className="col content-align-center my-auto"><Button color="primary" onClick={this.reload}>Randomize.</Button></div>
          <div className="col"></div>
        </div>
      </div>
    );
  }
}

module.exports = Header;
