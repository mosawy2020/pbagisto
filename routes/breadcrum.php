<?php


use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


// Home
Breadcrumbs::for('home', function ($trail) {
$trail->push('Home', route('shop.home.index'));
});

// Category
Breadcrumbs::for('category', function ($trail,$category) {
$trail->parent('home');
$trail->push($category->name, route('shop.productOrCategory.index', $category->url_path));
});