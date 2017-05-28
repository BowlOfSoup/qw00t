import React from 'react'
var FetchQuotes = require('./Quote/FetchQuotes');

const Content = () => (
  <div id="content">
    <div className="row">
      <div className="col-md-4"></div>
      <div className="col-md-4"><FetchQuotes /></div>
      <div className="col-md-4"></div>
    </div>
  </div>
)
module.exports = Content;
