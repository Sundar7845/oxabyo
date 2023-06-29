<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Home Page, Tournament, Players, Pricing
|--------------------------------------------------------------------------
|
*/
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tournament', 'HomeController@getTournaments')->name('tournament');
Route::get('/g_players', 'HomeController@guestPlayers')->name('guest.players');
Route::get('/pricing','PricingController@pricing')->name('pricing.g_pricing');
Route::get('/events/{id}/event-detail', 'Event\EventsController@eventDetails')->name('events.event-detail');

/*
|--------------------------------------------------------------------------
| Contact us
|--------------------------------------------------------------------------
|
*/
Route::get('/contact','HomeController@contact')->name('contact');
Route::post('/contact','HomeController@sendContactEmail')->name('contacts');
/*
|--------------------------------------------------------------------------
| Privacy policy & Cookie policy
|--------------------------------------------------------------------------
|
*/
Route::get('/privacy','HomeController@privacy')->name('privacy');
Route::get('/cookie','HomeController@cookie')->name('cookie');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/
Auth::routes();
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| User Activation Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/user-activation/{token}', 'UserController@userActivation')->name('user-activation');
Route::get('/account_activation', 'HomeController@accountActivationView')->name('account_activation');
/*
|--------------------------------------------------------------------------
| Reset and Forget password routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => '/password'], function() {
    Route::post('/email' , 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/reset/{token}', 'Auth\ResetPasswordController@showResetForm')
        ->name('password.reset');
});

/*
|--------------------------------------------------------------------------
| Non Admin user middleware groups
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['auth', 'auth.user', 'auth.account-activation']], function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard and User Profile
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::post('/profile', 'UserController@updateProfile');
    Route::get('/wallet','WalletController@wallet')->name('wallet');
    Route::post('/twitch/user', 'Twitch\TwitchIntegrationController@storeTwitchUser')->name('twitch.user');
    // Route::get('/twitch/user', 'Twitch\TwitchIntegrationController@getTwitchUser');
    
    /*
    |--------------------------------------------------------------------------
    | User Notification
    |--------------------------------------------------------------------------
    |
    */
     Route::resource('/notification', 'NotificationController');
   
    /*
    |--------------------------------------------------------------------------
    | User Search
    |--------------------------------------------------------------------------
    |
    */
    Route::post('/search','Search\SearchController@search')->name('search');
    
    /*
    |--------------------------------------------------------------------------
    | Handling Team routes
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('teams', 'Team\TeamController');    
    Route::get('/teams/{id}/addAdmin', 'Team\TeamController@assignTeamAsAdmin')->name('team-member.addAdmin');
    Route::get('/teams/{id}/removeAdmin', 'Team\TeamController@removeAdminFromTeamMember')->name('team-member.removeAdmin');
    Route::get('/teams/{id}/ban-member', 'Team\TeamController@banTeamMember')->name('team-member.banMember');
    Route::get('/teams/{id}/unban-member', 'Team\TeamController@unbanTeamMember')->name('team-member.unbanMember');
    Route::post('/teams/{id}/teams-invite', 'Team\TeamController@inviteUsers')->name('teams.invite'); 
    Route::get('/team-activation/{token}', 'Team\TeamController@teamActivation')->name('team-activation');
    Route::get('/team-activation-decline/{token}', 'Team\TeamController@teamDeclineActivation')->name('team-activation-decline');
    Route::get('/teams/{id}/join', 'Team\TeamController@joinTeam')->name('teams.join');
    Route::get('/team-join-accept/{token}', 'Team\TeamController@acceptJoin')->name('team-join-accept');
    Route::get('/team-join-decline/{token}', 'Team\TeamController@declineJoin')->name('team-join-decline');

    /*
    |--------------------------------------------------------------------------
    | Handling User Interactions
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/users/{id}/player-detail', 'Users\UserInteractionController@playerDetails')->name('users.player-detail');
    Route::get('/users/{id}/connect', 'Users\UserInteractionController@connectUser')->name('users.connect');
    Route::post('/users/{id}/un-connect', 'Users\UserInteractionController@unConnectUser')->name('users.un-connect');
    Route::get('/users/{id}/addUserasFriend', 'Users\UserInteractionController@addUserasFriend')->name('users.add-friend');
    Route::post('/users/{id}/block', 'Users\UserInteractionController@blockUser')->name('users.block');
    Route::post('/users/{id}/un-block', 'Users\UserInteractionController@unblockUser')->name('users.un-block');
    Route::get('/users/{id}/like', 'Users\UserInteractionController@likeUser')->name('users.like');
    Route::get('/users/{id}/un-like', 'Users\UserInteractionController@dislikeUser')->name('users.un-like');
    Route::post('/users/{id}/users.report-abuse', 'Users\UserInteractionController@reportAbuse')->name('users.report-abuse');
    Route::get('/users-approve-connection/{token}', 'Users\UserInteractionController@approveConnection')->name('users.approve-connection');
    Route::get('/users-decline-connection/{token}', 'Users\UserInteractionController@declineConnection')->name('users.decline-connection');
    Route::get('/player-list', 'Users\UserInteractionController@getPlayerList')->name('user.player-list');
   
    /*
    |--------------------------------------------------------------------------
    | Games
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('/games', 'Games\GameController');
    Route::get('/games/played/{id}','Games\GameController@storeUserGame')->name('games-played');  
    
    /*
    |--------------------------------------------------------------------------
    | Handling Send message feature
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('message-list', 'Messages\MessageController');     
    Route::post('/users/{id}/send-message', 'Messages\MessageController@sendMessage')->name('users.send-message');    
    Route::post('message-list/delete', 'Messages\MessageController@delete')->name('message-list.delete');

    /*
    |--------------------------------------------------------------------------
    | Handling Events feature
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('events', 'Event\EventsController');
    Route::get('/event/event-create-one-shot', 'Event\EventsController@eventCreateOneShot')->name('events.create-one-shot');
    Route::get('/event/event-create-single-player', 'Event\EventsController@eventCreateSinglePlayer')->name('events.create-single-player');
    Route::get('/event/event-create-challenge-round', 'Event\EventsController@eventCreateChallengeRound')->name('events.create-challenge-round');
    Route::get('/event-invite-accept/{token}', 'Event\EventsController@acceptInvite')->name('event-invite-accept');
    Route::get('/event-invite-decline/{token}', 'Event\EventsController@declineInvite')->name('event-invite-decline');
    Route::get('/event-invite-admin-accept/{token}', 'Event\EventsController@acceptAdminInvite')->name('event-invite-admin-accept');
    Route::get('/event-invite-admin-decline/{token}', 'Event\EventsController@declineAdminInvite')->name('event-invite-admin-decline');
    Route::get('/event-invite-team-accept/{token}', 'Event\EventsController@acceptTeamInvite')->name('event-invite-team-accept');
    Route::get('/event-invite-team-decline/{token}', 'Event\EventsController@declineTeamInvite')->name('event-invite-team-decline');
    Route::post('/event-invite-custom', 'Event\EventsController@customEventInvite')->name('event-invite-custom');
    Route::delete('/event-player/{id}', 'Event\EventsController@removeEventPlayer')->name('event-player-delete');
    Route::post('/events/search', 'Event\EventsController@searchEvents')->name('events-search');
    Route::get('/event/{id}/join', 'Event\EventsController@joinEvent')->name('events.join');
    Route::get('/event-join-accept/{token}', 'Event\EventsController@acceptJoin')->name('event-join-accept');
    Route::get('/event-join-decline/{token}', 'Event\EventsController@declineJoin')->name('event-join-decline'); 

    /*
    |--------------------------------------------------------------------------
    | Handling Calender Matches or Fixtures
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('fixtures', 'Event\FixtureController');
    Route::get('/switch-winner/{id}/{event_id}', 'Event\FixtureController@switchWinner')->name('event.switch-winner');

    /*
    |--------------------------------------------------------------------------
    | Handling Comments
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('comments', 'Event\CommentsController');
    Route::post('/comment/store', 'Event\CommentsController@store')->name('comment.store');
    
    
    Route::get('/groups', 'Groups\GroupController@index')->name('groups.index');
    Route::get('/groups/create', 'Groups\GroupController@create')->name('groups.create');
    Route::get('/groups/{id}', 'Groups\GroupController@show')->name('groups.show');
    Route::get('/groups/{id}/edit', 'Groups\GroupController@edit')->name('groups.edit');
    Route::post('/groups/store', 'Groups\GroupController@store')->name('groups.store');
    Route::put('/groups/{id}/update',  'Groups\GroupController@update')->name('groups.update');
    Route::put('/groups/{id}/invite',  'Groups\GroupController@invite')->name('groups.invite');
    Route::get('/groups-activation/{token}', 'Groups\GroupController@groupsActivation')->name('groups-activation');
    Route::get('/groups-activation-decline/{token}', 'Groups\GroupController@groupDeclineActivation')->name('groups-activation-decline');
    Route::get('/groups/{id}/join', 'Groups\GroupController@joinGroups')->name('groups.join');
    Route::get('/groups-join-approve/{token}', 'Groups\GroupController@joinAccept')->name('groups-join-approve');
    Route::get('/groups-join-decline/{token}', 'Groups\GroupController@joinDecline')->name('groups-join-decline');
    Route::get('/groups/{id}/addAdmin', 'Groups\GroupController@addAdmin')->name('groups-member.addAdmin');
    Route::get('/groups/{id}/removeAdmin', 'Groups\GroupController@removeAdminFromGroupMember')->name('groups-member.removeAdmin');
    Route::get('/groups/{id}/ban-member', 'Groups\GroupController@banGroupMember')->name('groups-member.banMember');
    Route::get('/groups/{id}/unban-member', 'Groups\GroupController@unbanGroupMember')->name('groups-member.unbanMember');
    Route::post('/groups/{id}/message', 'Groups\GroupController@sendMessage')->name('groups.message');

    Route::get('/group/{id}/all-comments', 'Groups\GroupController@getAllComments')->name('groups.comments');


    /*
    |--------------------------------------------------------------------------
    | Paypal Integration Block
    |--------------------------------------------------------------------------
    |
    */
    Route::get('payment-checkout/{plan_type}', 'Paypal\PaypalController@checkout')->name('paypal.checkout');
    

    Route::post('payment-checkout/create-order','Paypal\PaypalController@check')->name('paypal.checkout');
    Route::post('payment-checkout/capture/{orderId}/capture','Paypal\PaypalController@capture')->name('paypal.checkout');

});

