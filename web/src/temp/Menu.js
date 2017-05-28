import React from 'react'
import {Link} from 'react-router-dom'

const Menu = () => (
  <ul>
    <li><Link to="/">Home</Link></li>
    <li><Link to="/quotes">Quotes</Link></li>
  </ul>
)
module.exports = Menu;
