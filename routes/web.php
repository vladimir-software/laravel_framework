<?php
Route::get('/survey', function () {
    return redirect("home");
});


Route::get('/ss', function () {
    echo 'hi';
});

if (Auth::check()) {
    Route::get('/', 'SurveyController@home')->name('home');
} else {
    Route::get('/', 'HomeController@index')->name('index');
}

//Upload Video
Route::post('addvideo', 'HomeController@addvideo')->name('addvideo');
Route::post('updatevideo','HomeController@updatevideo')->name('updatevideo');
Route::post('removevideo','HomeController@removevideo')->name('removevideo');

// HOME CONTROLLER
Route::get('terms-of-use', 'HomeController@termsOfUse')->name('terms_of_use');
Route::get('privacy-policy', 'HomeController@privacyPolicy')->name('privacy-policy');
Route::get('facebook-login', 'HomeController@facebookLogin')->name('registration.facebook-login');
Route::post('facebookSignup', 'HomeController@facebookSignup')->name('facebookSignup');
Route::get('checkIsFB', 'HomeController@checkIsFB')->name('checkIsFB');
Route::post('submitContactUs', 'HomeController@submitContactUs')->name('submitContactUs');
Route::get('sidenav', 'HomeController@sidenav')->name('sidenav');
Route::get('videos', 'HomeController@videos')->name('videos');

// NEW HOME PAGE
Route::get('main-page', 'HomeController@mainPage')->name('main-page');
Route::get('testing', 'HomeController@testing')->name('message_testing');
Route::get('project/{id?}', 'HomeController@project')->name('project');
Route::post('project-edit', 'HomeController@projectEdit')->name('projectEdit');
Route::post('project-task-edit', 'HomeController@projectTaskEdit')->name('projectTaskEdit');
Route::post('project-task-details', 'HomeController@projectTaskDetails')->name('projectTaskEditDetails');
Route::post('project-approve', 'HomeController@projectApprove')->name('projectApprove');

// SIDE MENU ITEMS
Route::get('how-to-connect', 'HomeController@howToConnect')->name('side_menu_items.how_to_connect');
Route::get('pricing', 'HomeController@pricing')->name('side_menu_items.pricing');
Route::get('contact-us', 'HomeController@contactUs')->name('side_menu_items.contact_us');

// REGISTRATION
Route::get('login', 'HomeController@login')->name('login');
Route::get('signup', 'HomeController@signup')->name('signup');

// RESET PASSWORD
Route::get('reset-password', 'HomeController@ResetPassword')->name('password.reset-password');
Route::post('passwordEmail', 'HomeController@passwordEmail')->name('password.passwordEmail');
Route::get('password/reset/{token}', 'HomeController@showResetForm')->name('password.create-new-password');
Route::post('ajaxUserSearch', 'HomeController@ajaxUserSearch')->name('ajaxUserSearch');

// AJAX CONTROLLER
Route::post('changeUserPassword', 'AjaxController@changeUserPassword');

// logout
Route::post('logout', 'HomeController@logout')->name('logout');
Route::get('logout', 'HomeController@logout')->name('logout');

// AJAX CONTROLLER
Route::post('post-login', 'AjaxController@postLogin');
Route::post('post-signup', 'AjaxController@postSignup');
Route::post('welcomeForm', 'AjaxController@welcomeForm');
Route::post('completeSurveyForm', 'AjaxController@completeSurveyForm');
Route::post('getSubCategory', 'AjaxController@getSubCategory');
Route::post('updateUserPic', 'AjaxController@updateUserPic');
Route::post('changeProfilePic', 'AjaxController@changeProfilePic');
Route::post('userMessage', 'AjaxController@userMessage');
Route::post('userRating', 'AjaxController@userRating');
Route::post('userSubscriptionUpdate', 'AjaxController@userSubscriptionUpdate');
Route::post('addPromoImage', 'AjaxController@addPromoImage');
Route::get('getUserAdminInfo', 'AjaxController@getUserAdminInfo');

