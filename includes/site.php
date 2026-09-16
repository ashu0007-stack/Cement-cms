<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

function site_header(string $title, string $description = ''): void {
    $phone = setting('phone', '9693830075');
    $email = setting('email', 'premiumcement96@gmail.com');
    ?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($title)?> | Premium Group Cement</title><meta name="description" content="<?=e($description)?>"><link rel="stylesheet" href="<?=BASE_URL?>/public/assets/style.css"><link rel="stylesheet" href="<?=BASE_URL?>/public/assets/site.css"><?php if($title==='Home'):?><link rel="stylesheet" href="<?=BASE_URL?>/public/assets/home.css"><?php endif?></head><body>
    <div class="top"><div class="container top-row"><span>Premium Power Cement - Strength Behind Every Landmark</span><span><a href="tel:+91<?=$phone?>">+91 <?=e($phone)?></a> &nbsp; | &nbsp; <a href="mailto:<?=$email?>"><?=e($email)?></a></span></div></div>
    <header class="site-header"><div class="container nav"><a href="<?=BASE_URL?>/public/" class="logo"><img src="<?=BASE_URL?>/public/uploads/premium-logo.png" alt="Premium Group Cement"></a><button class="menu-toggle" onclick="document.querySelector('.menu').classList.toggle('open')">Menu</button><nav class="menu"><a href="<?=BASE_URL?>/public/">Home</a><a href="<?=BASE_URL?>/public/about.php">About</a><a href="<?=BASE_URL?>/public/products.php">Products</a><a href="<?=BASE_URL?>/public/why-us.php">Why Us</a><a href="<?=BASE_URL?>/public/quality.php">Quality</a><a href="<?=BASE_URL?>/public/dealer.php">Dealers</a><a href="<?=BASE_URL?>/public/blog.php">Blog</a><a href="<?=BASE_URL?>/public/contact.php">Contact</a></nav></div></header><?php
}

function page_banner(string $eyebrow, string $title, string $text): void { ?>
<section class="page-hero"><div class="container"><div class="eyebrow"><?=e($eyebrow)?></div><h1><?=e($title)?></h1><p><?=e($text)?></p></div></section><?php }

function site_footer(): void {
    $phone=setting('phone','9693830075'); $email=setting('email','premiumcement96@gmail.com'); ?>
    <footer class="footer"><div class="container footer-grid"><div><img class="footer-logo" src="<?=BASE_URL?>/public/uploads/premium-logo.png" alt="Premium Group Cement"><p>High-quality PPC cement for strong, durable and long-lasting construction.</p></div><div><h3>Quick Links</h3><a href="products.php">Products</a><a href="quality.php">Quality</a><a href="dealer.php">Become a Dealer</a><a href="contact.php">Contact</a></div><div><h3>Contact</h3><p><a href="tel:+91<?=$phone?>">+91 <?=e($phone)?></a><br><a href="mailto:<?=$email?>"><?=e($email)?></a></p><p>111, 2nd Floor, Vinayak Plaza, Maldahiya, Varanasi, U.P. 221010</p></div></div><div class="container copyright">© <?=date('Y')?> Premium Group Cement. All rights reserved.</div></footer><a class="whatsapp" href="https://wa.me/91<?=$phone?>" target="_blank" aria-label="WhatsApp">WA</a></body></html><?php
}

function product_data(string $slug): ?array {
    try {
      $stmt=db()->prepare("SELECT * FROM products WHERE slug=? AND status='published' LIMIT 1");
      $stmt->execute([$slug]); $row=$stmt->fetch();
      if($row){$row['features']=array_values(array_filter(array_map('trim',preg_split('/\r?\n/',$row['features']??''))));$row['applications']=array_values(array_filter(array_map('trim',preg_split('/\r?\n/',$row['applications']??''))));$row['tag']=$row['tagline'];$row['desc']=$row['description'];return $row;}
    } catch (PDOException $e) { /* Migration has not been run yet; use starter data. */ }
    $all=[
      'premium-ppc'=>['name'=>'Premium PPC Cement','tag'=>'The Ultimate Strength','desc'=>'Manufactured using quality clinker and fly ash for superior durability, workability and long-term strength.','features'=>['High strength and smooth finishing','Low heat of hydration','Improved workability','Reduced cracking','ISI and ISO quality standards'],'applications'=>['RCC work','Slab and foundation','Plastering','Brickwork','Roads and pavements']],
      'concrete-gold'=>['name'=>'Concrete Gold Cement','tag'=>'The Next Generation Cement','desc'=>'A high-performance PPC cement designed for superior binding strength and durable structural construction.','features'=>['Superior binding strength','Crack-resistant performance','High durability','Consistent setting','Reliable structural performance'],'applications'=>['Structural construction','Residential buildings','Commercial projects','Foundations','General concrete work']],
      'premium-power'=>['name'=>'Premium Power Cement','tag'=>'Strength Behind Every Landmark','desc'=>'A quality-assured cement solution with enhanced load-bearing performance for residential and commercial projects.','features'=>['Enhanced load-bearing capacity','Weather resistant','Long service life','Consistent quality','50 KG standard packaging'],'applications'=>['Homes and apartments','Commercial buildings','Masonry work','Plastering','Concrete applications']]
    ]; return $all[$slug]??null;
}
