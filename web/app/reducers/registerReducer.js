import * as types from '../actions/actionTypes';

export default function qoutesReducer(state = {}, action) {
  switch(action.type) {
    case types.REGISTER_SUCCESS:
      let user = action.data;
      return Object.assign({}, state, {
        user: user.data
      });

    default:
      return state;
  }
}
