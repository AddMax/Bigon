import React from "react";

import MButtonSave from "./components/MButtonSave.js";
import MTable from "./components/MTable.js";

class EducationalGraphApp extends React.Component {

    render() {

        return (
            <div className={"row"}>
                <div className={"col-lg-12"}>
                    <div className={"card"}>
                        <div className={"card-header"}>
                            Header
                        </div>
                        <div className={"card-body"}>
                            <MTable />
                        </div>
                        <div className={"card-footer"}>
                            <MButtonSave />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default EducationalGraphApp;