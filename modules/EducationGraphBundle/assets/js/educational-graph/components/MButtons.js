import React from "react";

class MButtons extends React.Component {

    render() {

        return (
            <div className="panel_default">

                <button className="btn btn-light mb-1" onClick={e => this.props.changeData("")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                    </svg>
                    <span className="d-inline d-xl-none ml-2">ТО</span>
                    <span className="d-xl-down-none ml-2">Теоретическое обучение (ТО)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData(":")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">:</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">ЭС</span>
                    <span className="d-xl-down-none ml-2">Экзаменационная сессия (ЭС)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData("0")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">0</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">УП</span>
                    <span className="d-xl-down-none ml-2">Учебная практика (УП)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData("X")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">X</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">ПП</span>
                    <span className="d-xl-down-none ml-2">Производственная практика (ПП)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData("=")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">=</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">К</span>
                    <span className="d-xl-down-none ml-2">Каникулы (К)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData("//")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">//</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">ИА</span>
                    <span className="d-xl-down-none ml-2">Итоговая аттестация (ИА)</span>
                </button>

                <button className={"btn btn-light mb-1"} onClick={e => this.props.changeData("~")}>
                    <svg className={"c-icon"} width="16" height="16">
                        <rect width="16" height="16" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">~</text>
                    </svg>
                    <span className="d-inline d-xl-none ml-2">НН</span>
                    <span className="d-xl-down-none ml-2">Неучитываемые недели (НН)</span>
                </button>
            </div>
        );
    }
}

export default MButtons;