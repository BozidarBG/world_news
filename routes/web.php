<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');


Route::group(['middleware'=>['auth', 'workers'], 'prefix'=>'admin'], function()
{



    Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');


    //create and manage users by admin
    Route::get('/users', [
        'uses'=>'UserController@index',
        'as'=>'users.index'
    ]);
    Route::get('/users/create', [
        'uses'=>'UserController@create',
        'as'=>'users.create'
    ]);

    Route::post('/users', [
        'uses'=>'UserController@store',
        'as'=>'users.store'
    ]);

    Route::get('/users/edit/{hashid}', [
        'uses'=>'UserController@edit',
        'as'=>'users.edit'
    ]);

    Route::post('/users/update/{hashid}', [
        'uses'=>'UserController@update',
        'as'=>'users.update'
    ]);

    //categories
    Route::get('/categories', [
        'uses'=>'CategoryController@index',
        'as'=>'categories.index'
    ]);

    Route::post('/categories', [
        'uses'=>'CategoryController@store',
        'as'=>'categories.store'
    ]);

    Route::post('/categories/delete/{id}', [
        'uses'=>'CategoryController@destroy',
        'as'=>'categories.destroy'
    ]);

    Route::post('/categories/update/{id}', [
        'uses'=>'CategoryController@update',
        'as'=>'categories.update'
    ]);



//Articles controller methods for admin, moderator & journalist: index, show, trashed

    Route::get('/approved-articles', [
        'uses'=>'ArticleController@approved',
        'as'=>'articles.approved'
    ]);

    Route::get('/unapproved-articles', [
        'uses'=>'ArticleController@unapproved',
        'as'=>'articles.unapproved'
    ]);

    Route::get('/articles/{slug}/show', [
        'uses'=>'ArticleController@show',
        'as'=>'articles.show'
    ]);

    Route::get('/trashed-articles', [
        'uses'=>'ArticleController@trashed',
        'as'=>'articles.trashed'
    ]);

    Route::post('/articles/search-by-title', [
        'uses'=>'ArticleController@searchTitle',
        'as'=>'articles.search-title'
    ]);


//Journalist article controller methods for journalist only: create, store, edit, update, my-news
//destroy, kill, restore
    Route::get('/create-articles', [
        'uses'=>'JournalistArticleController@create',
        'as'=>'articles.create'
    ]);

    Route::get('/my-articles', [
        'uses'=>'JournalistArticleController@myArticles',
        'as'=>'articles.my-articles'
    ]);

    Route::post('/articles', [
        'uses'=>'JournalistArticleController@store',
        'as'=>'articles.store'
    ]);

    Route::get('/articles/{slug}/edit', [
        'uses'=>'JournalistArticleController@edit',
        'as'=>'articles.edit'
    ]);

    Route::post('/articles/update/{slug}', [
        'uses'=>'JournalistArticleController@update',
        'as'=>'articles.update'
    ]);

    Route::post('/articles/destroy/{slug}', [
        'uses'=>'JournalistArticleController@destroy',
        'as'=>'articles.destroy'
    ]);

    Route::post('/articles/{slug}/kill', [
        'uses'=>'JournalistArticleController@kill',
        'as'=>'articles.kill'
    ]);

    Route::get('/articles/{slug}/restore', [
        'uses'=>'JournalistArticleController@restore',
        'as'=>'articles.restore'
    ]);
//Moderator post controller, methods for edit(approve), update, destroy, kill, restore

    Route::get('/articles/{slug}/moderator-edit', [
        'uses'=>'ModeratorArticleController@edit',
        'as'=>'articles.moderator-edit'
    ]);

    Route::post('/articles/moderator-update/{id}', [
        'uses'=>'ModeratorArticleController@approveArticle',
        'as'=>'articles.moderator-update'
    ]);

    Route::post('/articles/moderator-position/{id}', [
        'uses'=>'ModeratorArticleController@articlePosition',
        'as'=>'articles.moderator-article-position'
    ]);

    Route::post('/articles/{slug}/moderator-destroy', [
        'uses'=>'ModeratorArticleController@destroy',
        'as'=>'articles.moderator-destroy'
    ]);

    Route::post('/articles/{slug}/moderator-kill', [
        'uses'=>'ModeratorArticleController@kill',
        'as'=>'articles.moderator-kill'
    ]);

    Route::get('/articles/{slug}/moderator-restore', [
        'uses'=>'ModeratorArticleController@restore',
        'as'=>'articles.moderator-restore'
    ]);
    //Moderator can approve comments and replies
    Route::get('/unapproved-comments', [
        'uses'=>'ModeratorCommentController@unapproved',
        'as'=>'comments.unapproved'
    ]);

    Route::get('/approved-comments', [
        'uses'=>'ModeratorCommentController@approved',
        'as'=>'comments.approved'
    ]);

    Route::post('/comments/update', [
        'uses'=>'ModeratorCommentController@update',
        'as'=>'comment.update'
    ]);

    Route::post('/comments/destroy', [
        'uses'=>'ModeratorCommentController@destroy',
        'as'=>'comment.destroy'
    ]);
    
        //replies...
    Route::get('/unapproved-replies', [
        'uses'=>'ModeratorReplyController@unapproved',
        'as'=>'replies.unapproved'
    ]);

    Route::get('/approved-replies', [
        'uses'=>'ModeratorReplyController@approved',
        'as'=>'replies.approved'
    ]);

    Route::post('/replies/update', [
        'uses'=>'ModeratorReplyController@update',
        'as'=>'reply.update'
    ]);

    Route::post('/replies/destroy', [
        'uses'=>'ModeratorReplyController@destroy',
        'as'=>'reply.destroy'
    ]);

    //settings: administrator can change

    Route::get('/settings/edit', [
        'uses'=>'AdminSettingsController@edit',
        'as'=>'settings.edit'
    ]);

    Route::post('/settings/update', [
        'uses'=>'AdminSettingsController@update',
        'as'=>'settings.update'
    ]);
    //mail routes
    Route::get('/email/compose', [
        'uses'=>'EmailController@compose',
        'as'=>'email.compose'
    ]);

    Route::get('/email/inbox', [
        'uses'=>'EmailController@inbox',
        'as'=>'email.inbox'
    ]);

    Route::get('/email/show/{hashid}', [
        'uses'=>'EmailController@show',
        'as'=>'email.show'
    ]);
    
    Route::get('/email/sent', [
        'uses'=>'EmailController@sent',
        'as'=>'email.sent'
    ]);
    Route::get('/email/drafts', [
        'uses'=>'EmailController@drafts',
        'as'=>'email.drafts'
    ]);
    Route::get('/email/trash', [
        'uses'=>'EmailController@trash',
        'as'=>'email.trash'
    ]);

    Route::post('/email', [
        'uses'=>'EmailController@store',
        'as'=>'email.store'
    ]);

    Route::get('/email/edit/{hashid}', [
        'uses'=>'EmailController@edit',
        'as'=>'email.edit'
    ]);

    Route::get('/email/reply/{hashid}', [
        'uses'=>'EmailController@reply',
        'as'=>'email.reply'
    ]);

    Route::get('/email/forward/{hashid}', [
        'uses'=>'EmailController@forward',
        'as'=>'email.forward'
    ]);

//    Route::post('/email/update/{hashid}', [
//        'uses'=>'EmailController@update',
//        'as'=>'email.update'
//    ]);

    Route::post('/email/delete', [
        'uses'=>'EmailController@delete',
        'as'=>'email.delete'
    ]);

    Route::post('/email/destroy', [
        'uses'=>'EmailController@destroy',
        'as'=>'email.destroy'
    ]);

    Route::post('/email/restore', [
        'uses'=>'EmailController@restore',
        'as'=>'email.restore'
    ]);

    Route::post('/email/favorite/{hashid}', [
        'uses'=>'EmailController@favorite',
        'as'=>'email.favorite'
    ]);

    Route::post('/email/search', [
        'uses'=>'EmailController@search',
        'as'=>'email.search'
    ]);

    //Edit your own profile

    Route::get('/admin/profile/edit', [
        'uses'=>'ProfileController@edit',
        'as'=>'admin.profile.edit'
    ]);

});

Route::group(['middleware'=>'auth'], function()
{
    //user can post comments
    Route::post('/comments', [
        'uses'=>'ModeratorCommentController@store',
        'as'=>'comment.store'
    ]);
    //user can post replies
    Route::post('/replies', [
        'uses'=>'ModeratorReplyController@store',
        'as'=>'reply.store'
    ]);


    //Edit your own profile

    Route::get('/profile/edit', [
        'uses'=>'ProfileController@edit',
        'as'=>'profile.edit'
    ]);

    Route::post('/profile/update', [
        'uses'=>'ProfileController@update',
        'as'=>'profile.update'
    ]);

    Route::post('/profile/delete', [
        'uses'=>'ProfileController@delete',
        'as'=>'profile.delete'
    ]);


});

//frontend routes
Route::get('/results', [
    'uses'=>'FrontendController@search',
    'as'=>'search'
]);

Route::get('/', [
    'uses'=>'FrontendController@index',
    'as'=>'start'
]);

Route::get('/category/{slug}', [
    'uses'=>'FrontendController@byCategory',
    'as'=>'category'
]);

Route::get('/view/{category_slug}/{article_slug}', [
    'uses'=>'FrontendController@show',
    'as'=>'show'
]);
