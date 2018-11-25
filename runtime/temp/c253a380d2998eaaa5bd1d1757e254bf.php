<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"E:\xiangmu\thinkphp\public/../application/admin\view\index\index.html";i:1542729786;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/element-ui.js"></script>
    <link rel="stylesheet" href="/static/css/element-ui.css">
    <title>淘宝中台管理界面</title>
</head>
<body>
<div id="app">
    <el-container>
        <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
            <el-menu @select="select"  default-active="/admin/index/admin_user" :default-openeds="[3]">
                <el-submenu index="1">
                    <template slot="title"><i class="el-icon-message"></i>商品中心</template>
                    <el-menu-item-group>
                        <template slot="title">分类管理</template>
                        <el-menu-item index="/admin/index/category">分类列表</el-menu-item>
                        <el-menu-item index="/admin/index/add_category">分类添加</el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item index="/admin/index/product">商品管理</el-menu-item>
                    <el-menu-item index="1-3">优惠券管理</el-menu-item>
                    <el-menu-item index="1-4">收藏管理</el-menu-item>
                    <el-menu-item index="1-5">评论管理</el-menu-item>
                    <el-menu-item index="1-6">数据统计</el-menu-item>
                </el-submenu>

                <el-submenu index="2">
                    <template slot="title"><i class="el-icon-menu"></i>交易管理</template>
                    <el-menu-item index="2-1">购物车管理</el-menu-item>
                    <el-menu-item index="/admin/index/order">订单管理</el-menu-item>
                    <el-menu-item index="2-3">数据统计</el-menu-item>
                </el-submenu>




                <el-submenu index="3">
                    <template slot="title"><i class="el-icon-setting"></i>用户中心</template>
                    <el-menu-item index="3-1">地址管理</el-menu-item>
                    <el-menu-item index="/admin/index/users">用户管理</el-menu-item>
                    <el-menu-item index="3-3">会员管理</el-menu-item>
                    <el-menu-item index="3-4">数据统计</el-menu-item>
                </el-submenu>

                <el-submenu index="4">
                    <template slot="title"><i class="el-icon-menu"></i>管理员</template>
                    <el-menu-item index="/admin/index/admin_user">管理员中心</el-menu-item>
                </el-submenu>
            </el-menu>
        </el-aside>

        <el-container>
            <iframe :src="url" frameborder="0"></iframe>
        </el-container>
    </el-container>

</div>
</body>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    iframe {
        display: block;
        width: 100%;
        height: 100vh;
    }
</style>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                url:'/admin/index/users'
            }
        },
        methods: {
            select(e){
             this.url = e
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        }
    })
</script>
</html>