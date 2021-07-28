import { combineReducers } from 'redux';
import settingsReducers from './settingsReducers';

export default combineReducers({
    settingsState : settingsReducers
 });