/*
|--------------------------------------------------------------------------
| Admin Route groups
|--------------------------------------------------------------------------
|
*/
Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');
    Route::get('/profile', 'HomeController@profile')->name('admin.profile');
    Route::post('/save-profile', 'HomeController@saveProfile')->name('admin.save-profile');

    /*
    |--------------------------------------------------------------------------
    | User Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('user-management', 'UserManagementController')->except('destroy');
    Route::put('/user-management/{id}/block', 'UserManagementController@blockUser')->name('user.block');
    Route::put('/user-management/{id}/un-block', 'UserManagementController@unblockUser')->name('user.unblock');

    /*
    |--------------------------------------------------------------------------
    | Events Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('event-management', 'EventManagementController');
    Route::put('/event-management/{id}/hide', 'EventManagementController@hideEvent')->name('event.hide');
    Route::put('/event-management/{id}/un-hide', 'EventManagementController@showEvent')->name('event.unhide');

    /*
    |--------------------------------------------------------------------------
    | Games Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('game-management', 'GameManagementController');
    Route::put('/game-management/{id}/hide', 'GameManagementController@hideGame')->name('game.hide');
    Route::put('/game-management/{id}/un-hide', 'GameManagementController@showGame')->name('game.unhide');

    /*
    |--------------------------------------------------------------------------
    | Group Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('group-management', 'GroupManagementController');
    Route::put('/group-management/{id}/hide', 'GroupManagementController@hideGroup')->name('group.hide');
    Route::put('/group-management/{id}/un-hide', 'GroupManagementController@showGroup')->name('group.unhide');
    Route::get('/group-management/{id}/members', 'GroupManagementController@members')->name('group-management.members');

    /*
    |--------------------------------------------------------------------------
    | Group Management Members
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('group-member-management', 'GroupMemberController');
    Route::put('/group-member-management/{id}/hide', 'GroupMemberController@hideGroup')->name('group-member-management.hide');
    Route::put('/group-member-management/{id}/un-hide', 'GroupMemberController@showGroup')->name('group-member-management.unhide');

    /*
    |--------------------------------------------------------------------------
    | Team Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('team-management', 'TeamManagementController');
    Route::put('/team-management/{id}/hide', 'TeamManagementController@hideTeam')->name('team.hide');
    Route::put('/team-management/{id}/un-hide', 'TeamManagementController@showTeam')->name('team.unhide');
    Route::get('/team-management/{id}/members', 'TeamManagementController@members')->name('team-management.members');

    /*
    |--------------------------------------------------------------------------
    | Team member managements
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('team-member-management', 'TeamMemberController');
    Route::put('/team-member-management/{id}/hide', 'TeamMemberController@hideTeam')->name('team-member-management.hide');
    Route::put('/team-member-management/{id}/un-hide', 'TeamMemberController@showTeam')->name('team-member-management.unhide');
    Route::put('/team-member-management/{id}/add-admin', 'TeamMemberController@addTeamAdmin')->name('team-member-management.add-admin');
    Route::put('/team-member-management/{id}/remove-admin', 'TeamMemberController@removeTeamAdmin')->name('team-member-management.remove-admin');

    /*
    |--------------------------------------------------------------------------
    | Comments Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('comment-management', 'CommentManagementController');
    Route::put('/comment-management/{id}/hide', 'CommentManagementController@hideComment')->name('comment.hide');
    Route::put('/comment-management/{id}/un-hide', 'CommentManagementController@showComment')->name('comment.unhide');

    /*
    |--------------------------------------------------------------------------
    | Sliders Management Actions
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('slider-management', 'SliderManagementController');
    Route::get('/setup-prizing', 'PrizingController@index')->name('admin.setup-prizing.index');
    //  Route::get('/create', 'PrizingController@create')->name('admin.setup-prizing.create');
    Route::get('setup-prizing/{id}/edit', 'PrizingController@edit')->name('admin.setup-prizing.edit');
    Route::post('setup-prizing/store', 'PrizingController@store')->name('admin.setup-prizing.store');
    // Route::get('/destroy', 'PrizingController@destroy')->name('admin.setup-prizing.destroy');
    Route::post('setup-prizing/{id}/update', 'PrizingController@update')->name('admin.setup-prizing.update');

    //permission 

    // Route::get('permission-Management', 'PermissionController@index')->name('admin.permission.index');
    // //  Route::get('permission-Management/create', 'PermissionController@create')->name('admin.setup-prizing.create');
    // Route::get('permission-Management/{id}/edit', 'PermissionController@edit')->name('admin.permission.edit');
    // Route::post('permission-Management/store', 'PermissionController@store')->name('admin.permission.store');
    // // Route::get('permission-Management/destroy', 'PermissionController@destroy')->name('admin.setup-prizing.destroy');
    // Route::post('permission-Management/{id}/update', 'PermissionController@update')->name('admin.permission.update');

    /**
     * 
     */
    Route::get('subscription-permission', 'PermissionController@index')->name('admin.permission.index');
    Route::get('subscription-permission/{id}/edit', 'PermissionController@edit')->name('admin.permission.edit');
    Route::post('subscription-permission/store', 'PermissionController@store')->name('admin.permission.store');
    Route::post('subscription-permission/{id}/update', 'PermissionController@update')->name('admin.permission.update');

});


