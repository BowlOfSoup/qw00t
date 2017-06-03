import 'babel-polyfill';
import React from 'react';
import ReactDOM from 'react-dom'
import { BrowserRouter, Route } from 'react-router-dom'
import {Provider} from 'react-redux';
import css from './style.scss';
import App from './components/app.jsx';
import Home from './components/home.jsx';
import configureStore from './store/configureStore';

function scrollTop(nextState, replace) {
   window.scrollTo(0, 0)
}

const store = configureStore();

ReactDOM.render(
  <Provider store={store}>

    <BrowserRouter>
        <Route path="/" component={Home} />
    </BrowserRouter>
  </Provider>,
  document.getElementById('app')
);
