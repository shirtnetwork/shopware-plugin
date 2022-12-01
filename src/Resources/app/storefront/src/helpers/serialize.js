const serialize = function(obj, prefix) {
    var str = [];
    var p;
    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + '[' + p + ']' : p;
            var v = obj[p];
            str.push((v !== null && typeof v === 'object') ?
                serialize(v, k) :
                encodeURIComponent(k) + '=' + encodeURIComponent(v));
        }
    }
    return str.join('&');
}

export default serialize
