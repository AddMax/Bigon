import React from "react";
import { connect } from "react-redux";

import Actions from "../redux/actions/settingsActions.js";

class MCell extends React.Component {

    constructor(props) {
        super(props);

        this.beginSelection = this.beginSelection.bind(this);
        this.endSelection = this.endSelection.bind(this);

        this.toggleSelect = this.toggleSelect.bind(this);

        this.updateSelection = this.updateSelection.bind(this);

    }


    toggleSelect(event) {
        event.preventDefault();

        const YnX = this.props.yn + ':' + this.props.xn;

        const { dispatch } = this.props;
        dispatch(Actions.addSettingSelected(YnX));

    }

    beginSelection(event) {
        event.preventDefault();

        const YnX = { yn: this.props.yn, xn: this.props.xn };

        const { dispatch } = this.props;
        dispatch(Actions.addSettingFix(YnX));
    }

    endSelection(event) {
        event.preventDefault();
    }

    updateSelection(event) {
        if (event.buttons == 1) {

            const first = this.props.settingsFixed;
            let arr = []
            let y1, x1, y2, x2;
            let yn1 = first.yn,
                xn1 = first.xn,
                yn2 = this.props.yn,
                xn2 = this.props.xn;

            if ((yn1 < yn2 || yn1 == yn2) && (xn1 < xn2 || xn1 == xn2)) { y1 = yn1; x1 = xn1; y2 = yn2; x2 = xn2; }
            if ((yn1 < yn2 || yn1 == yn2) && xn1 > xn2) { y1 = yn1; x1 = xn2; y2 = yn2; x2 = xn1; }
            if (yn1 > yn2 && (xn1 < xn2 || xn1 == xn2)) { y1 = yn2; x1 = xn1; y2 = yn1; x2 = xn2; }
            if (yn1 > yn2 && xn1 > xn2) { y1 = yn2; x1 = xn2; y2 = yn1; x2 = xn1; }

            for (let i = y1; i <= y2; i++) {
                for (let j = x1; j <= x2; j++) {
                    arr.push(i + ':' + j);
                }
            }

            const { dispatch } = this.props;
            dispatch(Actions.addSettingSelected(arr));

        }
    }

    render() {

        return (
            <td
                style={this.props.select ? { background: 'aquamarine', cursor: "default" } : { cursor: "default" }}
                onClick={this.toggleSelect}
                onMouseDown={this.beginSelection}
                onMouseUp={this.endSelection}
                onMouseMove={this.updateSelection}
            >
                <span> {this.props.children}</span>
            </td>
        );
    }
}

const mapStateToProps = (state) => ({
    settingsSelected: state.settingsState.selected,
    settingsFixed: state.settingsState.fixed,
});

export default connect(mapStateToProps)(MCell);