// USER SURVEY CONTROLLER
Route::middleware('check_for_survey')->group(function () {
    Route::get('welcome', 'UserSurveyController@welcome')->name('user_survey.welcome');
    Route::get('submitWelcome', 'UserSurveyController@submitWelcome')->name('submitWelcome');
    Route::get('business', 'UserSurveyController@survey')->name('user_survey.survey');
    Route::post('submitSurvey', 'UserSurveyController@submitSurvey')->name('submitSurvey');
    Route::get('primary-goals', 'UserSurveyController@survey1')->name('user_survey.survey-1');
    Route::post('submitSurvey1', 'UserSurveyController@submitSurvey1')->name('submitSurvey1');
    Route::get('obtain-services', 'UserSurveyController@surveyForObtainBusiness')->name('user_survey.surveyForObtainBusines');
    Route::post('submitSurvey01', 'UserSurveyController@submitSurvey01')->name('submitSurvey01');
    Route::get('services', 'UserSurveyController@survey2')->name('user_survey.survey-2');
    Route::post('submitSurvey2', 'UserSurveyController@submitSurvey2')->name('submitSurvey2');
    Route::get('products', 'UserSurveyController@survey3')->name('user_survey.survey-3');
    Route::post('submitSurvey3', 'UserSurveyController@submitSurvey3')->name('submitSurvey3');
    Route::get('location', 'UserSurveyController@survey4')->name('user_survey.survey-4');
    Route::post('submitSurvey4', 'UserSurveyController@submitSurvey4')->name('submitSurvey4');
    Route::get('questions', 'UserSurveyController@survey5')->name('user_survey.survey-5');
    Route::post('submitSurvey5', 'UserSurveyController@submitSurvey5')->name('submitSurvey5');
    Route::get('congrats', 'UserSurveyController@congrats')->name('user_survey.congrats');
    Route::post('congrats', 'UserSurveyController@congrats')->name('congrats');
});
Route::get('FAQ', 'UserSurveyController@FAQ')->name('FAQ');
Route::get('pending', 'UserSurveyController@pending')->name('pending');

// skipSurveyQuestion
Route::get('skipSurveyQuestion/{page}', 'UserSurveyController@skipSurveyQuestion')->name('skipSurveyQuestion');

// SURVEY CONTROLLER
Route::get('home', 'SurveyController@home')->name('home');
Route::post('userProfileSession', 'SurveyController@userProfileSession');
Route::get('/user-profile/{id}', 'SurveyController@userProfile')->name('user-profile');
Route::post('/create-project', 'SurveyController@createProject')->name('create-project');

// RATINGS
Route::get('/user-ratings', 'SurveyController@userRatings')->name('user_ratings');

// SUBSCRIPTION
Route::get('subscription', 'SurveyController@subscription')->name('subscription');
Route::post('payment', 'SurveyController@payment')->name('payment');
Route::post('userReview', 'SurveyController@userReview');
Route::get('freeSubscription', 'SurveyController@freeSubscription')->name('freeSubscription');
Route::get('connect', 'SurveyController@connectLeads')->name('user.connect-leads');
Route::get('my-profile/{id?}', 'SurveyController@myProfile')->name('users.my-profile');
Route::get('/edit-profile/{token}', 'SurveyController@editProfile')->name('users.edit-profile');
Route::post('updateUserProfile', 'SurveyController@updateUserProfile')->name('updateUserProfile');
Route::get('business-profile', 'SurveyController@businessProfile')->name('users.business-profile');
Route::get('edit-business-profile', 'SurveyController@editBusinessProfile')->name('users.edit-business-profile');
Route::post('updateBusiness', 'SurveyController@updateBusiness')->name('updateBusiness');
Route::get('edit-survey', 'SurveyController@editSurvey')->name('users.edit-survey');
Route::get('collaboration-matches', 'SurveyController@collaborationMatches')->name('connection.collaboration_matches');
Route::get('more-collaboration-matches', 'SurveyController@moreCollaborationMatches');
Route::post('moreCollaborationMatchesSession', 'SurveyController@moreCollaborationMatchesSession')->name('moreCollaborationMatchesSession');
Route::post('filterForMatchingPending', 'SurveyController@filterForMatchingPending');
Route::get('find-connections', 'SurveyController@findProductServices')->name('connection.find_products_services');
Route::get('more-obtain-matches', 'SurveyController@moreObtainMatches');
Route::post('moreObtainMatchesSession', 'SurveyController@moreObtainMatchesSession')->name('moreObtainMatchesSession');
Route::get('provide-connections', 'SurveyController@provideProductServices')->name('connection.provide_services_products');
Route::get('more-provide-matches', 'SurveyController@moreProvideMatches');
Route::post('moreProvideMatchesSession', 'SurveyController@moreProvideMatchesSession')->name('moreProvideMatchesSession');
Route::post('updateCompanyName', 'SurveyController@updateCompanyName')->name('updateCompanyName');
Route::post('adView', 'SurveyController@adView');

