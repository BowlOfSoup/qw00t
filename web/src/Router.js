import React from 'react'
import {
  BrowserRouter,
  Route
} from 'react-router-dom'
var Menu = require('./Menu');
var FetchQuotes = require('./Quote/FetchQuotes');

const Home = () => (
  <div>
    <h2>Home</h2>
  </div>
)

const Quotes = () => (
  <FetchQuotes />
)

const Router = () => (
  <BrowserRouter>
    <div>
      <Menu />

      <hr/>

      <Route exact path="/" component={Home}/>
      <Route path="/quotes" component={Quotes}/>
    </div>
  </BrowserRouter>
)
module.exports = Router;
