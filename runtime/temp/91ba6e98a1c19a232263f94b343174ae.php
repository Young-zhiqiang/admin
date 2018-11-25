<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"E:\xiangmu\thinkphp\public/../application/admin\view\index\admin_user.html";i:1542517355;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/element-ui.js"></script>
    <script src="/static/js/axios.js"></script>
    <link rel="stylesheet" href="/static/css/element-ui.css">
    <style>
        .el-input__inner {
            max-width: 400px;
        }

        .demo-table-expand {
            font-size: 0;
        }

        .demo-table-expand label {
            width: 90px;
            color: #99a9bf;
        }

        .demo-table-expand .el-form-item {
            margin-right: 0;
            margin-bottom: 10px;
            width: 50%;
        }

    </style>

    <title>管理员中心</title>
</head>
<body>
<div id="app">

    <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="管理员列表" name="list">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">

                <el-row :gutter="20">

                    <el-col :span="6">
                        <el-form-item label="按名字搜索">
                            <el-input v-model="keyword.user_name" placeholder="请输入关键字"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="所在部门">
                            <el-select v-model="keyword.dep" placeholder="请选择所在部门">
                                <el-option label="技术部" value="技术部"></el-option>
                                <el-option label="生产部" value="生产部"></el-option>
                                <el-option label="营销部" value="营销部"></el-option>
                                <el-option label="业务部" value="业务部"></el-option>
                                <el-option label="人事部" value="人事部"></el-option>
                            </el-select>
                        </el-form-item>

                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="按账号搜索">
                            <el-input v-model="keyword.account" placeholder="请输入账号"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button type="primary" icon="el-icon-search el-icon-left" @click="search">搜索</el-button>
                    </el-col>

                    <el-col :span="2">
                        <el-button type="primary" icon="el-icon-refresh el-icon-left" @click="refresh">刷新</el-button>
                    </el-col>
                </el-row>
            </el-form>

            <el-button type="danger" icon="el-icon-delete el-icon-right" @click="remove">批量删除</el-button>
            <el-table
                    :data="list"
                    style="width: 100%"
                    @selection-change="handleSelectionChange"
                    @sort-change="change"
            >
                <el-table-column
                        type="selection"
                        width="55">
                </el-table-column>
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <el-form label-position="left" inline class="demo-table-expand">
                            <el-form-item label="账号">
                                <el-input disabled v-model="props.row.account"></el-input>
                            </el-form-item>
                            <el-form-item label="部门">
                                <el-input v-model="props.row.dep"></el-input>
                            </el-form-item>
                            <el-form-item label="用户名">
                                <el-input v-model="props.row.user_name"></el-input>
                            </el-form-item>
                            <el-form-item label="密码">
                                <el-input type="password" v-model="props.row.password"></el-input>
                            </el-form-item>
                            <el-form-item>
                            </el-form-item>
                        </el-form>
                        <el-button type="primary" size="mini" icon="el-icon-refresh el-icon-right"
                                   @click="update(props.row)">确认修改
                        </el-button>

                    </template>
                </el-table-column>
                <el-table-column
                        label="ID"
                        sortable="custom"
                        prop="id">
                </el-table-column>
                <el-table-column
                        label="账号"
                        prop="account">
                </el-table-column>
                <el-table-column
                        label="部门"
                        prop="dep">
                </el-table-column>
                <el-table-column
                        label="管理员姓名"
                        prop="user_name">
                </el-table-column>
                <el-table-column
                        label="创建时间"
                        sortable="custom"
                        default-sort=""
                        prop="created_at">
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="prop">
                        <el-button type="danger" icon="el-icon-delete" circle @click="handleDelete(prop.row.id)"
                                   size="mini"></el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="block">
                <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page="page"
                        :page-sizes="[pagesize,10, 20, 30, 40]"
                        :page-size="pagesize"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="total">
                </el-pagination>
            </div>
        </el-tab-pane>


        <el-tab-pane label="管理员添加" name="add">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                <el-form-item label="账号" prop="account">
                    <el-input v-model="ruleForm.account"></el-input>
                </el-form-item>
                <el-form-item label="部门" prop="dep">
                    <el-input v-model="ruleForm.dep"></el-input>
                </el-form-item>
                <el-form-item label="用户名字" prop="user_name">
                    <el-input v-model="ruleForm.user_name"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input v-model="ruleForm.password"></el-input>
                </el-form-item>
                <el-form-item label="再次输入密码" prop="password_repeat">
                    <el-input type="password" v-model="ruleForm.password_repeat"></el-input>
                </el-form-item>
            </el-form>
            <el-button type="primary" @click="creat_user">确认创建</el-button>
        </el-tab-pane>
    </el-tabs>

</div>
</body>

