<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\xiangmu\thinkphp\public/../application/admin\view\index\add_category.html";i:1542266091;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/css/element-ui.css">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/element-ui.js"></script>
    <script src="/static/js/axios.js"></script>
    <title>添加分类</title>
</head>
<body>
<div id="app">
    <el-form ref="form" :model="form" label-width="80px">
        <el-form-item label="分类名称">
            <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="选择分类">
            <el-cascader
                    :options="options"
                    change-on-select
                    :props="props"
                    @change="change"
            ></el-cascader>
        </el-form-item>
        <el-button type="primary" @click="submit">确认创建</el-button>


    </el-form>
</div>
</body>
<script>
    new Vue({
        el:'#app',
        data:{
            form: {
                name:''

            },
            options:[],
            props: {
                value: 'data',
                children: 'children'
            }
        },
        methods:{
            submit() {
               axios({
                   url:'/api/ic/category',
                   method:'put',
                   data:this.form
               }).then((res) => {
                   this.$message({
                       type: 'success',
                       message: '创建成功!'
                   });

                   location.href = '/admin/index/category'
               })
            },
            change(e){
               this.form.parent_id = e[e.length-1]
                this.form.level = e.length + 1
            }
        },
        mounted:function () {
            axios({
                url:'/api/ic/category'
            }).then((res) => {
                console.log(res)
                let arr = res.data;
                function fn (id) {
                    return arr.filter(v => v.parent_id == id).map(v => {
                        let o = {
                            label:v.name,
                            data:v.id
                        }
                        if(fn(v.id).length){
                            o.children = fn(v.id)
                        }
                        return o;
                    })
                }


                this.options = fn(0);

            })
        }
    })
</script>
</html>