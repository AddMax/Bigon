import React from "react";
import { connect } from "react-redux";

import ReactDataSheet from "react-datasheet";

const KURS = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

class MTableSvod extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            grid: [
                [
                    { value: 'Теоретическое обучение' },
                    { value: 3 }
                ],
                [
                    { value: 'Экзаменационная сессия' },
                    { value: 4 }
                ],
            ],
        };

        this.sheetRenderer = this.sheetRenderer.bind(this);

    }

    // рендер таблицы
    sheetRenderer(sheetProps) {
        return (
            <table className={sheetProps.className + " table table-bordered table-striped table-sm"}>
                <tbody>
                    {sheetProps.children}
                </tbody>
            </table>
        );
    }

    render() {

        return (
            <>
                <ReactDataSheet
                    data={this.state.grid}
                    valueRenderer={cell => cell.value}
                    sheetRenderer={this.sheetRenderer}

                />
            </>
        );
    }
}

const mapStateToProps = (state) => ({
    dataBody: state.settingsState.educationalSchedule
});

export default connect(mapStateToProps)(MTableSvod);
