import * as types from './actionTypes';

export function getQuotesSuccess(data) {
  return {type: types.GET_QUOTES_SUCCESS, data};
}

export const getRandomQuotes = () => {
  return function(dispatch) {
    fetch('http:///qwoot.faiawuks.com/api/quotes?random=1')
      .then(response => response.json())
      .then(function(response) {
        console.log('RESPONSE?', response);
        dispatch(getQuotesSuccess(response))
      })
  }
}
