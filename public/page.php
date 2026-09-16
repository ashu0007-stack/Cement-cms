<?php
require_once dirname(__DIR__) . '/includes/functions.php';
$slug = preg_replace('/[^a-z0-9-]/', '', $_GET['slug'] ?? '');
$stmt = db()->prepare("SELECT * FROM pages WHERE slug=? AND status='published' LIMIT 1"); $stmt->execute([$slug]); $page=$stmt->fetch();
if(!$page){http_response_code(404);exit('Page not found');}
$site=setting('site_name',APP_NAME);
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($page['meta_title'] ?: $page['title'].' | '.$site)?></title><meta name="description" content="<?=e($page['meta_description'])?>"><link rel="stylesheet" href="<?=BASE_URL?>/public/assets/style.css"></head><body><header><div class="container nav"><a class="brand" href="<?=BASE_URL?>/public/"><?=e($site)?> <span>●</span></a><nav class="menu"><a href="<?=BASE_URL?>/public/">Home</a><a href="about-us">About</a><a href="services">Services</a><a href="projects">Projects</a><a href="blog.php">News</a><a href="contact.php">Contact</a></nav></div></header><main class="section"><div class="container content"><div class="eyebrow"><?=e(ucfirst($page['type']))?></div><h1 class="title"><?=e($page['title'])?></h1><?php if($page['featured_image']):?><img style="width:100%;max-height:430px;object-fit:cover" src="<?=UPLOAD_URL.e($page['featured_image'])?>" alt=""><?php endif?><div><?=nl2br(e($page['content']))?></div></div></main></body></html>

