import React from "react";
import { connect } from "react-redux";

import MButtons from "./MButtons.js";
import MHeader from "./MHeader.js";
import Actions from "../redux/actions/settingsActions.js";

import ReactDataSheet from "react-datasheet";
import './MTable.css';
import MButtonsAddons from "./MButtonsAddons.js";

const ESCAPE_KEYS = 27;

const KURS = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']

class MTable extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            selected: null
        };

        this.changeData = this.changeData.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);

        this.sheetRenderer = this.sheetRenderer.bind(this);
        this.rowRenderer = this.rowRenderer.bind(this);
    }


    componentDidMount() {
        document.addEventListener("keydown", this.onKeyDown);
    }


    componentWillUnmount() {
        document.removeEventListener("keydown", this.onKeyDown);
    }

    onKeyDown(event) {

        switch (event.keyCode) {
            case ESCAPE_KEYS:
                this.setState({ selected: null })
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

    sheetRenderer(sheetProps) {
        return (
            <table className={sheetProps.className + " table table-bordered table-striped table-sm"}>
                <MHeader />
                <tbody>
                    {sheetProps.children}
                </tbody>
            </table>
        );
    }

    rowRenderer(rowProps) {
        return (
            <tr>
                <th>{KURS[rowProps.row]}</th>
                {rowProps.children}
            </tr>);
    }

    render() {

        const { dataBody } = this.props;

        return (
            <>
                <MButtons changeData={this.changeData} />
                <div className="table-responsive mt-2">
                    <ReactDataSheet
                        data={dataBody}
                        valueRenderer={cell => cell.val}
                        selected={this.state.selected}
                        onSelect={selected => this.setState({ selected })}
                        sheetRenderer={this.sheetRenderer}
                        rowRenderer={this.rowRenderer}
                    />
                </div>
                <MButtonsAddons />
            </>
        );
    }
}

const mapStateToProps = (state) => ({
    dataBody: state.settingsState.educationalSchedule
});

export default connect(mapStateToProps)(MTable);
