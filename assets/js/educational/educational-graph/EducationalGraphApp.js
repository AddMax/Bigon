import React from "react";
import { connect } from "react-redux";

import Actions from "./redux/actions/settingsActions.js";

import MButtons from "./components/MButtons.js";
import MButtonSave from "./components/MButtonSave.js";
import MTableGraphik from "./components/MTableGraphik.js";
import MTableSvod from "./components/MTableSvod.js";

const ESCAPE_KEYS = 27; //ESC

// ф-я снимает выделение с текста на странице
function clearSelection() {
    if (window.getSelection) {
        window.getSelection().removeAllRanges();
    } else { // старый IE
        document.selection.empty();
    }
}

class EducationalGraphApp extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            selected: null
        };

        this.onKeyDown = this.onKeyDown.bind(this);

        this.changeData = this.changeData.bind(this);
        this.onSelect = this.onSelect.bind(this);
    }

    componentDidMount() {
        document.addEventListener("keydown", this.onKeyDown);
    }


    componentWillUnmount() {
        document.removeEventListener("keydown", this.onKeyDown);
    }

    //обработка событий клавиатуры
    onKeyDown(event) {

        switch (event.keyCode) {
            case ESCAPE_KEYS:
                clearSelection();
                this.setState({ selected: null });
                break;
            default:
                break;
        }
        return true;
    }

    changeData(txt) {
        const { dispatch } = this.props;
        const { selected } = this.state;
        dispatch(Actions.changeSettingSchedule(txt, selected));
    }

    onSelect(selected) {
        this.setState({ selected });
    }

    render() {

        return (
            <>
                <div className={"row"}>
                    <div className={"col-lg-8"}>
                        <div className={"card"}>
                            <div className={"card-header"}>
                                Виды образовательного процесса
                            </div>
                            <div className={"card-body"}>
                                <MButtons changeData={this.changeData} />
                            </div>
                            <div className={"card-footer"}>
                                Footer
                            </div>
                        </div>
                    </div>
                    <div className={"col-lg-4"}>
                        <div className={"card"}>
                            <div className={"card-header"}>
                                Header
                            </div>
                            <div className={"card-body"}>
                                Body
                                <MTableSvod />
                            </div>
                            <div className={"card-footer"}>
                                Footer
                            </div>
                        </div>
                    </div>
                </div>

                <div className={"row"}>
                    <div className={"col-lg-12"}>
                        <div className={"card"}>
                            <div className={"card-header"}>
                                Header
                            </div>
                            <div className={"card-body"}>
                                <MTableGraphik selected={this.state.selected} onSelect={this.onSelect} />
                            </div>
                            <div className={"card-footer"}>
                                <MButtonSave />
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}

const mapStateToProps = (state) => ({
    dataBody: state.settingsState.educationalSchedule
});

export default connect(mapStateToProps)(EducationalGraphApp);
