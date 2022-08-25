let request = new AjaxRequest('https://example.org/my-endpoint');

const qs = {
    foo: 'bar',
    bar: {
        baz: ['foo', 'bencer']
    }
};
request = request.withQueryArguments(qs);