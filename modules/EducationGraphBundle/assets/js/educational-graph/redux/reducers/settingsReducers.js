import Constants from '../constants/settingsConstants.js';

import uniq from 'lodash/uniq';
import isEmpty from 'lodash/isEmpty';

export const initialState = {};

const settingsReducers = (state = initialState, action) => {

  switch (action.type) {

    // SELECTED
    case Constants.SETTING_CHANGE_SELECTED: {
      return { ...state, selected: action.selected };
    }

    case Constants.SETTING_CLEAR_SELECTED:
      return { ...state, selected: null };

    // KURS
    case Constants.SETTING_ADD_KURS: {
      return { ...state, educationalSchedule: [...state.educationalSchedule, action.newKurs] }
    };

    case Constants.SETTING_DELETE_KURS: {
      return { ...state, educationalSchedule: [...state.educationalSchedule].slice(0, -1) }
    };


    // CHANGE_SCHEDULE изменение данных в графике
    case Constants.SETTING_CHANGE_SCHEDULE: {

      console.log(state, action);
      const educationalSchedule = [...state.educationalSchedule];

      if (action.selected !== null) {
        const { start, end } = action.selected;

        let y1, x1, y2, x2;
        let yn1 = start.i,
          xn1 = start.j,
          yn2 = end.i,
          xn2 = end.j;

        if ((yn1 < yn2 || yn1 == yn2) && (xn1 < xn2 || xn1 == xn2)) { y1 = yn1; x1 = xn1; y2 = yn2; x2 = xn2; }
        if ((yn1 < yn2 || yn1 == yn2) && xn1 > xn2) { y1 = yn1; x1 = xn2; y2 = yn2; x2 = xn1; }
        if (yn1 > yn2 && (xn1 < xn2 || xn1 == xn2)) { y1 = yn2; x1 = xn1; y2 = yn1; x2 = xn2; }
        if (yn1 > yn2 && xn1 > xn2) { y1 = yn2; x1 = xn2; y2 = yn1; x2 = xn1; }

        for (let i = y1; i <= y2; i++) {
          for (let j = x1; j <= x2; j++) {
            educationalSchedule[i][j].val = action.value;
          }
        }

      }

      return { ...state, educationalSchedule }

    };

    default:
      return state;
  }
};

export default settingsReducers;