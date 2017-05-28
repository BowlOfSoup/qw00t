import React from 'react'
import logo from './LogoQw00tTransparent.png';
import {Button} from 'react-bootstrap';

const Header = () => (
  <div id="header">
    <div className="row">
      <div className="col-md-4 content-align-right"><img id="app-logo" src={logo} alt="Logo" /></div>
      <div className="col-md-4 content-align-center">
        <Button
          bsStyle="primary"
          bsSize="medium"
          href="/">
          Reload
        </Button>
      </div>
      <div className="col-md-4"></div>
    </div>
  </div>
)
module.exports = Header;
