import {combineReducers} from 'redux';
import quotes from './quotesReducer';

const rootReducer = combineReducers({
  quotes
});

export default rootReducer;