// MANGE PROMO
Route::get('manage-promo', 'SurveyController@managePromo')->name('manage-promo');
Route::post('addMangePromoUrl', 'SurveyController@addMangePromoUrl')->name('addMangePromoUrl');
Route::get('sendForApprovalPromo', 'SurveyController@sendForApprovalPromo')->name('sendForApprovalPromo');
Route::get('removePromoImage', 'SurveyController@removePromoImage')->name('removePromoImage');

// AJAX CONTROLLER
Route::get('getSurveyData', 'AjaxController@getSurveyData');
Route::get('editPrimaryGoals', 'AjaxController@editPrimaryGoals')->name('editPrimaryGoals');

// MESSAGE CONTROLLER
Route::get('messages/{searchId}', 'MessagesController@messages')->name('messages.messages');
Route::post('chatHistory', 'MessagesController@chatHistory')->name('chatHistory');
Route::post('sendMessage', 'MessagesController@sendMessage')->name('sendMessage');
Route::get('inbox', 'MessagesController@inbox')->name('messages.inbox');

// EDIT SURVEY CONTROLLER
Route::get('edit-survey-1', 'EditSurveyController@editSurvey1')->name('edit_survey.survey-1');
Route::post('submitEditedSurvey1', 'EditSurveyController@submitEditedSurvey1')->name('submitEditedSurvey1');
Route::get('edit-survey-2', 'EditSurveyController@editSurvey2')->name('edit_survey.survey-2');
Route::post('submitEditedSurvey2', 'EditSurveyController@submitEditedSurvey2');
Route::get('edit-survey-02', 'EditSurveyController@editSurvey02')->name('edit_survey.survey-02');
Route::post('submitEditedSurvey02', 'EditSurveyController@submitEditedSurvey02')->name('submitEditedSurvey02');
Route::get('edit-survey-3', 'EditSurveyController@editSurvey3')->name('edit_survey.survey-3');
Route::post('submitEditedSurvey3', 'EditSurveyController@submitEditedSurvey3');
Route::get('edit-survey-4', 'EditSurveyController@editSurvey4')->name('edit_survey.survey-4');
Route::post('submitEditedSurvey4', 'EditSurveyController@submitEditedSurvey4');
Route::get('edit-location', 'EditSurveyController@editSurvey5')->name('edit_survey.survey-5');
Route::post('submitEditedSurvey5', 'EditSurveyController@submitEditedSurvey5')->name('submitEditedSurvey5');
Route::get('edit-survey-6', 'EditSurveyController@editSurvey6')->name('edit_survey.survey-6');
Route::post('submitEditedSurvey6', 'EditSurveyController@submitEditedSurvey6')->name('submitEditedSurvey6');

// skipEditSurveyQuestion
Route::get('skipEditSurveyQuestion/{page}', 'EditSurveyController@skipEditSurveyQuestion')->name('skipEditSurveyQuestion');

