import * as types from './actionTypes';

export function registerSuccess(data) {
  return {
    type: types.REGISTER_SUCCESS,
    data: data
  };
}

export function loginSuccess(data) {
  return {
    type: types.LOGIN_SUCCESS,
    data: data
  };
}

export const register = (data) => {
  return function(dispatch) {
    console.log(data)
    fetch('http:///qwoot.faiawuks.com/api/users', {
      method: 'POST',
      mode: 'no-cors',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',

        'X-qwoot': 'woot'
      },
      body: JSON.stringify({
        name: data.userdata.name,
        username: data.userdata.username,
        password: data.userdata.password,
        email: data.userdata.email
      })
    })
      .then(function(response) {
        dispatch(registerSuccess(response.data));
      })
      .catch(function() {
        console.log(arguments)
      });
  }
}

export const login = (data) => {
  return function(dispatch) {
    fetch('http:///qwoot.faiawuks.com/api/login', {
      method: 'POST',
      mode: 'cors',
      headers: new Headers({
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Access-Token': data.userdata.username + ':' + data.userdata.password
      })
    })
      .then(function(response) {
        dispatch(registerSuccess(response.data));
      })
      .catch(function() {
        console.log(arguments)
      });
  }
}
