! function(e) {
    function n(r) {
        if (t[r]) return t[r].exports;
        var i = t[r] = {
            exports: {},
            id: r,
            loaded: !1
        };
        return e[r].call(i.exports, i, i.exports, n), i.loaded = !0, i.exports
    }
    var t = {};
    return n.m = e, n.c = t, n.p = "", n(0)
}([function(e, n, t) {
    $(function() {
        var e = t(1),
            n = $("#block1").html(),
            r = $("#block2").html(),
            i = e(n, r);
        $("#diff").html(i)
    })
}, function(e, n) {
    var t, r;
    (function() {
        var i, a, o, f, _, s, u, l, h, c, d, b, p, g, v, w, k;
        h = function(e) {
            return ">" === e
        }, c = function(e) {
            return "<" === e
        }, b = function(e) {
            return /^\s+$/.test(e)
        }, d = function(e) {
            return /^\s*<[^>]+>\s*$/.test(e)
        }, p = function(e) {
            return !d(e)
        }, i = function() {
            function e(e, n, t) {
                this.start_in_before = e, this.start_in_after = n, this.length = t, this.end_in_before = this.start_in_before + this.length - 1, this.end_in_after = this.start_in_after + this.length - 1
            }
            return e
        }(), l = function(e) {
            var n, t, r, i, a, o;
            for (r = "char", t = "", i = [], a = 0, o = e.length; o > a; a++) switch (n = e[a], r) {
                case "tag":
                    h(n) ? (t += ">", i.push(t), t = "", r = b(n) ? "whitespace" : "char") : t += n;
                    break;
                case "char":
                    c(n) ? (t && i.push(t), t = "<", r = "tag") : /\s/.test(n) ? (t && i.push(t), t = n, r = "whitespace") : /[\w\#@]+/i.test(n) ? t += n : (t && i.push(t), t = n);
                    break;
                case "whitespace":
                    c(n) ? (t && i.push(t), t = "<", r = "tag") : b(n) ? t += n : (t && i.push(t), t = n, r = "char");
                    break;
                default:
                    throw new Error("Unknown mode " + r)
            }
            return t && i.push(t), i
        }, s = function(e, n, t, r, a, o, f) {
            var _, s, u, l, h, c, d, b, p, g, v, w, k, m;
            for (s = r, _ = o, u = 0, p = {}, h = w = r; a >= r ? a > w : w > a; h = a >= r ? ++w : --w) {
                for (v = {}, d = e[h], c = t[d], k = 0, m = c.length; m > k; k++)
                    if (l = c[k], !(o > l)) {
                        if (l >= f) break;
                        null == p[l - 1] && (p[l - 1] = 0), g = p[l - 1] + 1, v[l] = g, g > u && (s = h - g + 1, _ = l - g + 1, u = g)
                    }
                p = v
            }
            return 0 !== u && (b = new i(s, _, u)), b
        }, v = function(e, n, t, r, i, a, o, f) {
            var _;
            return _ = s(e, n, t, r, i, a, o), null != _ && (r < _.start_in_before && a < _.start_in_after && v(e, n, t, r, _.start_in_before, a, _.start_in_after, f), f.push(_), _.end_in_before <= i && _.end_in_after <= o && v(e, n, t, _.end_in_before + 1, i, _.end_in_after + 1, o, f)), f
        }, f = function(e) {
            var n, t, r, i, a, o;
            if (null == e.find_these) throw new Error("params must have find_these key");
            if (null == e.in_these) throw new Error("params must have in_these key");
            for (t = {}, o = e.find_these, i = 0, a = o.length; a > i; i++)
                for (r = o[i], t[r] = [], n = e.in_these.indexOf(r); - 1 !== n;) t[r].push(n), n = e.in_these.indexOf(r, n + 1);
            return t
        }, u = function(e, n) {
            var t, r;
            return r = [], t = f({
                find_these: e,
                in_these: n
            }), v(e, n, t, 0, e.length, 0, n.length, r)
        }, a = function(e, n) {
            var t, r, a, o, f, _, s, l, h, c, d, b, p, g, v, w, k, m;
            if (null == e) throw new Error("before_tokens?");
            if (null == n) throw new Error("after_tokens?");
            for (p = b = 0, d = [], t = {
                    "false,false": "replace",
                    "true,false": "insert",
                    "false,true": "delete",
                    "true,true": "none"
                }, h = u(e, n), h.push(new i(e.length, n.length, 0)), a = v = 0, k = h.length; k > v; a = ++v) _ = h[a], l = p === _.start_in_before, s = b === _.start_in_after, r = t[[l, s].toString()], "none" !== r && d.push({
                action: r,
                start_in_before: p,
                end_in_before: "insert" !== r ? _.start_in_before - 1 : void 0,
                start_in_after: b,
                end_in_after: "delete" !== r ? _.start_in_after - 1 : void 0
            }), 0 !== _.length && d.push({
                action: "equal",
                start_in_before: _.start_in_before,
                end_in_before: _.end_in_before,
                start_in_after: _.start_in_after,
                end_in_after: _.end_in_after
            }), p = _.end_in_before + 1, b = _.end_in_after + 1;
            for (g = [], f = {
                    action: "none"
                }, o = function(n) {
                    return "equal" !== n.action ? !1 : n.end_in_before - n.start_in_before !== 0 ? !1 : /^\s$/.test(e.slice(n.start_in_before, +n.end_in_before + 1 || 9e9))
                }, w = 0, m = d.length; m > w; w++) c = d[w], o(c) && "replace" === f.action || "replace" === c.action && "replace" === f.action ? (f.end_in_before = c.end_in_before, f.end_in_after = c.end_in_after) : (g.push(c), f = c);
            return g
        }, o = function(e, n, t) {
            var r, i, a, o, f, _;
            for (n = n.slice(e, +n.length + 1 || 9e9), a = void 0, i = f = 0, _ = n.length; _ > f && (o = n[i], r = t(o), r === !0 && (a = i), r !== !1); i = ++f);
            return null != a ? n.slice(0, +a + 1 || 9e9) : []
        }, k = function(e, n) {
            var t, r, i, a, f;
            for (a = "", i = 0, t = n.length;;) {
                if (i >= t) break;
                if (r = o(i, n, p), i += r.length, 0 !== r.length && (a += "<" + e + ">" + r.join("") + "</" + e + ">"), i >= t) break;
                f = o(i, n, d), i += f.length, a += f.join("")
            }
            return a
        }, g = {
            equal: function(e, n) {
                return n.slice(e.start_in_before, +e.end_in_before + 1 || 9e9).join("")
            },
            insert: function(e, n, t) {
                var r;
                return r = t.slice(e.start_in_after, +e.end_in_after + 1 || 9e9), k("ins", r)
            },
            "delete": function(e, n) {
                var t;
                return t = n.slice(e.start_in_before, +e.end_in_before + 1 || 9e9), k("del", t)
            }
        }, g.replace = function(e, n, t) {
            return g["delete"](e, n, t) + g.insert(e, n, t)
        }, w = function(e, n, t) {
            var r, i, a, o;
            for (i = "", a = 0, o = t.length; o > a; a++) r = t[a], i += g[r.action](r, e, n);
            return i
        }, _ = function(e, n) {
            var t;
            return e === n ? e : (e = l(e), n = l(n), t = a(e, n), w(e, n, t))
        }, _.html_to_tokens = l, _.find_matching_blocks = u, u.find_match = s, u.create_index = f, _.calculate_operations = a, _.render_operations = w, t = [], r = function() {
            return _
        }.apply(n, t), !(void 0 !== r && (e.exports = r))
    }).call(this)
}]);