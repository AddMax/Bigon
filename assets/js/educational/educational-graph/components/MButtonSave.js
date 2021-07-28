import React from "react";
import { connect } from "react-redux";

class MButtonSave extends React.Component {
    constructor(props) {
        super(props);

        this.form = document.getElementsByName("form")[0];
        // console.log(document.getElementsByName("form[educationalSchedule]")[0].value);
        this.submitSave = this.submitSave.bind(this);

    }

    submitSave(event) {
        event.preventDefault();
        document.getElementsByName("form[educationalSchedule]")[0].value=JSON.stringify(this.props.datas);
        this.form.submit();
    }

    render() {

        return (
            <div className={"form-actions"}>

                <button className={"btn btn-primary"} onClick={this.submitSave} disabled={false}>
                    <span className={"cil-save btn-icon mr-2"}></span>
                    Сохранить
                </button>

            </div>
        );
    }
}

const mapStateToProps = (state) => ({
    datas: state.settingsState.educationalSchedule,
});

export default connect(mapStateToProps)(MButtonSave);