<script>

    new Vue({
        el: '#app',
        data() {
            var validatePass2 = (rule, value, callback) => {
                if (value !== this.ruleForm.password) {
                    callback(new Error('俩次输入密码不一致'))
                }
            }
            return {
                order: 'asc',
                by: 'id',
                //决定用fetchdata还是用searchdata的开关
                switchs: false,
                // 搜索功能的数据
                keyword: {},
                //批量删除的id数组
                removeids: [],
                // 分页
                page: 1,
                pagesize: 2,
                total: 0,
                activeName: 'add',
                //创建管理员
                ruleForm: {},
                rules: {
                    account: [
                        {required: true, message: '账号不能为空', trigger: 'blur'},
                        {min: 1, max: 10, message: '长度在 1 到 5 个字符', trigger: 'blur'}
                    ],
                    dep: [
                        {required: true, message: '部门名称不能为空', trigger: 'blur'},
                        {min: 1, max: 5, message: '长度在 1 到 5 个字符', trigger: 'blur'}
                    ],
                    user_name: [
                        {required: true, message: '用户名字不能为空', trigger: 'blur'},
                        {min: 1, max: 5, message: '长度在 1 到 5 个字符', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '密码不能为空', trigger: 'blur'},
                        {min: 6, message: '至少输入6位', trigger: 'blur'}
                    ],
                    password_repeat: [
                        {required: true, message: '密码不能为空', trigger: 'blur'},
                        {validator: validatePass2, trigger: 'blur'}
                    ]
                },
                //管理员列表
                list: []
            }
        },
        methods: {
            //排序功能
            change(e) {

                if (e.order == 'ascending') {
                    this.order = 'asc';
                    this.by = e.prop;
                    if (this.switchs) {
                        this.searchdata();
                    } else {
                        this.fetchdata();
                    }

                } else {
                    this.order = 'desc';
                    this.by = e.prop
                    if (this.switchs) {
                        this.searchdata();
                    } else {
                        this.fetchdata();
                    }

                }
            },
            //刷新功能
            refresh() {
                this.page = 1;
                this.keyword = {};
                this.fetchdata();
            },
            //搜索功能
            search() {
                this.switchs = true
                this.searchdata();
            },
            //搜索函数
            searchdata() {
                this.keyword.page = this.page;
                this.keyword.pagesize = this.pagesize;
                this.keyword.order = this.order;
                this.keyword.by = this.by;
                axios({
                    url: '/api/uic/adminuser',
                    params: this.keyword
                }).then(res => {
                    this.list = res.data.data.map(v => {
                        v.created_at = new Date(v.created_at).toLocaleDateString();
                        return v
                    })
                    this.total = res.data.total
                })
            },
            //修改
            update(e) {

                let o = {};
                o.dep = e.dep;
                o.user_name = e.user_name;
                o.password = e.password;
                axios({
                    url: '/api/uic/adminuser',
                    method: 'post',
                    data: o
                }).then(res => {
                    this.$message({
                        type: 'success',
                        message: '修改成功!'
                    });
                }).catch(res => {
                    this.$message({
                        type: 'info',
                        message: '对不起，修改失败！'
                    });
                })
            },
            //分页
            handleSizeChange(val) {
                this.page = 1;
                this.pagesize = val;
                if (this.switchs) {
                    this.searchdata();
                } else {
                    this.fetchdata();
                }
            },
            handleCurrentChange(val) {
                this.page = val;
                if (this.switchs) {
                    this.searchdata();
                } else {
                    this.fetchdata();
                }
            },
            //批量删除
            remove() {
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios({
                        url: '/api/uic/adminuser',
                        method: 'delete',
                        data: this.removeids
                    }).then(res => {
                        if (this.switchs) {
                            this.searchdata();
                        } else {
                            this.fetchdata();
                        }
                        this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                    })


                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                })
            },
            handleSelectionChange(val) {
                this.removeids = val.map(v => v.id)
            },
            //单个删除
            handleDelete(id) {
                console.log(id)
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios({
                        url: '/api/uic/adminuser',
                        method: 'delete',
                        data: [id]
                    }).then(res => {
                        if (this.switchs) {
                            this.searchdata();
                        } else {
                            this.fetchdata();
                        }
                        this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                    })


                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                })

            },

            handleClick(tab, event) {
                console.log(tab, event);
            },
            //创建管理员发送函数
            creat_user() {
                axios({
                    url: '/api/uic/adminuser',
                    method: 'put',
                    data: this.ruleForm
                }).then(res => {
                    this.$message({
                        message: '创建成功',
                        type: 'success'
                    });
                    console.log(res)
                })
            },

            //获取数据函数，没有条件
            fetchdata() {
                axios({
                    url: '/api/uic/adminuser',
                    method: 'get',
                    params: {
                        page: this.page,
                        pagesize: this.pagesize,
                        order: this.order,
                        by: this.by
                    }
                }).then(res => {
                    this.total = res.data.total
                    this.list = res.data.data.map(v => {

                            v.created_at = new Date(v.created_at * 1000).toLocaleDateString()

                        return v;
                    })
                })
            }
        },
        mounted: function () {
            this.fetchdata();
        }
    })
</script>
</html>