import React from 'react'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/css/bootstrap-theme.css';
require('./Base/style.css');
var ReactDOM = require('react-dom');
var Header = require('./Base/Header');
var Content = require('./Content');

const Container = () => (
  <div id="container">
    <Header />
    <Content />
  </div>
)

class Index extends React.Component {
  render() {
    return <Container />
  }
}

ReactDOM.render(
  <Index />,
  document.getElementById('app')
);
