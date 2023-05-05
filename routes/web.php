<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => 'Front', 'prefix' => '/'], function () {

    Route::get('/dmca',                                  'HomeController@footer_dmca');
    Route::get('/privacy',                               'HomeController@footer_privacy');
    Route::get('/service',                               'HomeController@footer_service');
    Route::get('/guidelines',                            'HomeController@footer_guidelines');
    Route::get('/contact-us',                            'ContactController@index');
    Route::post('/contact-us',                           'ContactController@submit');
    Route::get('/2257',                                  'HomeController@footer_2257');
    Route::post('/check/phoneno',                        'RegisterController@phoneno');
    Route::post('/valid/phoneno',                        'RegisterController@phonenovoip');
    Route::post('/send/verification/code',               'RegisterController@sendverificationcode');
    Route::group(['middleware' => 'userguest'], function () {
        // HOME

        Route::get('/',                                      'HomeController@index');
        Route::get('/login',                                 'LoginController@login');
        Route::post('/login',                                'LoginController@submit');
        Route::get('/forgot-password',                       'ResetPasswordController@forgotpassword');
        Route::post('/forgot-password',                      'ResetPasswordController@forgotsubmit');
        Route::get('/reset-password/{token}',                'ResetPasswordController@resetpassword');
        Route::post('/reset-password',                       'ResetPasswordController@resetsubmit');

        Route::get('/signup',                                'RegisterController@index');
        Route::post('/signup',                               'RegisterController@submit');
        Route::post('/complete/verification/code',           'RegisterController@completeverificationcode');
        Route::post('/check/username',                       'RegisterController@username');
        Route::post('/check/email',                          'RegisterController@email');
        
        Route::get('/user-verification/{token}',             'RegisterController@verification');
        Route::post('/resend/verification',                  'RegisterController@resendverification');
    });

    Route::group(['middleware' => 'userauth'], function () {
        Route::group(['middleware' => 'checkblockuser'], function () {
            Route::get('/profile/{user_id?}',                         'ProfileController@profile');
            Route::get('/user-images/{user_id?}',                     'ProfileController@userimages');
            Route::post('/user-images/load/{user_id}',                'ProfileController@loaduserimages');
            Route::get('/image-detail/{media_id}/{user_id?}',         'ProfileController@imagedetail');
            Route::get('/user-video/{user_id?}',                      'ProfileController@uservideo');
            Route::post('/user-video/load/{user_id}',                 'ProfileController@loaderuservideo');
            Route::get('/video-detail/{media_id}/{user_id?}',         'ProfileController@videodetail');
        });

        Route::get('/logout',                                'LoginController@logout');
        Route::get('/profile/block/{user_id}',                'ProfileController@blockUserView');

        Route::post('/profile',                              'ProfileController@profilesubmit');
        Route::get('/about',                                 'ProfileController@about');
        Route::post('/about',                                'ProfileController@aboutedit');
        Route::get('/filters',                               'ProfileController@filters');
        Route::get('/upload-image',                          'ProfileController@uploadimages');
        Route::post('/upload-image',                         'ProfileController@uploadimagesubmit');
        Route::get('/upload-videos',                         'ProfileController@uploadvideos');
        Route::post('/upload-videos',                        'ProfileController@uploadvideossubmit');
        Route::get('/settings',                              'ProfileController@settings');
        Route::post('/settings',                             'ProfileController@settingsubmit');
        Route::get('/notifications',                         'ProfileController@notifications');
        Route::post('/notifications',                         'ProfileController@notificationsubmit');
        Route::post('/image-detail',                         'ProfileController@imagedetailsubmit');
        Route::post('/delete-image',                         'ProfileController@deleteimage');
        Route::post('/tag-update',                           'ProfileController@imagetagupdate');
        Route::post('image/show-to',                         'ProfileController@imageshow');
        Route::post('/expose-image',                         'ProfileController@exposedimage');
        Route::post('/video-detail',                         'ProfileController@videodetailsubmit');
        Route::post('/delete-video',                         'ProfileController@deletevideo');
        Route::post('/video-tag-update',                     'ProfileController@videotagupdate');
        Route::post('video/show-to',                         'ProfileController@videoshow');
        Route::post('/expose-video',                         'ProfileController@exposedvideo');
        Route::post('/media/comment',                        'ProfileController@mediacomment');
        Route::post('/media/comment-reply',                  'ProfileController@mediarplcomment');
        Route::post('/media/delete/comment',                 'ProfileController@mediadeletecomment');
        Route::post('/media/delete/reply-comment',           'ProfileController@mediarpldeletecomment');
        Route::post('/delete-account',                       'ProfileController@deleteAccount');
        Route::post('/block-user',                           'ProfileController@blockUser');
        Route::post('/follow',                               'ProfileController@follow');
        Route::post('/unfollow',                             'ProfileController@unfollow');
        
        Route::get('/verify-phone',                          'VerifyController@index');
        Route::post('/verify-phone',                         'VerifyController@submit');

        Route::get('/exposed',                               'ExposeController@index');
        Route::post('/exposed/load',                           'ExposeController@load');

        // Route::get('/videos',                                 'MediaController@video');
        Route::get('/videos',                                 'MediaController@allvideos');
        Route::post('/videos/load',                           'MediaController@videosload');
        Route::get('/all-videos',                             'MediaController@allvideos');
        Route::get('/image',                                  'MediaController@image');
        Route::post('/image/load',                            'MediaController@loadimage');
        Route::post('/media-like',                            'MediaController@medialike');

        Route::get('/conversation',                           'ConversationController@index');
        Route::post('/conversation',                          'ConversationController@submit');
        Route::post('/conversation-delete',                   'ConversationController@deleteconversation');
        Route::get('/conversation-details/{conversation_id}', 'ConversationController@conersationdetails');
        Route::post('/conversation-details',                  'ConversationController@submitconersationdetilas');
        Route::post('/conversation-mark-read',                'ConversationController@conversationmarkread');


        Route::get('/conversation-sent',                      'ConversationController@conversationsent');
        Route::get('/conversation-archived',                  'ConversationController@conversationarchived');

        Route::get('/feed',                                  'FeedController@index');
        Route::post('/feed/load',                            'FeedController@load');
        Route::post('/feed',                                 'FeedController@submit');
        Route::post('/feed/comment',                         'FeedController@submitComment');
        Route::post('/feed/delete/comment',                  'FeedController@deleteComment');
        Route::post('/feed/delete',                          'FeedController@deleteFeed');

        Route::get('/expose',                                'ExposeController@index');

        Route::get('/friend-requests',                       'FriendController@index');
        Route::post('/friend-request',                       'FriendController@submit');
        Route::post('/friend-request-cancel',                'FriendController@friendrequestcancel');
        Route::post('/friend-remove',                        'FriendController@friendremove');
        Route::post('/friend-request-decline',               'FriendController@frienddecline');
        Route::post('/friend-request-accept',                'FriendController@friendaccept');
        Route::get('/friends/{id?}',                         'FriendController@friends');

        Route::get('/location/{statename?}/{city_name?}',     'LocationController@index');
        Route::get('/member/{statename?}/{city_name?}',       'LocationController@member');
        Route::get('/casual-encounter',                      'LocationController@casualencounter');
        Route::get('/ad-category',                           'LocationController@postadcategory');
        Route::get('/chnagelocation',                        'LocationController@chnagelocation');
        Route::get('/selectcity/{statename?}',               'LocationController@selectcity');
        Route::get('/create-ad/{category}',                  'LocationController@createad');
        Route::post('/create-ad',                            'LocationController@createadsubmit');
        Route::get('/view-ad/{slug}',                        'LocationController@viewad');
        Route::post('/contact-ad-post',                      'LocationController@contactadpost');
        Route::post('/delete-ad',                            'LocationController@deletead');

        Route::get('/group',                                 'GroupController@index');
        Route::get('/creategroup',                           'GroupController@creategroup');
        Route::post('/creategroup',                          'GroupController@submitcreategroup');
        Route::get('/discussion/{group_id}',                 'GroupController@discussion');
        Route::get('/creatediscussion/{group_id}',           'GroupController@creatediscussion');
        Route::post('/creatediscussion',                     'GroupController@submitcreatediscussion');
        Route::post('/group-mark-read',                      'GroupController@groupmarkread');
        Route::get('/groups',                                'GroupController@groups');
        Route::get('/view-discussion/{id}',                  'GroupController@viewdiscussion');
        Route::get('/search/group',                          'GroupController@searchgroup');
        Route::get('/most-popular-groups',                   'GroupController@mostpopulargroup');
        Route::get('/newest-groups',                         'GroupController@newestgroup');
        Route::post('/search/group',                         'GroupController@searchgroup');
        Route::post('/request-join-group',                   'GroupController@requestgroup');
        Route::post('/join-group',                           'GroupController@joingroup');
        Route::post('/delete-group',                         'GroupController@deletegroup');
        Route::get('/edit-group/{id}',                       'GroupController@editview');
        Route::post('/submit/edit-group',                    'GroupController@editsubmit');
        Route::post('/delete-discussion',                    'GroupController@deletediscussion');
        Route::get('/edit-discussion/{discussion_id}',       'GroupController@editdiscussion');
        Route::post('/edit-discussion',                      'GroupController@submiteditdiscussion');
        Route::post('/discussion/comment',                   'GroupController@discussioncomment');
        Route::post('/discussion/like',                      'GroupController@discussionlike');
        Route::post('/discussion/close',                     'GroupController@discussionclose');
        Route::post('/discussion/comment-reply',             'GroupController@discussionrplcomment');
        Route::get('/add-member-default-group',              'GroupController@addownermembergroup');
        Route::get('/group-member/{group_id}',               'GroupController@groupmember');

        Route::get('/kink',                                   'KinkController@index');
        Route::post('/kink',                                  'KinkController@submitkink');
        Route::get('/kink-members/{tag_id}',                  'KinkController@kinkmember');

        Route::get('/notification-list',                      'NotificationController@index');
        Route::post('/notification-mark-read',                'NotificationController@notificationmarkread');

        Route::Post('/search',                                'SearchController@search');
        Route::get('/tab', function(){
            return view_front('tab');
        });

        Route::get('/seo',                                     'SeoController@index');
        Route::post('/seo',                                    'SeoController@submit');
        Route::post('/seo/page',                               'SeoController@getpage');


    });
});

Route::group(['namespace' => 'Manage'], function () {
});


// SESSION AND CACHE ROUTES
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return "View cache is cleared";
});
Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return "Config cache is cleared";
});
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return "Config is cleared";
});
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return "route cache is cleared";
});
// SESSION AND CACHE ROUTES
