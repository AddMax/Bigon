import React from "react";
import { connect } from "react-redux";

import Actions from "../redux/actions/settingsActions.js";

class MButtonsAddons extends React.Component {
    constructor(props) {
        super(props);

        this.addKurs = this.addKurs.bind(this);
        this.deleteKurs = this.deleteKurs.bind(this);
    }

    addKurs(event) {
        event.preventDefault();
        const { datas, dispatch } = this.props;
        if (datas.length == 10) return;
        const newDatas = Array(52).fill(null).map((u, i) => { return { week: ++i, val: "" } });
        dispatch(Actions.addSettingKurs(newDatas));
    }

    deleteKurs(event) {
        event.preventDefault();
        const { dispatch } = this.props;
        dispatch(Actions.deleteSettingKurs());
    }

    render() {

        return (
            <div className="panel_default mt-2">

                <button className="btn btn-light mb-1 mr-2" onClick={this.addKurs} >
                    <span className={"cil-plus c-icon mr-2"}></span>
                    Добавить курс
                </button>

                <button className="btn btn-light mb-1" onClick={this.deleteKurs} >
                    <span className={"cil-minus c-icon mr-2"}></span>
                    Удалить курс
                </button>

            </div>
        );
    }
}

const mapStateToProps = (state) => ({
    datas: state.settingsState.educationalSchedule,
});

export default connect(mapStateToProps)(MButtonsAddons);