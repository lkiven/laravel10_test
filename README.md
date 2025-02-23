# Laravel_TEST 安装指南

## 一、克隆项目
```bash
git clone https://github.com/lkiven/laravel10_test.git
cd laravel10_test
二、安装依赖
# 安装PHP依赖
composer install --prefer-dist

# 安装前端依赖
npm install
三、配置环境变量
# 复制环境配置文件
cp .env.example .env

# 修改数据库配置（根据实际情况修改）
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=your_password

# 生成应用密钥
php artisan key:generate
四、初始化数据库
# 创建数据库表结构
php artisan migrate

# 插入初始测试数据（包含管理员账号）
php artisan db:seed
五、编译前端资源
# 开发环境编译
npm run dev

六、启动服务
# 启动开发服务器
php artisan serve 

# 访问地址
http://localhost
七、默认登录信息
字段	值
用户名	admin@example.com
密码	password
注：首次登录后会自动发放Sanctum API令牌

八、功能验证清单
权限控制

访问 /dev 页面需要管理员权限
非授权用户访问 /dev 应重定向到登录页
SQL执行功能

# 测试查询
SELECT * FROM users LIMIT 10;
导出功能

成功执行查询后出现导出按钮
Excel导出包含标准表格格式
JSON导出包含数组结构
日志系统

执行SQL后在 sql_logs 表生成记录
包含执行时间、用户ID和SQL语句

登录信息
用户名：admin@example.com
密码：password
功能说明
登录功能：用户可以使用用户名和密码登录系统。
权限控制：只有具有 admin 权限的用户才能访问 /dev 页面。
SQL 执行：用户可以在 /dev 页面输入 SQL 语句，点击 Execute 按钮执行 SQL 并显示结果。
分页功能：结果支持分页显示，减少浏览器负载。
导出功能：用户可以点击 Export Excel 和 Export Json 按钮导出 SQL 执行结果。
错误处理：如果 SQL 语句有错误，页面会显示错误信息。
日志记录：所有 SQL 执行日志会记录到 sql_logs 表中。