<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"E:\xiangmu\thinkphp\public/../application/admin\view\index\add_product.html";i:1542291496;}*/ ?>
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
    <style>
        .item {
            min-height: 400px;
        }

        .el-input__inner {
            width: 300px;
        }

    </style>
</head>
<body>
<div id="app">
    <el-form ref="form" :model="form" label-width="130px" :rules="rules">
        <!--步骤条-->
        <el-steps :active="active" finish-status="success">
            <el-step title="基础信息"></el-step>
            <el-step title="价格信息"></el-step>
            <el-step title="分类信息"></el-step>
            <el-step title="图片信息"></el-step>
            <el-step title="其他信息"></el-step>
        </el-steps>
        <!--基础信息-->
        <div class="item" v-if="active == 0">
            <el-form-item label="商品名称" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="商品简短描述" prop="short_description">
                <el-input v-model="form.short_description"></el-input>
            </el-form-item>
            <el-form-item label="关键字" prop="meta_keywords">
                <el-input v-model="form.meta_keywords"></el-input>
            </el-form-item>
            <el-form-item label="库存" prop="qty">
                <el-input v-model="form.qty"></el-input>
            </el-form-item>
            <el-form-item label="上下架状态" prop="is_in_stock">
                <el-switch v-model="form.is_in_stock" @change="switch_changes"></el-switch>
            </el-form-item>
        </div>
        <!--价格信息-->
        <div class="item" v-if="active == 1">
            <el-form-item label="价格" prop="price">
                <el-input v-model="form.price"></el-input>

            </el-form-item>
            <el-form-item label="特价" prop="special_price">
                <el-input v-model="form.special_price"></el-input>

            </el-form-item>
            <el-form-item label="特价持续时间">
                <el-date-picker
                        v-model="value5"
                        type="datetimerange"
                        :picker-options="pickerOptions2"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        align="right">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="成本价" prop="const_price">
                <el-input v-model="form.const_price"></el-input>
            </el-form-item>
        </div>
        <!--分类信息-->
        <div class="item" v-if="active == 2">
            <el-form-item label="选择分类">
                <el-tree
                        show-checkbox
                        :data="data"
                        :props="defaultProps"
                        accordion
                        @check-change="handleCheckChange"
                >
                </el-tree>
            </el-form-item>
        </div>
        <!--图片信息-->
        <div class="item" v-if="active == 3">
            <el-form-item label="商品图片">
                <el-upload
                        action="/api/ic/upload"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :on-success="success"
                        multiple>
                    <i class="el-icon-plus"></i>
                </el-upload>
                <el-dialog :visible.sync="dialogVisible">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
            </el-form-item>
        </div>
        <!--商品spu-->
        <div class="item" v-if="active == 4">
            <el-form-item label="商品spu" prop="spu">
                <el-input v-model="form.spu"></el-input>
            </el-form-item>
            <el-form-item label="商品sku" prop="sku">
                <el-input v-model="form.sku"></el-input>
            </el-form-item>
            <el-button type="primary" @click="submit">立即添加</el-button>
        </div>

    </el-form>
    <el-button style="margin-top: 12px;" @click="prev">上一步</el-button>
    <el-button style="margin-top: 12px;" @click="next">下一步</el-button>
</div>
</body>
<script>
    new Vue({
        el: '#app',
        data: {
            pickerOptions2: {
                shortcuts: [{
                    text: '最近一周',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近一个月',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近三个月',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                        picker.$emit('pick', [start, end]);
                    }
                }]
            },
            value5: '',
            active: 0,
            form: {
                category: [],
                image: []
            },
            data: [],
            defaultProps: {
                children: 'children',
                label: 'label'
            },
            dialogImageUrl: '',
            dialogVisible: false,
            rules: {
                name: [
                    {required: true, message: '请输入商品名称', trigger: 'blur'},
                    {min: 1, max: 30, message: '长度在 1 到 30 个字符', trigger: 'blur'}
                ],
                short_description: [
                    {required: true, message: '请输入商品描述', trigger: 'blur'},
                    {min: 1, max: 70, message: '长度在 1 到 70 个字符', trigger: 'blur'}

                ],
                meta_keywords: [
                    {required: true, message: '请输入商品关键字', trigger: 'blur'},
                    {min: 1, max: 70, message: '长度在 1 到 70 个字符', trigger: 'blur'}
                    ],
                qty: [
                    { required: true, message: '年龄不能为空'},
                    { type: 'number', message: '年龄必须为数字值'}
                ],
                price:[],
                special_price:[],


                date1: [
                    {type: 'date', required: true, message: '请选择日期', trigger: 'change'}
                ],
                date2: [
                    {type: 'date', required: true, message: '请选择时间', trigger: 'change'}
                ],
                type: [
                    {type: 'array', required: true, message: '请至少选择一个活动性质', trigger: 'change'}
                ],
                resource: [
                    {required: true, message: '请选择活动资源', trigger: 'change'}
                ],
                desc: [
                    {required: true, message: '请填写活动形式', trigger: 'blur'}
                ]
            }
        },
        methods: {
            // 滑块函数
            switch_changes(e) {
                // if(e){
                //     this.form.is_in_stock = '1';
                // }else{
                //     this.form.is_in_stock = '-1';
                // }
            },
            // 上传文件成功的函数
            success(response) {

                this.form.image.push(response);
                console.log(this.form.image);
                // this.form.image = response;
            },
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleCheckChange(data, checked, indeterminate) {
                if (checked || indeterminate) {
                    this.form.category.push(data.data);
                } else {
                    this.form.category = this.form.category.filter(v => v != data.data);
                }

            },
            next() {
                if (this.active++ >= 4) this.active = 0;
            },
            prev() {
                if (this.active-- <= 0) this.active = 4;
            },
            submit() {
                let arr = this.form.category;
                if (arr.length == 1 || arr.length == 0) {
                    this.$message.error('请选择商品分类');
                    return;
                } else {
                    this.form.category = arr.join(',');
                }
                if (this.form.image.length == 0) {
                    this.$message.error('请上传商品图片');
                    return;
                } else {
                    this.form.image = this.form.image.join(';');
                }
                axios({
                    url: '/api/ic/product',
                    method: 'put',
                    data: this.form
                }).then((res) => {
                    this.$message({
                        type: 'success',
                        message: '创建成功!'
                    });

                })
            },
            change(e) {
                this.form.parent_id = e[e.length - 1]
                this.form.level = e.length + 1
            }
        },
        mounted: function () {
            axios({
                url: '/api/ic/category'
            }).then((res) => {
                console.log(res)
                let arr = res.data;

                function fn(id) {
                    return arr.filter(v => v.parent_id == id).map(v => {
                        let o = {
                            label: v.name,
                            data: v.id
                        }
                        if (fn(v.id).length) {
                            o.children = fn(v.id)
                        }
                        return o;
                    })
                }


                this.data = fn(0);

            })
        }
    })
</script>
</html>