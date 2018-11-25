const mysql = require('mysql');
const request = require('request');
const connect = mysql.createConnection({
    host:'localhost',
    user:'root',
    password:'',
    database:'shop'
})
// 获取数据函数
const fetchdata = (o) => {
    return new Promise((resolve,reject) => {
        request(o,(err,header,body) => {
            if(!err){
                resolve(body)
            }else{
                reject(err)
            }
        })
    })
}

// 插入数据函数
const query = (sql,value) => {
    return new Promise((resolve,reject) => {
        connect.query(sql,value,(err,result) => {
            if(!err){
                resolve(result)
            }else{
                reject(err)
            }
        })
    })
}


//分类
let level2_id = null;

// 执行函数
const start = async () => {
    let o = {
        url: 'https://as-vip.missfresh.cn/v2/product/home/index?device_id=ecf72fa0-cb68-11e8-9797-9be35267ab2f&env=web&platform=web&uuid=ecf72fa0-cb68-11e8-9797-9be35267ab2f&access_token=null&version=.0.2&fromSource=zhuye&screen_height=320&screen_width=568',
        method: 'POST',
        headers:{
            'content-type': 'application/json;charset=UTF-8',
            'platform': 'web',
            'user-agent': 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36',
            'x-region':'{"station_code":"MRYX|mryx_ty_xdpx","address_code":140105}',
        },
        json: true,
        body: JSON.parse('{"lat":37.73605,"lng":112.56566,"is_manual":0}')
    }
    let request_data = await fetchdata(o)
    let data = request_data.category_list;
    for(let i = 0;i<data.length;i++){
       if(i>1){
           let v = data[i];
           let sql = 'insert into category (parent_id,name,level,internal_id,sort,img) values (?,?,?,?,?,?)';
           let value = [0,v.name,1,v.internal_id,1,v.icon];
           let result1 = await query(sql,value);
           let level2_parentid = result1.insertId;
           let level2_url = v.internal_id;
           // 开始抓取一级分类下面的二级分类
           let request_data2 = await fetchdata({
               url: 'https://as-vip.missfresh.cn/v3/product/category/' + level2_url + '?device_id=6b5b9c90-d33a-11e8-a729-0bc3c433f956&env=web&platform=web&uuid=6b5b9c90-d33a-11e8-a729-0bc3c433f956&access_token=null&version=.0.2&fromSource=zhuye&screen_height=320&screen_width=668',
               headers:{
                   'content-type': 'application/json;charset=UTF-8',
                   'platform': 'web',
                   'user-agent': 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36',
                   'x-region':'{"station_code":"MRYX|mryx_ty_xdpx","address_code":140105}',
               },
               json: true,
               body: JSON.parse('{"lat":37.73605,"lng":112.56566,"is_manual":0}')
           })
           let data2 = request_data2.products;


           for(let i = 0;i<data2.length;i++){
               let k = data2[i];
               // 如果有code证明他是二级分类
               if(k.code){
                   let imgsrc = null;
                   if(k.banner){
                      imgsrc = k.banner[0].path
                   }else{
                       imgsrc = 0
                   }
                   let sql = 'insert into category (parent_id,name,level,sort,img) values (?,?,?,?,?)';
                   let value = [level2_parentid,k.name,2,1,imgsrc];
                   let result2 = await query(sql,value);
                   level2_id = result2.insertId;

               }
               // 如果没有code证明他不是二级分类，是商品
               else{
                   let cate = level2_parentid + ',' + level2_id;
                   let price = k.vip_price_pro.price_up.price;
                   let special_price = k.vip_price_pro.price_down.price;
                    let sql = 'insert into product (name,spu,sku,shop_id,status,qty,is_in_stock,category,price,special_price,short_description,image) values (?,?,?,?,?,?,?,?,?,?,?,?)';
                    let value = [k.name,k.sku,k.sku,1,1,1000,1,cate,price,special_price/100,k.subtitle,k.image];
                    let results = await query(sql,value);
                    console.log('成功插入' + results.insertId + '条');
               }
           }

       }

    }

}
start();