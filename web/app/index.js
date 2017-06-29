import 'babel-polyfill';
import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/app.jsx';
import { BrowserRouter, Route } from 'react-router-dom'
import {Provider} from 'react-redux';
import css from './style.scss';
import configureStore from './store/configureStore';

function scrollTop(nextState, replace) {
   window.scrollTo(0, 0)
}

const store = configureStore();

ReactDOM.render(
  <Provider store={store}>

    <BrowserRouter>
      <App />
    </BrowserRouter>
  </Provider>,
  document.getElementById('app')
);
