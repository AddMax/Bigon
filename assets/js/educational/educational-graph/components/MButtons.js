import React from "react";

class MButtons extends React.Component {
    constructor(props) {
        super(props);
        this.command = [
            { fullName: 'Теоретическое обучение', shotName: 'ТО', hours: null, val: '' },
            { fullName: 'Экзаменационная сессия', shotName: 'ЭС', hours: null, val: ':' },
            { fullName: 'Учебная практика', shotName: 'УП', hours: null, val: '0' },
            { fullName: 'Производственная практика', shotName: 'ПП', hours: null, val: 'X' },
            { fullName: 'Каникулы', shotName: 'К', hours: null, val: '=' },
            { fullName: 'Итоговая аттестаци', shotName: 'ИА', hours: null, val: '//' },
            { fullName: 'Неучитываемые недели', shotName: 'НН', hours: null, val: '~' },
        ];
    }

    render() {

        return (
            <div className="row">
                {
                    this.command.map(
                        (el, i) => {
                            return (
                                <div key={i} className={"form-group col-sm-3"}>
                                    <label className={"col-form-label"} htmlFor={"appendedInputButton" + i}>{el.fullName + ' (' + el.shotName + ')'}</label>
                                    <div className={"controls"}>
                                        <div className={"input-group"}>
                                            <span className={"input-group-append"}>
                                                <button className={"btn btn-secondary"} type={"button"} onClick={e => this.props.changeData(el.val)}>
                                                    <svg width="15" height="15">
                                                        <rect width="15" height="15" style={{ fill: 'none', strokeWidth: "2", stroke: "#000000" }} />
                                                        <text x="4" y="13" fill="#000000" fontWeight="bolt" fontSize="12">{el.val}</text>
                                                    </svg>
                                                </button>
                                            </span>
                                            <input className={"form-control"} id={"appendedInputButton" + i} size={16} type={"text"} value={el.hours} />
                                            <div className="input-group-append">
                                                <span className="input-group-text">.час</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                    )
                }

                {/* <div className="panel_default">
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
                </div> */}
            </div>
        );
    }
}

export default MButtons;