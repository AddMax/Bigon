import React from "react";
import { connect } from "react-redux";

import MHeader from "./MHeader.js";

import ReactDataSheet from "react-datasheet";
import './MTable.css';
import MButtonsAddons from "./MButtonsAddons.js";

const KURS = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

class MTableGraphik extends React.Component {

    constructor(props) {
        super(props);

        this.sheetRenderer = this.sheetRenderer.bind(this);
        this.rowRenderer = this.rowRenderer.bind(this);
    }



    // рендер таблицы
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

    // рендер строки таблицы
    rowRenderer(rowProps) {
        return (
            <tr>
                <th className={"table-dark"} >{KURS[rowProps.row]}</th>
                {rowProps.children}
            </tr>);
    }

    render() {

        const { dataBody, selected } = this.props;

        return (
            <>
                <div className="table-responsive">
                    <ReactDataSheet
                        data={dataBody}
                        valueRenderer={cell => cell.val}
                        selected={selected}
                        onSelect={selected => this.props.onSelect(selected)}
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

export default connect(mapStateToProps)(MTableGraphik);
