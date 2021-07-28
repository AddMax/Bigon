import Constants from "../constants/settingsConstants";

const Actions = {

  changeSettingSelected: (select) => ({
    type: Constants.SETTING_CHANGE_SELECTED,
    selected: select
  }),

  clearSettingSelected: () => ({
    type: Constants.SETTING_CLEAR_SELECTED,
  }),

  addSettingKurs: (newKurs) => ({
    type: Constants.SETTING_ADD_KURS,
    newKurs: newKurs
  }),

  deleteSettingKurs: () => ({
    type: Constants.SETTING_DELETE_KURS,
  }),

  changeSettingSchedule: (value, selected) => ({
    type: Constants.SETTING_CHANGE_SCHEDULE,
    value: value,
    selected: selected
  }),

};

export default Actions;
