const request = require('request');

let fn = () => {

        request('http://www.baidu.com',(err,head,body) => {
            return body
        })


}

(async () => {
    let a = fn();
    let b = 1
    console.log(a);
    console.log(b);
})()



