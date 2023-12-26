<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1>Youcan Task</h1>

<h2>Live Demo</h2>
<strong>Please watch this video 👇</strong>

[![Live Demo](https://img.youtube.com/vi/f_Lx8vX2HPk/0.jpg)](https://youtu.be/f_Lx8vX2HPk)

<h2>Project Infra Structure</h2>
<ul>
<li> The Project is a Decoupled Modular Monolithic App :
    HMVC Modules (you can turn on/off each module and republish/reuse it at another project)

<li> Module Structure (Repository Design Pattern)

<a target="_blank" href="https://drive.google.com/uc?export=view&id=1_CTRCCiZ0X4nG06_xTv48y6MH5vBb1gx">
<img src="https://drive.google.com/uc?export=view&id=1_CTRCCiZ0X4nG06_xTv48y6MH5vBb1gx">
</a>
<br>

<a target="_blank" href="https://drive.google.com/uc?export=view&id=1i5GrA99gv-EgFIl8Q7V_pherpfaC0w7C">
<img src="https://drive.google.com/uc?export=view&id=1i5GrA99gv-EgFIl8Q7V_pherpfaC0w7C">
</a>
<br>

<a target="_blank" href="https://drive.google.com/uc?export=view&id=1lLqYkY5bAtxVBJXeJ-JNk_IJlCksKo_L">
<img src="https://drive.google.com/uc?export=view&id=1lLqYkY5bAtxVBJXeJ-JNk_IJlCksKo_L">
</a>
<br>

<li> Separated/Attached Tests
</ul>

<h2>Solution Implementation</h2>
<br>

<pre>
• Persona Module (Authentication & Authorization) :
 reusable module called zaghloul-soft/persona-module 
 the user,admin module separated from the app
 also default middlewares overrided this gives you the
 following benefits :
- ability to insert a new module like (Food Delivery)
- utilize your admin,user data again at any project
- separate it to a microservice in case of high traffic.
-------------------------------------------------------
• Ecommerce Module (Core Module) : reusable module
  both modules now you can require it through composer
  at any project.
-------------------------------------------------------
• ERD :
- Product (M) => <= (M) Category 
- Category (O) => (M) Category  [self relation]
-------------------------------------------------------
• Optimize DB :
- index for searchable columns
- Cacheing
- Bulk Insertion
- Eager Loading
- Generators to yield data (cursorPagination)
- DB transactions in case of multiple table insertion
-------------------------------------------------------
• Seed : using Queues with ability to use Bus Batches
-------------------------------------------------------
• Realtime Search : livewire 
• Cache : Redis using L5 Repository
- when to forget cache ? (update - insert - delete)
-------------------------------------------------------
• Service - Repository Layer (benefits):
- make your code reusable ex:
 indexProducts can be used for query in both api/web
 only the response type will changed.
-------------------------------------------------------
• Component - View Layer (benefits):
- make your code reusable ex:
- you can use you product component at any page you need.
-------------------------------------------------------
• Form Request (DTO "Data Transfer Object") (benefits):
- make your code reusable ex:
  CreateProductRequest Used 3 times for (api/web/CLI)
-------------------------------------------------------
• Storage : S3 Public Bucket (data not sensitive)
• Admin Registration Enabled for dev purpose only
-------------------------------------------------------
• Tests:
- both (unit/feature)
</pre>


<h4>CLI Create Product Command</h4>
<pre>
sail php artisan create:product {name}  {price} {--description="mobile phone"} {--category_ids=1,2}
</pre>
<br>

<h3>How To Run The Project Locally</h3>
<pre>
Requirements (all can be installed automatically using docker desktop):
---------------
- PHP 8.2
- Run Docker Desktop
- MySQL 8.0
- Redis
- SQL lite PHP Extension
<hr>
Run the following at the project root dir Terminal
---------------
<ul>
<li>Download Vendor folder
composer install

<li>Make Sail alias
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

<li>Generate .env file from .env.decrypted:
php artisan env:decrypt --key=base64:2xrR+5fd4VR6vgogEwkApSj9LBsVafhyafO1XCoumYo= --force

<li>Run Your local server up:
sail up -d

<li>Run Your local server down:
sail down

<li>To Run Unit/Feature Tests but configure your test with xdebug
sail php artisan test --testsuite={Modules or ModuleName}
</ul>

if you have an issue you can see <a href="https://laravel.com/docs/10.x/sail">Laravel Sail</a>
</pre>

