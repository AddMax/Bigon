/*!
 * jQuery cellSelection Plugin v1.0.0
 * requires jQuery v1.9 or later
 *
 * http://incode.pro/
 *
 * Date: 2016-04-15 18:45
 */
;
(function (c) {
    var d = {
        selectClass: "jq-cell-selected",
        ignoreCell: ""
    },
        l = {
            init: function (a) {
                d = c.extend(d, a);
                d.selectClass = d.selectClass.replace(/^[.]*/, "");
                return this.each(function (a, c) {
                    c.nodeName && "TABLE" === c.nodeName && l.setEvents(c)
                })
            },
            setEvents: function (a) {
                var b = this,
                    f = this.selection,
                    e;
                c("td", a).not(d.ignoreCell).on({
                    mousedown: function (a) {
                        e = a.shiftKey || a.ctrlKey ? a.shiftKey ? "shifts" : "ctrl" : "single";
                        f[e](this);
                        b.pressed = !0
                    },
                    mouseenter: function (a) {
                        if (b.pressed) f[a.altKey && a.ctrlKey ? "shifts" : "rectangle"](this)
                    }
                });
                c(a).on("mouseleave", function () {
                    b.pressed = !1
                });
                c(document).on("mouseup", function () {
                    b.pressed = !1
                })
            },
            selection: {
                single: function (a) {
                    c(a).closest("table").find("td").not(a).removeClass(d.selectClass);
                    this.ctrl(a)
                },
                shifts: function (a) {
                    var b = c(a).closest("table"),
                        f = b.data("last-selected"),
                        e, g;
                    if ("number" !== typeof f) return this.single(a);
                    b = c("td", b);
                    e = b.index(a);
                    g = f;
                    g > e && (e = [g, g = e][0]);
                    b.not(b.eq(f)).removeClass(d.selectClass);
                    b.slice(g, e).not(d.ignoreCell).add(a).addClass(d.selectClass)
                },
                rectangle: function (a) {
                    var b =
                        c(a).closest("table"),
                        f = c("td", b),
                        e = c("tr", b),
                        g, h;
                    f.removeClass(d.selectClass);
                    b = f.eq(b.data("last-selected"))[0];
                    g = b.cellIndex;
                    h = a.cellIndex;
                    b = b.parentNode.rowIndex;
                    a = a.parentNode.rowIndex;
                    g > h && (h = [g, g = h][0]);
                    b > a && (a = [b, b = a][0]);
                    h++;
                    a++;
                    e.slice(b, a).each(function (a, b) {
                        c("td", b).slice(g, h).not(d.ignoreCell).addClass(d.selectClass)
                    })
                },
                ctrl: function (a) {
                    var b = c(a).closest("table");
                    c(a).addClass(d.selectClass);
                    b.data("last-selected", c("td", b).index(a))
                }
            },
            pressed: !1
        },
        k = {
            getArray: function (a) {
                var b = ["text",
                    "html", "data"
                ],
                    f = a && -1 !== b.indexOf(a) ? a : "text",
                    e = [];
                this.each(function (a, b) {
                    e.push(c("tr", b).map(function (a, b) {
                        return c("td." + d.selectClass, b).map(function (a, b) {
                            return c(b)[f]()
                        }).get()
                    }).get())
                });
                return 1 < this.length ? e : e[0]
            },
            getJson: function (a) {
                return JSON.stringify(k.getArray.call(this, a))
            },
            selectAll: function () {
                c("td:not(" + d.ignoreCell + ")", this).addClass(d.selectClass)
            },
            deselect: function () {
                c("td", this).removeClass(d.selectClass)
            }
        };
    c.fn.cellSelection = function (a) {
        if (k[a]) return k[a].apply(this, [].slice.call(arguments, 1));
        if ("object" !== typeof a && a) c.error('\u041c\u0435\u0442\u043e\u0434 \u0441 \u0438\u043c\u0435\u043d\u0435\u043c "' + a + '" \u043d\u0435 \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442!');
        else return l.init.apply(this, arguments)
    }
})(jQuery);