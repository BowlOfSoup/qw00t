import {combineReducers} from 'redux';
import quotes from './quotesReducer';
import register from './registerReducer';

const rootReducer = combineReducers({
  quotes,
  register
});

export default rootReducer;