// ADMIN CONTROLLER
Route::prefix('admin')->group(function() {
    Route::get('/', function () {
        return redirect('admin/login');
    });

    // admin login
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('promo', 'Admin\AdminController@platinumPromo')->name('admin.bootstrap.manage_promo.platinum-promo');
    Route::POST('promo', 'Admin\AdminController@platinumPromo')->name('admin.bootstrap.manage_promo.platinum-promo');
    Route::get('promoApproval/{id}', 'Admin\AdminController@promoApproval')->name('promoApproval');
    Route::post('commentForRejectPromo', 'Admin\AdminController@commentForRejectPromo')->name('commentForRejectPromo');

    // admin new
    Route::match(array('GET', 'POST'), 'dashboard', 'Admin\UserController@admin')->name('bootstrap.admin-dashboard');
    Route::get('users', 'Admin\UserController@manageUsers1')->name('users.user1');
    Route::get('add-admin-user', 'Admin\UserController@addAdminUser')->name('users.add-admin-user');
    Route::post('add-admin-user', 'Admin\UserController@addAdminUser')->name('users.add-admin-user');
    Route::get('edit-admin-users', 'Admin\UserController@editAdminUser')->name('users.edit-admin-users');
    Route::get('user-detail/{id}', 'Admin\UserController@userDetail1')->name('users.user-detail1');
    Route::get('edit-user/{id}', 'Admin\UserController@editUser1')->name('users.edit-user1');
    Route::post('update-user', 'Admin\UserController@updateUser1')->name('users.update-user1');
    Route::get('survey/{id}', 'Admin\UserController@userSurvey1')->name('admin.bootstrap.users.user_survey');
    Route::get('userApproval/{id}', 'Admin\UserController@userApproval1')->name('users.userApproval1');
    Route::get('userRejected/{id}', 'Admin\UserController@userRejected1')->name('users.userRejected1');
    Route::get('userMakeAdmin/{id}', 'Admin\UserController@userMakeAdmin')->name('users.userMakeAdmin');
    Route::get('userRemoveAdmin/{id}', 'Admin\UserController@userRemoveAdmin')->name('users.userRemoveAdmin');
    Route::get('manage-home', 'Admin\UserController@manageHome')->name('admin.bootstrap.manage_home');
    Route::get('manage-ad', 'Admin\UserController@adManagement')->name('admin.bootstrap.ad_management');
    Route::post('storeAd', 'Admin\UserController@storeAd')->name('admin.bootstrap.storeAd');
    Route::post('removeAd', 'Admin\UserController@removeAd')->name('admin.bootstrap.removeAd');
    Route::get('subscriptions', 'Admin\UserController@subscriptions')->name('admin.bootstrap.subscriptions');

    // BUSINESS CONTROLLER
    Route::get('business', 'Admin\BusinessController@manageBusiness')->name('admin.bootstrap.business.manage-business');
    Route::get('matching-matrix', 'Admin\BusinessController@matchingMatrix')->name('admin.bootstrap.business.matching-matrix');

    //// NOT IN USE
    Route::get('view-business', 'Admin\BusinessController@viewBusiness')->name('admin.bootstrap.business.view-business');

    /// AJAX CONTRLLER
    Route::post('updateProfilePic', 'Admin\AjaxController@updateProfilePic');
    Route::post('saveProducts', 'Admin\AjaxController@saveProducts');
    Route::post('saveServices', 'Admin\AjaxController@saveServices');
    Route::post('serviceSubCategory', 'Admin\AjaxController@serviceSubCategory');
    Route::post('deleteProduct', 'Admin\AjaxController@deleteProduct');
    Route::post('deleteServices', 'Admin\AjaxController@deleteServices');
    Route::post('saveCollaboration', 'Admin\AjaxController@saveCollaboration');
    Route::post('saveForManageHome', 'Admin\AjaxController@saveForManageHome');

    // CATEGORY CONTROLLER
    Route::get('category', 'Admin\CategoryController@surveyCategory')->name('category.categories');
    Route::get('questions', 'Admin\CategoryController@surveyQuestions')->name('category.questions');
    Route::get('service-category', 'Admin\CategoryController@serviceCategory1')->name('category.service-category1');
    Route::get('add-service-category', 'Admin\CategoryController@addServiceCategory1')->name('category.add-service-category1');
    Route::post('store-service-category', 'Admin\CategoryController@storeServiceCategory1')->name('category.store-service-category1');
    Route::get('edit-service-category/{id}', 'Admin\CategoryController@editServiceCategory')->name('category.edit-service-category');
    Route::post('updateServiceCategory', 'Admin\CategoryController@updateServiceCategory')->name('updateServiceCategory');
    Route::get('deleteServiceCategory/{id}', 'Admin\CategoryController@deleteServiceCategory')->name('deleteServiceCategory');

    // AJAX CONTRLLER
    Route::post('updateServiceSubCategory', 'Admin\AjaxController@updateServiceSubCategory');
    Route::post('deleteServiceSubCategory', 'Admin\AjaxController@deleteServiceSubCategory');
    Route::post('addMoreSubCategory', 'Admin\AjaxController@addMoreSubCategory');
    Route::get('product-category', 'Admin\CategoryController@productCategory1')->name('category.product-category1');
    Route::get('add-product-category', 'Admin\CategoryController@addProductCategory1')->name('category.add-product-category1');
    Route::post('store-product-category', 'Admin\CategoryController@storeProductCategory1')->name('category.store-product-category1');
    Route::get('deleteProductCat/{id}', 'Admin\CategoryController@deleteProductCat')->name('deleteProductCat');
    Route::get('deleteContactMessages', 'Admin\AjaxController@deleteContactMessages')->name('deleteContactMessages');

    // contact us message
    Route::get('messages', 'Admin\CategoryController@contactUsMessages')->name('messages');

    // AJAX CONTRLLER
    Route::post('updateProductCategory', 'Admin\AjaxController@updateProductCategory');
    Route::get('industry', 'Admin\CategoryController@productIndustry1')->name('category.product-industry1');
    Route::get('add-industry', 'Admin\CategoryController@addProductIndustry1')->name('category.add-product-industry1');
    Route::post('store-product-industry', 'Admin\CategoryController@storeProductIndustry1')->name('category.store-product-industry1');
    Route::get('deleteProductIndustry/{id}', 'Admin\CategoryController@deleteProductIndustry')->name('deleteProductIndustry');

    // AJAX CONTRLLER
    Route::post('updateIndustry', 'Admin\AjaxController@updateIndustry');
    Route::get('pages', 'Admin\CategoryController@pages1')->name('category.pages1');
    Route::get('survey-1', 'Admin\CategoryController@manageSurvey1')->name('pages.survey-1');
    Route::post('updateWelcome', 'Admin\CategoryController@updateWelcome')->name('updateWelcome');

    // AJAX CONTRLLER
    Route::post('updateWelcomeImage', 'Admin\AjaxController@updateWelcomeImage');
    Route::get('survey-2', 'Admin\CategoryController@manageSurvey2')->name('pages.survey-2');
    Route::post('updateSurvey2', 'Admin\CategoryController@updateSurvey2')->name('updateSurvey2');
    Route::get('survey-3', 'Admin\CategoryController@manageSurvey3')->name('pages.survey-3');
    Route::post('updateSurvey3', 'Admin\CategoryController@updateSurvey3')->name('updateSurvey3');
    Route::get('add-data-3', 'Admin\CategoryController@addDataForSurvey3')->name('pages.add-survey-3');
    Route::post('storeData-3', 'Admin\CategoryController@storeDataForSurvey3')->name('storeData-3');
    Route::get('survey-01', 'Admin\CategoryController@managePageForObtainBusiness')->name('pages.manage_pageForObtainBusiness');
    Route::post('updateSurvey01', 'Admin\CategoryController@updateSurvey01')->name('updateSurvey01');
    Route::get('survey-4', 'Admin\CategoryController@manageSurvey4')->name('pages.survey-4');
    Route::post('updateSurvey4', 'Admin\CategoryController@updateSurvey4')->name('updateSurvey4');
    Route::get('survey-5', 'Admin\CategoryController@manageSurvey5')->name('pages.survey-5');
    Route::post('updateSurvey5', 'Admin\CategoryController@updateSurvey5')->name('updateSurvey5');
    Route::get('survey-6', 'Admin\CategoryController@manageSurvey6')->name('pages.survey-6');
    Route::post('updateSurvey6', 'Admin\CategoryController@updateSurvey6')->name('updateSurvey6');
    Route::get('survey-7', 'Admin\CategoryController@manageSurvey7')->name('pages.survey-7');
    Route::post('save-question', 'Admin\CategoryController@saveQuestion7')->name('save-question1');
    Route::get('deleteSurveyQuestion/{id}', 'Admin\CategoryController@deleteSurveyQuestion')->name('deleteSurveyQuestion');

    // AJAX CONTRLLER
    Route::post('updatePage7', 'Admin\AjaxController@updatePage7');
    Route::post('sortOrderForSurvey7', 'Admin\AjaxController@sortOrderForSurvey7');

    // FAQs
    Route::get('FAQ', 'Admin\CategoryController@viewFAQs')->name('bootstrap.FAQs');
    Route::get('add-FAQ', 'Admin\CategoryController@addFAQs')->name('bootstrap.add_FAQs');
    Route::post('storeFAQ', 'Admin\CategoryController@storeFAQ')->name('storeFAQ');
    Route::get('deleteFAQ/{id}', 'Admin\CategoryController@deleteFAQ')->name('deleteFAQ');
    Route::get('edit-FAQ/{id}', 'Admin\CategoryController@editFAQs')->name('bootstrap.edit_FAQs');
    Route::post('updateFAQ', 'Admin\CategoryController@updateFAQ')->name('updateFAQ');

    // AJAX CONTROLLER
    Route::post('delete-user', 'Admin\AjaxController@deleteUser');
    Route::post('update-password', 'Admin\AjaxController@updatePassword');
    Route::post('add-category', 'Admin\AjaxController@addCategory');
    Route::post('submit-question', 'Admin\AjaxController@addQuestion');
    Route::post('searchUserByName', 'Admin\AjaxController@searchUserByName');
    Route::post('searchAdminUserByName', 'Admin\AjaxController@searchAdminUserByName');
});
