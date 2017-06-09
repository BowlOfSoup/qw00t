import * as types from '../actions/actionTypes';

export default function qoutesReducer(state = {}, action) {
  switch(action.type) {
    case types.GET_QUOTES_SUCCESS:
      let quotes = action.data;

      console.log('reducer', quotes)

      return Object.assign({}, state, {
        data: quotes.data
      });

    default:
      return state;
  }
}
