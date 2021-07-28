import { createStore } from "redux";

import reducers from "../reducers";


const educationalSchedule = JSON.parse(document.getElementsByName("form[educationalSchedule]")[0].value);
const selected = null;
const fixed = null;

const initialState = {
  settingsState: { educationalSchedule, selected, fixed}
};

// console.log(initialState);

export const store = createStore(reducers, initialState,
  window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());


