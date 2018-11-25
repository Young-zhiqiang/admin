let category1 = require('./category1.json');
let category2 = require('./category2.json');
const mysql = require('mysql');
const connect = mysql.createConnection({
    host:'localhost',
    user:'root',
    password:'',
    database:'shop'
})

let insert1 = function(){
    category1.category_list.forEach((v,index) => {
        if(index>1){
            let sql = 'insert into category (parent_id,name,level,sort,img,internal_id) values (?,?,?,?,?,?)';
            connect.query(sql,[0,v.name,1,index,v.icon,v.internal_id],(err,result) => {
                if(!err){
                    console.log(result.insertId)
                }else{
                    console.log(err.message)
                }
            })
        }

    })
}
// insert1();

category2.products.forEach((v,index) => {
    if(v.code){
        let sql = 'insert into category (parent_id,name,level,sort,img) values (?,?,?,?,?)';
        connect.query(sql,[3,v.name,2,1,''],(err,result) => {
            if(!err){
                console.log(result.insertId)
            }else{
                console.log(err.message)
            }
        })
    }else{
        let cate = 3+','+14
        let sql = 'insert into product (name,spu,sku,qty,category,price,special_price,short_description,image) values (?,?,?,?,?,?,?,?,?)';
        connect.query(sql,[v.name,v.sku,v.sku,200,cate,v.vip_price_pro.price_up.price,v.vip_price_pro.price_down.price,v.subtitle,v.image],(err,result)=>{
            if(!err){
                console.log(result.insertId)
            }else{
                console.log(err.message)
            }
        }) 
    }
})

