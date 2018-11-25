<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\xiangmu\thinkphp\public/../application/admin\view\index\category.html";i:1542160083;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/static/css/element-ui.css">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/element-ui.js"></script>
    <script src="/static/js/axios.js"></script>
    <style>
        .el-tree-node__content{
            margin: 10px;
        }
    </style>
</head>
<body>
<div id="app">
    <el-container>
        <el-aside style="width: 200px">
            <el-tree
                    :data="data"
                    :props="defaultProps"
                    accordion
                    @node-click="handleNodeClick">
            </el-tree>
        </el-aside>
        <el-container>
            <el-form ref="form" :model="form" label-width="80px" v-if="form">
                <el-form-item label="分类名称">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="id">
                    <el-input v-model="form.id" disabled></el-input>
                </el-form-item>
                <el-form-item label="parent_id">
                    <el-input v-model="form.parent_id"></el-input>
                </el-form-item>
                <el-button type="primary" @click="currentitem(form)">确认修改</el-button>
                <el-button type="danger" @click="remove">删除</el-button>
            </el-form>
        </el-container>
    </el-container>

</div>
</body>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                data: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                form: null
            }

        },
        methods: {
            //显示当前分类的所有信息
            handleNodeClick(data) {
                this.form = data.data;
            },
            //修改分类
            currentitem(form){
                console.log(form)
                axios({
                    url:'/api/ic/category',
                    data:this.form,
                    method:'post'
                }).then((res) => {
                    this.$message({
                        message: '修改成功',
                        type: 'success'
                    });

                })
            },
            //删除
            remove(){
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios({
                        url:'/api/ic/category',
                        method:'delete',
                        data:this.form
                    }).then((res) => {
                        this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                        this.form = {};
                        this.fetchdata();
                    })

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });

            },
            fetchdata(){
                axios({
                    url: '/api/ic/category'
                }).then(res => {
                    let arr = res.data

                    function fn(id) {
                        return arr.filter(v => v.parent_id == id).map(v => {
                            let o = {
                                label: v.name,
                                children: fn(v.id),
                                data: v
                            };
                            return o;
                        })

                    }
                    this.data = fn(0);
                })
            }
        },
        mounted: function () {
            this.fetchdata();
        }
    })
</script>
</html>