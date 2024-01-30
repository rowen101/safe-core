<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.safexpress.index'));
});

// Home > User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('User', url('app/SLI/user'));
});

// Home > User > [Create]
Breadcrumbs::for('createuser', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Create', url('app/SLI/user/create'));
});
// Home > User > [update]
Breadcrumbs::for('edituser', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Edit User', url('app/SLI/user/edit'));
});
////////////////////////////////////////////


// Home > App
Breadcrumbs::for('apps', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Application', url('app/SLI/apps'));
});

// Home > App > [Create]
Breadcrumbs::for('createapps', function (BreadcrumbTrail $trail) {
    $trail->parent('apps');
    $trail->push('Create', url('app/SLI/app/create'));
});
// Home > App > [update]
Breadcrumbs::for('editapps', function (BreadcrumbTrail $trail) {
    $trail->parent('apps');
    $trail->push('Edit App', url('app/SLI/app/edit'));
});
////////////////////////////////////////////////


// Home > Menu
Breadcrumbs::for('menu', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Menu', url('app/SLI/menu'));
});

// Home > Menu > [Create]
Breadcrumbs::for('createmenu', function (BreadcrumbTrail $trail) {
    $trail->parent('menu');
    $trail->push('Create', url('app/SLI/menu/create'));
});
// Home > Menu > [update]
Breadcrumbs::for('editmenu', function (BreadcrumbTrail $trail) {
    $trail->parent('menu');
    $trail->push('Edit Menu', url('app/SLI/menu/edit'));
});
///////////////////////////////
// Home > Gallery
Breadcrumbs::for('gallery', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Gallery', url('app/SLI/gallery'));
});

// Home > Menu > [Create]
Breadcrumbs::for('creategallery', function (BreadcrumbTrail $trail) {
    $trail->parent('gallery');
    $trail->push('Create', url('app/SLI/gallery/create'));
});
// Home > Menu > [iamge]
Breadcrumbs::for('imagegallery', function (BreadcrumbTrail $trail) {
    $trail->parent('gallery');
    $trail->push('Image', url('app/SLI/gallery/create'));
});
////////////////////////////////////////////////


// Home > Post
Breadcrumbs::for('post', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Post', url('app/SLI/post'));
});

// Home > Post > [Create]
Breadcrumbs::for('createpost', function (BreadcrumbTrail $trail) {
    $trail->parent('post');
    $trail->push('Create', url('app/SLI/post/create'));
});
// Home > Post > [update]
Breadcrumbs::for('editpost', function (BreadcrumbTrail $trail) {
    $trail->parent('post');
    $trail->push('Edit Post', url('app/SLI/post/edit'));
});
////////////////////////////////////////////////



// Home > Post
Breadcrumbs::for('categorie', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Cateogorie', url('app/SLI/categorie'));
});
//////////////////////////////////////////
// Home > branch
Breadcrumbs::for('branch', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Branch Setup', url('app/SLI/branch-setup'));
});
//////////////////////////////////////////
// Home > branch
Breadcrumbs::for('board', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Bord of Director', url('app/SLI/bderictor'));
});
///////////////////////////////
// Home > Client
Breadcrumbs::for('client', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Client', url('app/SLI/client'));
});
///////////////////////////////
// Home > Carousel
Breadcrumbs::for('carousel', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Carousel', url('app/SLI/carousel'));
});
