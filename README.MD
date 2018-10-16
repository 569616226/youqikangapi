## 项目名称：优企康

#### 版权所有：广东东华供应链科技有限公司

##### 开发框架：laravel+vue
##### 开发人员：罗丹、刘宇奇
##### 项目时间：2018年07月03日

初始化项目步骤：

  1.git clone ssh://git@119.23.141.231:10022/youqikang/youqikangproject.git

  2.cp .env.example .env

  3.composer install

  4.php artisan migrate --seed

  5.php artisan passport:install

  6.php artisan key:generate

  7.php artisan apiato:permissions:toRole admin

  8.npm install apidoc -g


生产api文档：php artisan apiato:docs

php artisan storage:link  生成软链接 public/storage -> storage/app/public






